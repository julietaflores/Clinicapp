<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cUsuario.php';


$ousuario  	= new Usuario();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

if ( $option == 'n' ) {
	try{
			// if(isset($_SESSION['csmart']['foto'])){
			// 	$img= $_SESSION['csmart']['foto'];  
			// }else{
			// 	$img = "user.png";
			// }
		    $nombre		= $data['name'];  
		    $apellido		= $data['apellido'];  
		    $usuario		= $data['usuario'];  
		    $clave		= sha1($data['clave']);  
		    $telefono		= $data['telefono'];  
		    $correo		= $data['correo'];  
		    $imagen		= $data['img'];
		    $notas		= $data['notas'];  
		    $idtipoUsuario		= $data['idtipoUsuario'];  
		    $idclinica		= $data['idclinica'];; 
		    $idestado		= $data['idestado']; 		
		
			$params = array($nombre,$apellido,$usuario,$clave,$telefono,$correo,$imagen,$notas,$idtipoUsuario,$idclinica,$idestado);
			$id   = $ousuario->nuevo($params);
			if ( $id ) {
				echo $id;
			} else {
				echo 0;
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {
			// if(isset($_SESSION['csmart']['foto'])){
			// 	$img= $_SESSION['csmart']['foto'];  
			// }else{
			// 	$img = "user.png";
			// }
			$idusuario	= $data['idusuario'];  
			$nombre		= $data['name'];  
		    $apellido	= $data['apellido'];  
		    $usuario	= $data['usuario'];  
		    $clave		= sha1($data['clave']);  
		    $telefono	= $data['telefono'];  
		    $correo		= $data['correo'];  
		    $imagen		= $data['img'];  
		    $notas		= $data['notas'];  
		    $idtipoUsuario		= $data['idtipoUsuario'];  
		    $idclinica		= $data['idclinica']; 
		    $idestado		= $data['idestado']; 


		    if($nombre==''){
				echo 1;
			}
								
		
		else {
			try {
			
			$params = array($nombre,$apellido,$usuario,$clave,$telefono,$correo,$imagen,$notas,$idtipoUsuario,$idclinica,$idestado,$idusuario);
			$save   = $ousuario->actualizar($params);
			
			if ( $save ) {
				echo $idusuario;
			} else {
				echo "0";
			}
		}catch (Exception $e){
			echo  $e;
		}
	}
}

if($option=="busuario"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ousuario->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="husuario"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ousuario->habilitar($id);
		if ( $update ) {
			
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}
if($option=="e"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ousuario->eliminar($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}


?>