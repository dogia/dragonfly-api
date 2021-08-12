<?php

require('../index.php');
require(DOCUMENT_SRC.DS.'autoload.php');

$public = array();

$file = '';

if(!file_exists($file)){
    Dogia\Dragonfly\Functions\respond("Can't solve your request", 404);
}


Dogia\Dragonfly\Functions\respond('Request without response');