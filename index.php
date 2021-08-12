<?php

const DS = DIRECTORY_SEPARATOR;
define('DOCUMENT_ROOT', dirname(__FILE__));
define('DOCUMENT_SRC', dirname(__FILE__).DS.'src');

require_once DOCUMENT_SRC.DS.'functions.php';
$error_handler = set_error_handler('error_handler', E_ALL);