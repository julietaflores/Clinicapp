<?php

class notas{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idnota,idestado,detalle,idusuario,fecha FROM notas;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idnota'];
				   	$info[$id]['idnota']	= $rs->fields['idnota'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getAllusuario($id)
    {
        $sql = "SELECT idnota,idestado,detalle,idusuario,fecha FROM notas WHERE idusuario=$id and idestado=1;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idnota'];
				   	$info[$id]['idnota']	= $rs->fields['idnota'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	function getOne($id)
    {
        $sql = "SELECT * FROM notas WHERE idnota = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idnota'];
				   	$info[$id]['idnota']	= $rs->fields['idnota'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }


	function nuevo($params) 
	{
		try{
		
			$sql = "INSERT INTO notas (idestado,detalle,idusuario) VALUES (?,?,?);";
				 
			$save = $this->DATA->Execute($sql, $params);
			$id 	= $this->DATA->Insert_ID();
			if ($save){
				return $id;
			} else {
				return false;
			}
		}catch(exception $e){
			return false;
		}
        
    }

	function actualizar($params) 
	{
		try{
		
			$sql = "UPDATE notas SET idestado=?,detalle=?,idusuario=?,fecha=? WHERE idnota = ?";
			$save = $this->DATA->Execute($sql, $params);
			if ($save){
				return true;
			} else {
				return false;
			}
		}catch(exception $e){
			return false;
		}
        
    }
	
	function bloqueo($id) {
        $sql = "UPDATE notas SET idestado = 2 WHERE idnota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE notas SET estado = 1 WHERE idnota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from notas where idnota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		