<?php
/*
* File: dataBase.php
*/

/**
* Conexion centralizada con la base de datos a traves de ADOdb
*/

if (preg_match('/'.basename (__FILE__).'/', $_SERVER['PHP_SELF']))
        die ("CONTEXT ERROR!");

// Libreria ADOdb para manejo de bases de datos
include_once ("adodb/adodb.inc.php");
include_once ("adodb/adodb-exceptions.inc.php");

// Parametros de configuracion
// Server
$driver   = "mysql";
$host     = "localhost";
$scheme   = "clinica";
$user     = "root";
$password = 'root';

$host     = "192.254.185.66";
$scheme   = "rigoarri_clinicapp";
$user     = "rigoarri_clinica";
$password = 'cl1n1c@pp';


// zW4RYf-1ys1saKf_W_zj
// token gitlab

// Definir el objeto de la conexion
$DATA = null;
try {
	$DATA = NewADOConnection ($driver);
	//$DATA->debug = true;
	$DATA->Connect ($host, $user, $password, $scheme);
	$DATA->SetFetchMode (ADODB_FETCH_ASSOC);
} catch (exception $e) {
	echo "DATA ERROR: ".$e->msg;
	exit;
}
?>