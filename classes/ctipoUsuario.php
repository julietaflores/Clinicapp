<?php

class tipoUsuario{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idtipoUsuario,nombre FROM tipoUsuario where idtipoUsuario>1;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idtipoUsuario'];
				   	$info[$id]['idtipoUsuario']	= $rs->fields['idtipoUsuario'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								
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
        $sql = "SELECT * FROM tipoUsuario WHERE idtipoUsuario = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idtipoUsuario'];
				   	$info[$id]['idtipoUsuario']	= $rs->fields['idtipoUsuario'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								
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
		
			$sql = "INSERT INTO tipoUsuario (nombre) VALUES (?);";
				 
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
		
			$sql = "UPDATE tipoUsuario SET nombre=? WHERE idtipoUsuario = ?";
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
        $sql = "UPDATE tipoUsuario SET estado = 2 WHERE idtipoUsuario = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE tipoUsuario SET estado = 1 WHERE idtipoUsuario = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from tipoUsuario where idtipoUsuario = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>