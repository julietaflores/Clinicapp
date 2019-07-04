<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/ctipocita.php';


$otipocita  	= new tipocita();
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
		$idtipocita		= $data['idtipocita']; $tipo		= $data['tipo']; if($idtipocita==''){
									echo 1;
								}
								elseif($tipo==''){
									echo 2;
								}
								
		
		else {
			$params = array($tipo);
			$id   = $otipocita->nuevo($params);
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

	$idtipocita		= $data['idtipocita'];  
		$tipo		= $data['tipo'];  
		if($idtipocita==''){
									echo 1;
								}
								elseif($tipo==''){
									echo 2;
								}
								
		
		else {
			try {
			
			$params = array($tipo,$idtipocita);
			$save   = $otipocita->actualizar($params);
			
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

if($option=="btipocita"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipocita->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="htipocita"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipocita->habilitar($id);
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
		$update   = $otipocita->eliminar($id);
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