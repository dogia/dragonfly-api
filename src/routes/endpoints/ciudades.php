<?php

require DOCUMENT_SRC.DS."database.php";

$table = "ciudades";
$primary_key = "id";

function create(){

}

function read($id = null){
    global $table, $primary_key, $db_connection;
    $sql = '';

    $db = new DB();
    if($id === null){
        $sql = "SELECT * FROM $table";
        $db->query($sql);
        $db->flush();
    }else{
        $sql = "SELECT * FROM $table WHERE $primary_key = '?' LIMIT 1";
        $db->query($sql, $id);
        $db->flush();
    }

    if(!$db->getResult()){
        respond("DB Error");
    }else{
        respond($db->getArray());
    }
}

function update(){

}

function delete(){

}