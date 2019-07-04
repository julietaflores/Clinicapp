<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/ctipoLesion.php';


$otipoLesion  	= new tipoLesion();
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
		$idtipoLesion		= $data['idtipoLesion']; $nombre		= $data['nombre']; $icono		= $data['icono']; $estado		= $data['estado']; if($idtipoLesion==''){
									echo 1;
								}
								elseif($nombre==''){
									echo 2;
								}
								elseif($icono==''){
									echo 3;
								}
								elseif($estado==''){
									echo 4;
								}
								
		
		else {
			$params = array($nombre,$icono,$estado);
			$id   = $otipoLesion->nuevo($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
		}
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idtipoLesion		= $data['idtipoLesion'];  
		$nombre		= $data['nombre'];  
		$icono		= $data['icono'];  
		$estado		= $data['estado'];  
		if($idtipoLesion==''){
									echo 1;
								}
								elseif($nombre==''){
									echo 2;
								}
								elseif($icono==''){
									echo 3;
								}
								elseif($estado==''){
									echo 4;
								}
								
		
		else {
			try {
			
			$params = array($nombre,$icono,$estado,$idtipoLesion);
			$save   = $otipoLesion->actualizar($params);
			
			if ( $save ) {
				
				
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	}
}

if($option=="btipoLesion"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipoLesion->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="htipoLesion"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipoLesion->habilitar($id);
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
		$update   = $otipoLesion->eliminar($id);
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