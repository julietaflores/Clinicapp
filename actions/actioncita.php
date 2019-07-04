<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/ccita.php';
include_once '../classes/cfactura.php';


$ocita  	= new cita();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

$option 	= $_REQUEST['opt'];

if($option == 'j'){
	
	echo $ocita->getAlljson();
	//echo "[{\"id\":\"14\",\"title\":\"New Event\",\"start\":\"2016-06-24 16:00:00\",\"allDay\":false}]";
}

if($option == 'ja'){
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$url = $_POST['url'];
	$allDay = $_POST['allDay'];
	$idusuario		= $_POST['idusuario']; 
	$idestado		= 1;//$data['idestado']; 
		$comentario		= $_POST['detalle']; 
		$idtipocita		= $_POST['tipocita']; 
		$idpaciente		= $_POST['idpaciente']; 
		
	$params = array($idusuario,$title,$start,$end,$idestado,$comentario,$idtipocita,$idpaciente,$allDay,$url);
	$id   = $ocita->nuevo($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
}
if($option == 'jm'){
	$start = $_POST['start'];
	$end = $_POST['end'];
	$id	= $_POST['id']; 
		
		
	$params = array($start,$end,$id);
	$id   = $ocita->modificarCita($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
}
if($option == 'jr'){
	$id	= $_POST['id']; 
		
	$id   = $ocita->eliminar($id);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
}

if($option == 'control'){
	$id = $_POST['id'];
	$maxSup = $_POST['maxSup'];
	$maxInf = $_POST['maxInf'];
	$observaciones	= $_POST['observaciones']; 
	$valor = $_POST['valor'];		
	$factura = $_POST['factura'];		
		
	$params = array($maxSup,$maxInf,$observaciones,$valor,$factura,$id);
	$id   = $ocita->modificarCitaControl($params);
			if ( $id ) {
				if($factura=1){
					//generar factura
					$idpaciente = $_POST['idpaciente'];		
					$ofactura  	= new factura();
					$fecha = date("Y-m-d");
    
					$params2 = array($valor,2,$fecha,'Factura',$idpaciente,0);
					$idfact   = $ofactura->nuevo($params2);
					$params = array(1,$valor,$idfact,5);
					$val = $ofactura->nuevoDetalle($params);
				}
				echo "0";
			} else {
				echo "400";
			}
}

if ( $option == 'n' ) {
	try{
		$idcita		= $data['idcita']; 
		$idusuario		= $data['idusuario']; 
		$fecha		= $data['fecha']; 
		$fecha_prog		= $data['fecha_prog']; 
		$idestado		= $data['idestado']; 
		$comentario		= $data['comentario']; 
		$idtipocita		= $data['idtipocita']; 
		$idpaciente		= $data['idpaciente']; 

		if($idcita==''){
									echo 1;
								}
								elseif($idusuario==''){
									echo 2;
								}
								elseif($fecha==''){
									echo 3;
								}
								elseif($fecha_prog==''){
									echo 4;
								}
								elseif($idestado==''){
									echo 5;
								}
								elseif($comentario==''){
									echo 6;
								}
								elseif($idtipocita==''){
									echo 7;
								}
								elseif($idpaciente==''){
									echo 8;
								}
								
		
		else {
			$params = array($idusuario,$fecha,$fecha_prog,$idestado,$comentario,$idtipocita,$idpaciente);
			$id   = $ocita->nuevo($params);
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

	$idcita		= $data['idcita'];  
		$idusuario		= $data['idusuario'];  
		$fecha		= $data['fecha'];  
		$fecha_prog		= $data['fecha_prog'];  
		$idestado		= $data['idestado'];  
		$comentario		= $data['comentario'];  
		$idtipocita		= $data['idtipocita'];  
		$idpaciente		= $data['idpaciente'];  
		if($idcita==''){
									echo 1;
								}
								elseif($idusuario==''){
									echo 2;
								}
								elseif($fecha==''){
									echo 3;
								}
								elseif($fecha_prog==''){
									echo 4;
								}
								elseif($idestado==''){
									echo 5;
								}
								elseif($comentario==''){
									echo 6;
								}
								elseif($idtipocita==''){
									echo 7;
								}
								elseif($idpaciente==''){
									echo 8;
								}
								
		
		else {
			try {
			
			$params = array($idusuario,$fecha,$fecha_prog,$idestado,$comentario,$idtipocita,$idpaciente,$idcita);
			$save   = $ocita->actualizar($params);
			
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

if($option=="bcita"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ocita->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hcita"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ocita->habilitar($id);
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
		$update   = $ocita->eliminar($id);
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