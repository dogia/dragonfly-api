<?php


require('../index.php');
require(DOCUMENT_ROOT.DS.'vendor'.DS.'autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(DOCUMENT_ROOT);
$dotenv->load();

$public = array();

$file = '';

if(!file_exists($file)){
    respond("Can't solve your request", 404);
}


respond('Request without response');