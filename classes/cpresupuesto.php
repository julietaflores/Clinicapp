		<?php

class presupuesto{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idclinica)
    {
        $sql = "SELECT p.*, t.tipoTratamiento FROM presupuesto p join usuario u on p.idusuario=u.idusuario join tipotratamiento t 
        		on p.idtipotratamiento=t.idtipotratamiento WHERE u.idclinica=$idclinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idpresupuesto'];
				   	$info[$id]['idpresupuesto']	= $rs->fields['idpresupuesto'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['duracion']	= $rs->fields['duracion'];
								$info[$id]['pagoinicial']	= $rs->fields['pagoinicial'];
								$info[$id]['numcuotas']	= $rs->fields['numcuotas'];
								$info[$id]['valcuotas']	= $rs->fields['valcuotas'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idtipotratamiento']	= $rs->fields['idtipotratamiento'];
								$info[$id]['tipoTratamiento']	= $rs->fields['tipoTratamiento'];
								$info[$id]['plantilla']	= $rs->fields['plantilla'];
								$info[$id]['telefono']	= $rs->fields['telefono'];
								$info[$id]['correo']	= $rs->fields['correo'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getAllporEstado($idclinica, $estado)
    {
        $sql = "SELECT p.idpresupuesto,p.nombre,p.fecha FROM presupuesto p join usuario u on p.idusuario=u.idusuario 
        		WHERE  p.idestado = $estado and u.idclinica = $idclinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idpresupuesto'];
				   	$info[$id]['idpresupuesto']	= $rs->fields['idpresupuesto'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
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
        $sql = "SELECT * FROM presupuesto WHERE idpresupuesto = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idpresupuesto'];
				   	$info[$id]['idpresupuesto']	= $rs->fields['idpresupuesto'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['duracion']	= $rs->fields['duracion'];
								$info[$id]['pagoinicial']	= $rs->fields['pagoinicial'];
								$info[$id]['monto']	= $rs->fields['monto'];
								$info[$id]['numcuotas']	= $rs->fields['numcuotas'];
								$info[$id]['valcuotas']	= $rs->fields['valcuotas'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idtipotratamiento']	= $rs->fields['idtipotratamiento'];
								$info[$id]['plantilla']	= $rs->fields['plantilla'];
								$info[$id]['telefono']	= $rs->fields['telefono'];
								$info[$id]['correo']	= $rs->fields['correo'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getDetalle($id)
    {
        $sql = "SELECT p.iddetallepre, p.idpresupuesto, p.idproducto, p.valor,p.cantidad, r.nombre
        		FROM presupuestoDetalle p inner join producto r on p.idproducto=r.idproducto WHERE p.idpresupuesto = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  		= $rs->fields['iddetallepre'];
				$info[$id]['idpresupuesto']	= $rs->fields['idpresupuesto'];
				$info[$id]['idproducto']	= $rs->fields['idproducto'];
				$info[$id]['nombre']	= $rs->fields['nombre'];
				$info[$id]['valor']			= $rs->fields['valor'];
				$info[$id]['cantidad']		= $rs->fields['cantidad'];
								
								
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
		
			$sql = "INSERT INTO presupuesto (nombre,fecha,duracion,pagoinicial,numcuotas,valcuotas,detalle,idusuario,idtipotratamiento,plantilla,telefono,correo,idestado,monto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
				 
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
    function nuevoDetalle($params) 
	{
		try{
		
			$sql = "INSERT INTO presupuestoDetalle (idpresupuesto,idproducto,valor,cantidad) VALUES (?,?,?,?);";
				 
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
		
			$sql = "UPDATE presupuesto SET nombre=?,fecha=?,duracion=?,pagoinicial=?,numcuotas=?,valcuotas=?,detalle=?,idusuario=?,idtipotratamiento=?,plantilla=?,telefono=?,correo=? WHERE idpresupuesto = ?";
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

    function borrarItems($id) {
        $sql = "delete from presupuestoDetalle where idpresupuesto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function bloqueo($id) {
        $sql = "UPDATE presupuesto SET idestado = 3 WHERE idpresupuesto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE presupuesto SET idestado = 2 WHERE idpresupuesto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }

    function pendiente($id) {
        $sql = "UPDATE presupuesto SET idestado = 1 WHERE idpresupuesto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from presupuesto where idpresupuesto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		