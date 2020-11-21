<?php

$servidor = "mysql:dbname=empresa;host=127.0.0.1";
$usuario = "root";
$password = "";

try{
    $pdo = new PDO($servidor,$usuario,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    //echo 'CONECTADO..';
    //<script>alert("Conectado..")</script>
}catch(PDOException $e){
    //echo "Conexion fallida..( ".$e->getMessage(); //para mostrar error
}

?>