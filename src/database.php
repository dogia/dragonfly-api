<?php

class DB {
    private static $link = null;
    private static $config = null;
    private static $result = null;
    function __construct(){
        DB::$config = [
            'type' => $_ENV['DB_TYPE'],
            'host' => $_ENV['DB_HOST'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'port' => (int) $_ENV['DB_PORT'],
            'name' => $_ENV['DB_NAME']
        ];

        DB::connect();
    }

    public static function connect(){
        if(DB::$config == null) {
            respond('Database without valid configuration, check .env file!');
        }

        switch(DB::$config['type']){
            case 'mysql':
            case 'mariadb':
                $host = DB::$config['host'];
                $user = DB::$config['user'];
                $password = DB::$config['password'];
                $db = DB::$config['name'];
                $port = DB::$config['port'];
                
                DB::$link = mysqli_connect($host, $user, $password, $db, $port);
                break;
        }
    }

    private static function replaceInQuery(&$haystack, $replace){
        $replacePos = null;
        $i=0;
        $len = strlen($haystack);
        while($i < $len && $replacePos === null){
            $pos = strpos($haystack, '?', $i);
            $posScaped = strpos($haystack, '\\?', $i);
            
            if($pos != ($posScaped + 1) && $pos !== false || $posScaped === false){
                $replacePos = $pos;
            }else if($pos == ($posScaped + 1)){
                $i = $pos;
            }
            
            $i++;
        }
        if($replacePos === null){
            return;
        }
        $haystack = substr_replace($haystack, $replace, $pos, 1);
    }

    public static function query($template, ...$values){
        foreach($values as $value){
            $value = mysqli_real_escape_string(DB::$link, $value);
            $value = str_replace('?', '\?', $value);
            DB::replaceInQuery($template, $value);
        }
        $template = str_replace('\\?', '?', $template);

        DB::$result = mysqli_query(DB::$link, $template);
    }

    public static function getResult(){
        return DB::$result;
    }

    public static function getArray(){
        return mysqli_fetch_assoc(DB::$result);
    }

    public static function flush(){
        if(DB::$result){
            mysqli_free_result(DB::$result);
        }
    }

    public static function disconnect(){
        switch(DB::$config['type']){
            case 'mysql':
            case 'mariadb':
                mysqli_close(DB::$link);
                break;
        }
    }
}