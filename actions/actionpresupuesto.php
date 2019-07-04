<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cpresupuesto.php';


$opresupuesto  	= new presupuesto();
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
		$nombre		= $data['nombre']; 
		$fecha		= $data['fecha']; 
		$duracion		= $data['duracion']; 
		$pagoinicial		= $data['pagoinicial']; 
		$monto		= $data['monto']; 
		$numcuotas		= $data['numcuotas']; 
		$valcuotas		= $data['valcuotas']; 
		$detalle		= $data['detalle']; 
		$idusuario		= $_SESSION['csmart']['idusuario']; 
		$idtipotratamiento		= $data['idtipotratamiento']; 
		$plantilla		= $data['plantilla']; 
		$telefono		= $data['telefono']; 
		$correo		= $data['correo']; 
		$idestado		= 1; 


			$params = array($nombre,$fecha,$duracion,$pagoinicial,$numcuotas,$valcuotas,$detalle,$idusuario,$idtipotratamiento,$plantilla,$telefono,$correo,$idestado,$monto);
			$id   = $opresupuesto->nuevo($params);
			if ( $id ) {

				for($i=1;$i<=$data['linea'];$i++){
					if(isset($data['idproducto_'.$i])){
						$idproducto		= $data['idproducto_'.$i]; 
						$valor			= $data['valor_'.$i]; 
						$cantidad		= $data['cantidad_'.$i]; 

						$params = array($id,$idproducto, $valor, $cantidad);
						$val = $opresupuesto->nuevoDetalle($params);
					}
				}

				echo "0";
			} else {
				echo "400";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idpresupuesto		= $data['idpresupuesto'];  
		$nombre		= $data['nombre'];  
		$fecha		= $data['fecha'];  
		$duracion		= $data['duracion'];  
		$pagoinicial		= $data['pagoinicial'];  
		$numcuotas		= $data['numcuotas'];  
		$valcuotas		= $data['valcuotas'];  
		$detalle		= $data['detalle'];  
		$idusuario		= $_SESSION['csmart']['idusuario'];  
		$idtipotratamiento		= $data['idtipotratamiento'];  
		$plantilla		= $data['plantilla'];  
		$telefono		= $data['telefono'];  
		$correo		= $data['correo'];  
		
		try {
			
			$params = array($nombre,$fecha,$duracion,$pagoinicial,$numcuotas,$valcuotas,$detalle,$idusuario,$idtipotratamiento,$plantilla,$telefono,$correo,$idpresupuesto);
			$save   = $opresupuesto->actualizar($params);
			
			if ( $save ) {
				$val   = $opresupuesto->borrarItems($idpresupuesto);
			
				for($i=1;$i<=$data['linea'];$i++){
					if(isset($data['idproducto_'.$i])){
						$idproducto		= $data['idproducto_'.$i]; 
						$valor			= $data['valor_'.$i]; 
						$cantidad		= $data['cantidad_'.$i]; 

						$params = array($idpresupuesto,$idproducto, $valor, $cantidad);
						$val = $opresupuesto->nuevoDetalle($params);
					}
				}
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}

if($option=="bpresupuesto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opresupuesto->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hpresupuesto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opresupuesto->habilitar($id);
		if ( $update ) {
			
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}
if($option=="ppresupuesto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opresupuesto->pendiente($id);
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
		$update   = $opresupuesto->eliminar($id);
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