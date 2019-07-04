		<?php

class gasto{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idclinica)
    {
        $sql = "SELECT g.idgasto,g.idtipoGasto,g.detalle,g.monto,g.idusuario,g.idclinica,g.fechagasto,g.idestado, t.gasto 
        		FROM gasto g join tipoGasto t 
        		on g.idtipoGasto = t.idtipoGasto
        		where g.idclinica = $idclinica  ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idgasto'];
				   	$info[$id]['idgasto']	= $rs->fields['idgasto'];
								$info[$id]['idtipoGasto']	= $rs->fields['idtipoGasto'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['monto']	= $rs->fields['monto'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['fechagasto']	= $rs->fields['fechagasto'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['gasto']	= $rs->fields['gasto'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
    function getjson($f1,$f2)
    {
        $idclinica = $_SESSION['csmart']['clinica'];
        $arrData = array();
        $alabels = array();
        $sql = "SELECT sum(g.monto) as total, t.gasto FROM gasto g join tipoGasto t on g.idtipoGasto = t.idtipoGasto 
                WHERE g.idclinica = $idclinica and 
                g.fechagasto BETWEEN '$f1 00:00' and '$f2 23:59' group by g.idtipoGasto  ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

                array_push($arrData,$rs->fields['total']);
                array_push($alabels,$rs->fields['gasto']);
      
                $rs->MoveNext();
            }
            $rs->Close();
            //return $info;
        } else {
            return false;
        }
        //$alabels = array("Sueldos","Facturas","Mantenimiento","Productos","Varios");
        // $arrData = array('28', '48', '40', '19', '86') ;
        $arrColor = array("#BDC3C7","#9B59B6","#455C73","#26B99A","#3498DB");
        $arrColor1 = array("#BDC3C4","#9B39B6","#452273","#21599A","#8898DB");

        $arrsub  = array(array('data' => $arrData, 'backgroundColor' => $arrColor , 'hoverBackgroundColor' => $arrColor1));
        $arrReturn = array('labels' => $alabels, 'datasets' => $arrsub);

        return (json_encode($arrReturn));

    }

	function getOne($id)
    {
        $sql = "SELECT * FROM gasto WHERE idgasto = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idgasto'];
				   	$info[$id]['idgasto']	= $rs->fields['idgasto'];
								$info[$id]['idtipoGasto']	= $rs->fields['idtipoGasto'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['monto']	= $rs->fields['monto'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['fechagasto']	= $rs->fields['fechagasto'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getGastosXmesXid($idclinica,$fecha1,$fecha2)
    {
        $sql = "SELECT SUM(MONTO) AS total FROM gasto 
        		WHERE idclinica = $idclinica and fechagasto 
        		BETWEEN '$fecha1 00:00:00' and '$fecha2 23:59:59' ;";

        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id    = $rs->fields['total'];
				   	
				 $rs->MoveNext();
            }
            $rs->Close();
            return $id;
        } else {
            return false;
        }
    }

    function getGastosDetalleXmesXid($idclinica,$fecha1,$fecha2)
    {
        $sql = "SELECT SUM(g.MONTO) AS total, t.gasto FROM gasto g join tipoGasto t on g.idtipoGasto=t.idtipoGasto
                WHERE g.idclinica = $idclinica and g.fechagasto 
                BETWEEN '$fecha1 00:00:00' and '$fecha2 23:59:59' GROUP BY g.idtipoGasto order by total desc;";

        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            $i=0;
            while(!$rs->EOF){
                $info[$i]['total']    = $rs->fields['total'];
                $info[$i]['gasto']    = $rs->fields['gasto'];
                    
                 $rs->MoveNext();
                 $i++;
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
		
			$sql = "INSERT INTO gasto (idtipoGasto,detalle,monto,idusuario,idclinica,idestado,fechagasto) VALUES (?,?,?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE gasto SET idtipoGasto=?,detalle=?,monto=?,idusuario=?,idclinica=?,idestado=?,fechagasto=? WHERE idgasto = ?";
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
        $sql = "UPDATE gasto SET estado = 2 WHERE idgasto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE gasto SET estado = 1 WHERE idgasto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from gasto where idgasto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		