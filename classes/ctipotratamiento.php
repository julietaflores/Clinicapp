		<?php

class tipoTratamiento{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idtipoTratamiento,tipoTratamiento,idestado FROM tipoTratamiento;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idtipoTratamiento'];
				   	$info[$id]['idtipoTratamiento']	= $rs->fields['idtipoTratamiento'];
								$info[$id]['tipoTratamiento']	= $rs->fields['tipoTratamiento'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
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
        $sql = "SELECT * FROM tipoTratamiento WHERE idtipoTratamiento = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idtipoTratamiento'];
				   	$info[$id]['idtipoTratamiento']	= $rs->fields['idtipoTratamiento'];
								$info[$id]['tipoTratamiento']	= $rs->fields['tipoTratamiento'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
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
		
			$sql = "INSERT INTO tipoTratamiento (tipoTratamiento,idestado) VALUES (?,?);";
				 
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
		
			$sql = "UPDATE tipoTratamiento SET tipoTratamiento=?,idestado=? WHERE idtipoTratamiento = ?";
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
        $sql = "UPDATE tipoTratamiento SET estado = 2 WHERE idtipoTratamiento = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE tipoTratamiento SET estado = 1 WHERE idtipoTratamiento = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from tipoTratamiento where idtipoTratamiento = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		