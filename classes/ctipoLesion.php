		<?php

class tipoLesion{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idtipoLesion,nombre,icono,estado FROM tipoLesion;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idtipoLesion'];
				   	$info[$id]['idtipoLesion']	= $rs->fields['idtipoLesion'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['icono']	= $rs->fields['icono'];
								$info[$id]['estado']	= $rs->fields['estado'];
								
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
        $sql = "SELECT * FROM tipoLesion WHERE idtipoLesion = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idtipoLesion'];
				   	$info[$id]['idtipoLesion']	= $rs->fields['idtipoLesion'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['icono']	= $rs->fields['icono'];
								$info[$id]['estado']	= $rs->fields['estado'];
								
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
		
			$sql = "INSERT INTO tipoLesion (nombre,icono,estado) VALUES (?,?,?);";
				 
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
		
			$sql = "UPDATE tipoLesion SET nombre=?,icono=?,estado=? WHERE idtipoLesion = ?";
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
        $sql = "UPDATE tipoLesion SET estado = 2 WHERE idtipoLesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE tipoLesion SET estado = 1 WHERE idtipoLesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from tipoLesion where idtipoLesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		