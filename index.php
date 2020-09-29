<?php 

require_once "Clases/token.php";

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? "";
$headers = getallheaders();
$token = $headers['token']??null;
$mensaje = "";



switch($path){


    default:
    echo "Direccion Invalida";
    break;
}