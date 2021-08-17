<?php


require('../index.php');
require(DOCUMENT_ROOT.DS.'vendor'.DS.'autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(DOCUMENT_ROOT);
$dotenv->load();

$public = array(
    'cotizadores'
);

$request = $_GET['request'];
$request = explode('/', $request);

$file = DOCUMENT_SRC.DS."routes".DS."$request[0]/$request[1].php";

if(!file_exists($file)){
    respond("Can't solve your request", 404);
}else{
    // TODO: Agregar funcionalidad para directorios públicos
    require $file;
    require DOCUMENT_SRC.DS."routes".DS."request_controller.php";
}


respond('Request without response');