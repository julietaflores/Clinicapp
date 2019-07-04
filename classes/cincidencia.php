		<?php

class incidencia{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT id,idusuario,asunto,detalle,fecha,idestado,respuesta FROM incidencia;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['id'];
				   	$info[$id]['id']	= $rs->fields['id'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['asunto']	= $rs->fields['asunto'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['respuesta']	= $rs->fields['respuesta'];
								
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
        $sql = "SELECT * FROM incidencia WHERE id = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['id'];
				   	$info[$id]['id']	= $rs->fields['id'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['asunto']	= $rs->fields['asunto'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['respuesta']	= $rs->fields['respuesta'];
								
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
		
			$sql = "INSERT INTO incidencia (idusuario,asunto,detalle,idestado,respuesta) VALUES (?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE incidencia SET idusuario=?,asunto=?,detalle=?,fecha=?,idestado=?,respuesta=? WHERE id = ?";
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
        $sql = "UPDATE incidencia SET estado = 2 WHERE id = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE incidencia SET estado = 1 WHERE id = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from incidencia where id = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		