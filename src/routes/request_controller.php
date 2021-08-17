<?php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'PUT':
        update();
        break;
    case 'POST':
        create();
        break;
    case 'GET':
        if(isset($request[2])) read($request[2]);
        else read();
        break;
    case 'DELETE':
        delete();
        break;
    default:
        respond('Method is not supported');
        break;
}
