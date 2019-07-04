		<?php

class factura{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idclinica)
    {
        $sql = "SELECT f.idfactura,f.total,f.idestado,f.fecha,f.tipo,f.idpaciente,concat(p.nombre,' ',p.apellido) as nombre FROM factura f join 
        		paciente p on f.idpaciente=p.idpaciente where p.idclinica=$idclinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idfactura'];
				   	$info[$id]['idfactura']	= $rs->fields['idfactura'];
								$info[$id]['total']	= $rs->fields['total'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['tipo']	= $rs->fields['tipo'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
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
        $sql = "SELECT f.* , p.nombre, p.apellido, p.identificacion 
                FROM factura f join paciente p on f.idpaciente = p.idpaciente WHERE f.idfactura = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                     = $rs->fields['idfactura'];
                    $info[$id]['idfactura'] = $rs->fields['idfactura'];
                                $info[$id]['total'] = $rs->fields['total'];
                                $info[$id]['idestado']  = $rs->fields['idestado'];
                                $info[$id]['fecha'] = $rs->fields['fecha'];
                                $info[$id]['tipo']  = $rs->fields['tipo'];
                                $info[$id]['idpaciente']    = $rs->fields['idpaciente'];
                                $info[$id]['nombre']    = $rs->fields['nombre'];
                                $info[$id]['apellido']  = $rs->fields['apellido'];
                                $info[$id]['identificacion']    = $rs->fields['identificacion'];
                                $info[$id]['correlativo']   = $rs->fields['correlativo'];
                                
        						
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getFactDetalle($id)
    {
        $sql = "SELECT i.*, p.nombre FROM itemsFactura i join producto p on i.idproducto = p.idproducto WHERE i.idfactura = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                     = $rs->fields['idcontrol'];
                    $info[$id]['idcontrol'] = $rs->fields['idcontrol'];
                                $info[$id]['cantidad']  = $rs->fields['cantidad'];
                                $info[$id]['valor'] = $rs->fields['valor'];
                                $info[$id]['idproducto']    = $rs->fields['idproducto'];
                                $info[$id]['nombre']    = $rs->fields['nombre'];
                                
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getFacturasXmesXid($idclinica,$fecha1,$fecha2)
    {
        $sql = "SELECT SUM(f.total) AS total FROM factura f join paciente p on f.idpaciente=p.idpaciente  
        		WHERE p.idclinica = $idclinica and f.fecha 
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

    function getjsonGrafico($f1,$f2)
    {
        $idclinica = $_SESSION['csmart']['clinica'];
        $arrData = array();
        $alabels = array();
        $mes = "";
        $sql = "SELECT sum(total) as stotal, MONTHNAME(STR_TO_DATE(month(fecha), '%m')) as mes FROM factura where fecha BETWEEN '$f1' and '$f2' group by MONTH(fecha) ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

                array_push($arrData,$rs->fields['stotal']);
               // $mes = mes($rs->fields['mes']);
                array_push($alabels,$rs->fields['mes']);
      
                $rs->MoveNext();
            }
            $rs->Close();
            //return $info;
        } else {
            return false;
        }
       

        $arrData1 = array(array('label' => 'Ventas','backgroundColor' => "#9B59B6",'data' => $arrData),array('label' => 'Compras','backgroundColor' => "#0059B6",'data' => $arrData));
        $arrReturn = array('labels' => $alabels, 'datasets' => $arrData1);

        return (json_encode($arrReturn));

    }
    function mes($mes){
    	if($mes=='1'){
    		return "Enero";
    	}elseif ($mes == '2') {
    		return "Febrero";
    	}elseif ($mes == '3') {
    		return "Marzo";
    	}elseif ($mes == '4') {
    		return "Abril";
    	}elseif ($mes == '5') {
    		return "Mayo";
    	}elseif ($mes == '6') {
    		return "Junio";
    	}elseif ($mes == '7') {
    		return "Julio";
    	}elseif ($mes == 8) {
    		return "Agosto";
    	}elseif ($mes == 9) {
    		return "Septiembre";
    	}elseif ($mes == 10) {
    		return "Octubre";
    	}elseif ($mes == 11) {
    		return "Noviembre";
    	}elseif ($mes == 12) {
    		return "Diciembre";
    	}
    }
	function nuevo($params) 
	{
		try{
		
			$sql = "INSERT INTO factura (total,idestado,fecha,tipo,idpaciente,correlativo) VALUES (?,?,?,?,?,?);";
				 
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
		
			$sql = "INSERT INTO itemsFactura (cantidad,valor,idfactura,idproducto) VALUES (?,?,?,?);";
				 
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

     function addInventario($idproducto,$cantidad) 
    {
        try{
            $sql = "SELECT stock,idtipo FROM producto WHERE idproducto=$idproducto";
            $rs = $this->DATA->Execute($sql);
            if ( $rs->RecordCount()) {
                while(!$rs->EOF){
                    $stock    = $rs->fields['stock'];
                    $idtipo    = $rs->fields['idtipo'];
                    $rs->MoveNext();
                }
                $rs->Close();
                //return $id;
            }
            if($idtipo==1){
                $stock = (float) $stock + (float) $cantidad;

                $sql = "UPDATE producto SET stock=$stock WHERE idproducto=$idproducto;";
                $save = $this->DATA->Execute($sql, $params);
            }else{
                $save=1;
            }
            
            if ($save){
                return $save;
            } else {
                return false;
            }
        }catch(exception $e){
            return false;
        }
    }

    function outInventario($idproducto,$cantidad) 
    {
        try{
            $sql = "SELECT stock,idtipo FROM producto WHERE idproducto=$idproducto";
            $rs = $this->DATA->Execute($sql);
            if ( $rs->RecordCount()) {
                while(!$rs->EOF){
                    $stock    = $rs->fields['stock'];
                    $idtipo    = $rs->fields['idtipo'];
                    $rs->MoveNext();
                }
                $rs->Close();
                //return $id;
            }
            if($idtipo==1){
                $stock = (float) $stock - (float) $cantidad;

                $sql = "UPDATE producto SET stock=$stock WHERE idproducto=$idproducto;";
                $save = $this->DATA->Execute($sql);
                
            }else{
                $save=1;
            }
            
            if ($save){
                return $save;
            } else {
                return false;
            }
        }catch(exception $e){
            return false;
        }
    }

    function regresarInventario($idfactura) 
    {
        try{
            $sql = "SELECT cantidad,idproducto FROM itemsFactura WHERE idfactura=$idfactura";
            $rs = $this->DATA->Execute($sql);
            if ( $rs->RecordCount()) {
                while(!$rs->EOF){
                    $this->addInventario($rs->fields['idproducto'],$rs->fields['cantidad']) ;
                    $rs->MoveNext();
                }
                $rs->Close();
                //return $id;
            }
            
            $sql = "DELETE from itemsFactura WHERE idfactura=$idfactura;";
            $save = $this->DATA->Execute($sql);
            
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
		
			$sql = "UPDATE factura SET total=?,idestado=?,fecha=?,tipo=?,idpaciente=?, correlativo=? WHERE idfactura = ?";
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
        $sql = "UPDATE factura SET estado = 2 WHERE idfactura = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE factura SET estado = 1 WHERE idfactura = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from factura where idfactura = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		