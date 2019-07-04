<?php
// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cUsuario.php';


$oUsuario     	= new Usuario();
session_start();
if (isset($_REQUEST['opt'])) 
{
  $option = $_REQUEST['opt']; 
}
/* ---- Login ---- */

if ( $option == 'login' ) {
	try{
		//parametros
		$user_name   = $_REQUEST['user'];
		$user_pass   = $_REQUEST['pass'];
		$login = $oUsuario->ingreso($user_name, $user_pass);
		if ( $login ) {
			echo "done";
		} else {
			echo "error";
		}
	}catch (Exception $e){
		echo "error";
	}
}
/* ---- /Login ---- */


?>