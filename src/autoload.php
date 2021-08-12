<?php

if(!defined('INTEGRITY')){
    die();
}

function load(array $files){
    foreach($files as $file){
        require(DOCUMENT_SRC.DS.$file.'.php');
    }
}

load(['functions']);