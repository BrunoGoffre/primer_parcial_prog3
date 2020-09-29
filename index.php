<?php 

require_once "Clases/token.php";
require_once "Clases/archivos.php";

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? "";
$headers = getallheaders();
$token = $headers['token']??null;
$mensaje = "";



switch($path){
    case '':
    break;

    default:
    echo "Direccion Invalida";
    break;
}