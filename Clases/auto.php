<?php

class Auto{
    var $_patente;
    var $_fecha;
    var $_email;
    var $_fecha_egreso;

    public function __construct($patente,$email,$fechaEgreso=0){
        $this->_patente = $patente;
        $this->_fecha = date("jS \of F Y");
        $this->_email = $email;
        $this->_fecha_egreso = $fechaEgreso;
    }

    public static function ObtenerMail($array){
        foreach ($array as $key => $value) {
            if ($key == "email"){
                return $value;
            }
        }
        return null;
    }
    public static function MostrarAutos(){
        $autos = Archivos::TraerJson("autos.xxx");
        sort($autos,1);
        foreach ($autos as $value) {
            Echo "<br>Patente: $value->_patente Fecha: $value->_fecha Email: $value->_email";
        }
    }
}

    