<?php

const INTEGRITY = true;
const DS = DIRECTORY_SEPARATOR;
define('DOCUMENT_ROOT', dirname(__FILE__));
define('DOCUMENT_SRC', dirname(__FILE__).DS.'src');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
