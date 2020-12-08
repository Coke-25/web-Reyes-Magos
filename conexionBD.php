<?php

class conectar{
    
    protected $_conexion;
    
    public function __construct(){
        $servidor = 'localhost';
        $usuario = 'coke';
        $clave = 'Studium2020';
        $baseDeDatos = 'reyesMagos';
        $this->_conexion = new mysqli($servidor, $usuario, $clave, $baseDeDatos);
        if (mysqli_connect_error()) {
            die('Error de Conexion (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
        }
        $this->_conexion->set_charset("utf8");
    }
    
    public function selectAll($table,$order=""){
        if($order!=""){
            $sql = 'SELECT * FROM '.$table.' ORDER BY '.$order;
        }else{
            $sql = 'SELECT * FROM '.$table;
        }
        return $this->_conexion->query($sql);
    }

    public function selectAllFK($ID,$idType="idNinioFK"){
        $sql = 'SELECT * FROM piden WHERE '.$idType.' = '.(int)$ID;
        return $this->_conexion->query($sql);
    }

    public function selectAllKings($ID){
        $sql = 'SELECT * FROM juguetes WHERE idReyFK = '.(int)$ID;
        return $this->_conexion->query($sql);
    }
    
    public function select($table,$ID){
        if($table=="reyes"){
            $sqlID = "idRey";
        }else if($table=="ninios"){
            $sqlID = "idNinio";
        }else if($table=="juguetes"){
            $sqlID = "idJuguete";
        }
        $sql = 'SELECT * FROM '.$table.' WHERE '.$sqlID.' = '.(int)$ID;
        $rows = $this->_conexion->query($sql);
        if((int)$rows->num_rows){
            $row = $rows->fetch_assoc();
        }else{
            $row = null;
        }
        return $row;
    }
    
    public function insertToy($IdNinio,$IdJuguete){
        $sql = 'INSERT INTO piden (idNinioFK, idJugueteFK) VALUES ('.$IdNinio.', '.$IdJuguete.')';
        return $this->_conexion->query($sql);
    }
}
?>