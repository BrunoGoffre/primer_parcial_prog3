<?php

class Usuario{
    var $_email;
    var $_tipo;
    var $_pass;
    var $_foto;

    public function __construct($email,$tipo,$pass,$foto){
        $this->_email = $email;
        $this->_tipo = $tipo;
        $this->_pass = $pass;
        $this->_foto = $foto;
    }

    public static function GuardarNuevoUsuario($usuarioNuevo){
        if (Usuario::ValidarEmail($usuarioNuevo)){
            Archivos::GuardaJson("usuarios.xxx",$usuarioNuevo);
            return true;
        }else
        {
            return false;
        }
    }
    public static function ValidarEmail($usuario){
        $retorno = true;
        $usuarios = Archivos::TraerJson("usuarios.xxx");
        if (isset($usuarios) && $usuario != null){
            foreach ($usuarios as $value) {
                if ($value->_email == $usuario->_email){
                    $retorno = false;
                }
            }
        }
        return $retorno;
    }
    public static function CargarFotoUsuario($file,$ruta){

                $origen = $_FILES[$file]['tmp_name'];
                $destino = "$ruta/".$_FILES[$file]['name'];
                move_uploaded_file($origen,$destino);
                return $destino;               
               
    }
            
    public static function ValidarUsuario($user){
            $retorno = null;
            $usuarios = Archivos::TraerJson("usuarios.xxx");
            foreach ($usuarios as $value) {
                if ($value->_pass == $user->_pass && $value->_email == $user->_email){
                    $retorno = $value;
                }else{
                    echo "no entre";
                }
            }
            return $retorno;
    }
                
    public static function ValidarSoloTipoUser($array){
        $retorno = false;
        foreach($array as $key => $value){
            if ($key == "tipo" && $value == "user"){
                $retorno = true;
            }  
        }
        return $retorno;
    }
    }

