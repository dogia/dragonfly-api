<?php

$response_api = array('response' => null, 'status' => null, 'errors' => array());

function error_handler($errno, $errstr, $errfile, $errline)
{
    global $response_api;
    $error = [
        'error_id' => $errno,
        'error_description' => $errstr,
        'file' => $errfile,
        'line' => $errline,
        'php_version' => PHP_VERSION,
        'sys_os' => PHP_OS
    ];
    switch ($errno) {
    case E_USER_ERROR:
        $error['level'] = 'fatal';
        $response_api['errors'][] = $error;
        respond($response_api);
        break;

    case E_USER_WARNING:
        $error['level'] = 'warning';
        $response_api['errors'][] = $error;
        break;

    case E_USER_NOTICE:
        $error['level'] = 'notice';
        $response_api['errors'][] = $error;
        break;

    default:
        $error['level'] = 'unknown';
        $response_api['errors'][] = $error;
        break;
    }

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

function format_utf8(&$response){
    $response = (array) $response;
    foreach($response as $key => $value){
        switch(gettype($value)){
            case 'array':
            case 'object':
                format_utf8($response[$key]);
                break;
            case 'string':
                $response[$key] = utf8_encode($value);
                break;
        }
    }
}

function respond(
    $response, 
    int $status = 200, 
    array $headers = array(
        'Content-Type: application/json'
    )
){
    global $response_api;
    switch(gettype($response)){
        case 'boolean': break;
        case 'integer': break;
        case 'double': break;
        case 'object': break;
        case 'array': break;
        case 'resource': break;
        case 'NULL': break;
        default: break;
    }

    http_response_code($status);
    foreach($headers as $header){
        header("$header", true, $status);
    }

    $response_api['response'] = $response;
    $response_api['status'] = $status;

    format_utf8($response_api);
    $response_api = json_encode($response_api);
    exit($response_api);
}