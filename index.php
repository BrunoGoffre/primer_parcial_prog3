<?php 

require_once "Clases/token.php";
require_once "Clases/archivos.php";
require_once "Clases/usuario.php";
require_once "Clases/Auto.php";

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? "";
$headers = getallheaders();
$token = $headers['token']??null;
$mensaje = "";



switch($path){
    
    case '/registro':

        if ($method == 'POST'){

            $email = $_POST['email'] ?? null;
            $tipo = $_POST['tipo'] ?? null;
            $pass = $_POST['password'] ?? null;
            $foto = $_FILES['imagen'] ?? null;

            if ($email != null && $tipo != null && $pass != null && $foto != null){
                if ($tipo == "admin" || $tipo == "user"){
                    
                    $nuevoUsuario = new Usuario($email,$tipo,$pass,Usuario::CargarFotoUsuario('imagen',"Fotos"));
                    if (Usuario::GuardarNuevoUsuario($nuevoUsuario)){
                        $mensaje = "Guardado correctamente";
                    }
                    else{
                        $mensaje = "Error al guardar, Mail registrado";
                    }
                }else{
                    $mensaje = "Seleccion un tipo de usuario valido";
                }
            }
        }else{
            $mensaje = "Metodo invalido";
        }
         echo $mensaje;
    break;
    case '/login':
        if ($method == 'POST'){

            $email = $_POST['email'] ?? null;
            $pass = $_POST['password'] ?? null;

            if ($email != null &&  $pass != null){
               $user = new Usuario($email,"",$pass,"");
               $validado = Usuario::ValidarUsuario($user);

               if ($validado != null){
                   $mensaje = Token::GenerarToken($validado->_email,$validado->_tipo);
               }else{
                   $mensaje = "Usuario inexsistente";
               }
            }else{
                $mensaje = "Error en los parametros";
            }
        }else{
            $mensaje = "Metodo invalido";
        }
         echo $mensaje;

    break;
    case '/ingreso':
        if (Token::AutenticarToken($token) != false){

            if ($method == 'POST'){
                if (!Usuario::ValidarSoloTipoUser(Token::AutenticarToken($token))){
                    
                    $patente = $_POST['patente'] ?? null;
                    $email = Auto::ObtenerMail(Token::AutenticarToken($token));
                    
                    if ($patente && $email){
                        
                        $auto = new Auto($patente,$email);
                        if (Archivos::GuardaJson("autos.xxx",$auto)){
                            $mensaje = "Guardado correctamente";
                        }else{
                            $mensaje = "Error al guardar";
                        }
                    }else{
                        $mensaje = "Error en los parametros";
                    }

                }                   
                else{
                    $mensaje = "Metodo permitodo solo para users";
                }
            }else if ($method == 'GET'){
                Auto::MostrarAutos();
            }
        }else{
            $mensaje = "Error de autenticacaion";
        }
        echo $mensaje;

    break;

    case '/retiro':
        if (Token::AutenticarToken($token) != false){

            if ($method == 'GET'){
                if (!Usuario::ValidarSoloTipoUser(Token::AutenticarToken($token))){
                    
                    $patente = $_POST['patente'] ?? null;
                    $email = Auto::ObtenerMail(Token::AutenticarToken($token));
                    
                    if ($patente && $email){
                        
                        
                    }else{
                        $mensaje = "Error en los parametros";
                    }

                }                   
                else{
                    $mensaje = "Metodo permitodo solo para users";
                }
            }else{
                $mensaje = "Metodo invalido";
            }
        }else{
            $mensaje = "Error de autenticacaion";
        }
        echo $mensaje;

    break;
    case '/ingreso':
        
    default:
    echo "Ruta Invalida";
    break;
}