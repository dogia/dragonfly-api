<?php

class DB {
    private static $link = null;
    private static $config = null;
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

    public static function disconnect(){
        switch(DB::$config['type']){
            case 'mysql':
            case 'mariadb':
                mysqli_close(DB::$link);
                break;
        }
    }
}