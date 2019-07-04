		<?php 
		include 'data/dataBase.php';
		include 'classes/cpresupuesto.php';
		include 'classes/cUsuario.php';
		include 'classes/ctipotratamiento.php';
		include 'classes/cproducto.php';
		
		$oUser 	= new Usuario();
		$otipo 	= new tipotratamiento();
		$oprod 	= new producto();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$opresupuesto = new presupuesto();
		$accion 	= "Crear";
		$option 	= "n";
		$idpresupuesto 	= "";
	        $nombre 	= "";
	        $fecha 	= "";
	        $duracion 	= "";
	        $pagoinicial 	= "";
	        $numcuotas 	= "";
	        $valcuotas 	= "";
	        $detalle 	= "";
	        $idusuario 	= "";
	        $idtipotratamiento 	= "";
	        $plantilla 	= "";
	        $telefono 	= "";
	        $correo 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vpresupuesto = $opresupuesto->getOne($idObj);
		if($vpresupuesto){
			$accion 	= "Modificar";
			
			   foreach ($vpresupuesto AS $id => $info){ 
			   	  
			   	    $idpresupuesto		= $info["idpresupuesto"];
			        $nombre		= $info["nombre"];
			        $fecha		= $info["fecha"];
			        $duracion		= $info["duracion"];
			        $pagoinicial		= $info["pagoinicial"];
			        $numcuotas		= $info["numcuotas"];
			        $valcuotas		= $info["valcuotas"];
			        $detalle		= $info["detalle"];
			        $idusuario		= $info["idusuario"];
			        $idtipotratamiento		= $info["idtipotratamiento"];
			        $plantilla		= $info["plantilla"];
			        $telefono		= $info["telefono"];
			        $correo		= $info["correo"];
			        $monto		= $info["monto"];
		         }

		         $vdetalle = $opresupuesto->getDetalle($idObj);
		}else{
			header("Location: presupuesto.php");
			exit();
		}
	}
  $vpresupuesto 		= $opresupuesto->getAll($_SESSION['csmart']['clinica']);
  $vTipo 		= $otipo->getAll();
  $vProd 		= $oprod->getAll($_SESSION['csmart']['clinica']);
  
?>
<!DOCTYPE HTML><html>
<head>

 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			

			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionpresupuesto.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='presupuesto.php';",2500);
					}
					
					else{
						new PNotify({
			                title: 'Error en formulario',
			                text: 'No se puedieron guardar los datos, intente de nuevo.',
			                type: 'error'
			             });
			            window.setTimeout("location.reload(true);",2500);
					}
					
				});
			}
			function cancelar(){
				window.setTimeout("document.location.href='presupuesto.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionpresupuesto.php?opt=epresupuesto&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='presupuesto.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idpresupuesto.";
								showWarning(msg,5000);
							}
							else{
								new PNotify({
				                     title: 'Error en formulario',
				                    text: 'No se puedieron guardar los datos, intente de nuevo.',
				                    type: 'error'
				                 });
								window.setTimeout("location.reload(true);",2500);
							}
							
						});
					}
				
			}

			function aprobar(id){
				var form = "valor"; 
						$.ajax({
							url: 'actions/actionpresupuesto.php?opt=hpresupuesto&id='+id,
							type:'POST',
							data: {  }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Presupuesto Aprobado',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='presupuesto.php';",2000);
							}
							else{
								new PNotify({
				                     title: 'Error en accion',
				                    text: 'No se puedieron guardar los datos, intente de nuevo.',
				                    type: 'error'
				                 });
								window.setTimeout("location.reload(true);",2500);
							}
							
						});
			}
			function cancelado(id){
				var form = "valor"; 
						$.ajax({
							url: 'actions/actionpresupuesto.php?opt=bpresupuesto&id='+id,
							type:'POST',
							data: {  }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Presupuesto Cancelado',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='presupuesto.php';",2000);
							}
							else{
								new PNotify({
				                     title: 'Error en accion',
				                    text: 'No se puedieron guardar los datos, intente de nuevo.',
				                    type: 'error'
				                 });
								window.setTimeout("location.reload(true);",2500);
							}
							
						});
			}
			function pendiente(id){
				var form = "valor"; 
						$.ajax({
							url: 'actions/actionpresupuesto.php?opt=ppresupuesto&id='+id,
							type:'POST',
							data: {  }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Presupuesto Pendiente',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='presupuesto.php';",2000);
							}
							else{
								new PNotify({
				                     title: 'Error en accion',
				                    text: 'No se puedieron guardar los datos, intente de nuevo.',
				                    type: 'error'
				                 });
								window.setTimeout("location.reload(true);",2500);
							}
							
						});
			}


			function agregar() {
				if( $("#cantidad").val()=='' ||  $("#valor").val()==''){
                  alert('Debe de Buscar y seleccionar un producto, o completar todos los datos para ingresar uno nuevo. ');
                  
                }else{
                	var idprod = $("#idprod").val() ; 
                	var nprod = $("#nprod").val() ; 
                	var valor = $("#valor").val();
                	var cantidad = $("#cantidad").val();
                	precioxcant = parseFloat($("#valor").val() ) * parseInt($("#cantidad").val());
                	$("#linea").val(parseInt($("#linea").val())+ 1);
                

                	$("#productos").append('<tr id="rowDetalle_' + $("#linea").val() + '">'+
	                '<td><input type="hidden" id="idproducto_' + $("#linea").val() + '" name="idproducto_' + $("#linea").val() + '" value="'+ $("#idprod").val()+'" />' + 
	                $("#cantidad").val() + '<input type="hidden" id="cantidad_' + $("#linea").val() + '" name="cantidad_' + $("#linea").val() + '" value="'+ parseFloat($("#cantidad").val())+'" /></td>' +
	                '<td>' + nprod + '<input type="hidden" id="idproducto_' + $("#linea").val() + '" name="idproducto_' + $("#linea").val() + '" value="'+ idprod +'" /></td>'+
	                '<td>' + valor + '<input type="hidden" id="total_' + $("#linea").val() + '" value="'+ idprod +'" /></td>'+
	                '<td>' + precioxcant + '<input type="hidden" id="valor_' + $("#linea").val() + '" name="valor_' + $("#linea").val() + '" value="'+ $("#valor").val()+'" /></td>'+
	                '<td><div class="" onclick="if(confirm(\'Realmente desea quitar este producto?\')){eliminarFila('+ $("#linea").val() +');}" >Quitar</div></td>'+
	                '</tr>');

					$("#nprod").val() ; 
                	$("#valor").val('0.00');
                	$("#cantidad").val(1);
				}
			}

			function eliminarFila(oId){
			    $("#rowDetalle_" + oId).remove();	
				return false;
			}
	</script>



</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          
          <!-- sidebar menu -->
            <?php include "menu.php" ?>
          <!-- /sidebar menu -->

         
        </div>
      </div>

      <!-- top navigation -->
           <?php include "top_nav.php" ?>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          
         
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Administración de presupuesto</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> presupuesto</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Presupuestos registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los presupuesto registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>#</th>
												        <th>nombre</th>
												        <th>telefono</th>
												        <th>correo</th>
												        <th>Tratamiento</th>
												        <th>fecha</th>
												        <th>Estado</th>
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vpresupuesto){
														$i=1;
														foreach ($vpresupuesto AS $id => $array) {
													?>
														<tr><td align="left"><?=$i;?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['telefono'];?></td>
															<td align="left"><?=$array['correo'];?></td>
															<td align="left"><?=$array['tipoTratamiento'];?></td>
															<td align="left"><?php $date = date_create($array['fecha']); echo date_format($date, 'd/m/Y'); ?></td>
															<td align="left">
																
																<?php if($array['idestado']=='1'){ ?>
																	<div class="btn-group">
												                    <button type="button" class="btn btn-warning btn-xs">Pendiente</button>
												                    <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												                      <span class="caret"></span>
												                    </button>
												                    <ul class="dropdown-menu" role="menu">
												                      <li><a href="#" onClick="aprobar(<?=$id?>)">Aceptado</a>
												                      </li>
												                      <li><a href="#" onClick="cancelado(<?=$id?>)">Cancelado</a>
												                      </li>
												                    </ul>
												                 </div>
																	
															 	<?php }elseif($array['idestado']=='2'){ ?>
															 		<div class="btn-group">
												                    <button type="button" class="btn btn-success btn-xs">Aceptado</button>
												                    <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												                      <span class="caret"></span>
												                    </button>
												                    <ul class="dropdown-menu" role="menu">
												                      <li><a href="#" onClick="pendiente(<?=$id?>)">Pendiente</a>
												                      </li>
												                      <li><a href="#" onClick="cancelado(<?=$id?>)">Cancelado</a>
												                      </li>
												                    </ul>
												                 </div>
															 		
															 	<?php }elseif($array['idestado']=='3'){ ?>
																 	<div class="btn-group">
													                    <button type="button" class="btn btn-danger btn-xs">Cancelado</button>
													                    <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													                      <span class="caret"></span>
													                    </button>
													                    <ul class="dropdown-menu" role="menu">
													                      <li><a href="#" onClick="aprobar(<?=$id?>)">Aceptado</a>
													                      </li>
													                      <li><a href="#" onClick="pendiente(<?=$id?>)">Pendiente</a>
													                      </li>
													                    </ul>
													                 </div>
															 		
															 	<?php }; ?>
															</td>	
														<td>
															
																	<a href="presupuesto.php?opt=m&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																	
																	 
																	<span class="label label-default" onClick="eliminar(<?=$id?>)" >
																		<i class="fa fa-trash-o" title="Eliminar"></i>	
																	</span>

																	&nbsp;

																	<a href="presupuestoImprimir.php?opt=m&id=<?=$id;?>" title="Imprimir" >
																		<span class="label label-primary" >
																			<i class="fa fa-print" title="Imprimir"></i>
																		</span>
																	</a>	
																	
															</td>										
																
														</tr>
													<?php
														$i++;}
													}	
													?>
												</tbody>
											  </table>
						                	
						                	</div>
                        </div>
                      </div>

                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        
                        <form id="form" class="form-horizontal form-label-left" novalidate>
                    <p>Ingrese la información en la casilla correspondiente  
                    </p>

                    <?php
                          if ($option == "m") {
                        ?>
                            <input type="hidden"  name="idpresupuesto" id="idpresupuesto" value="<?=$idpresupuesto?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   		<div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Generales</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="nombre" name="nombre" data-validate-length-range="6" required="required" value="<?=$nombre?>" placeholder="Nombre completo">
                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                  
                    
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="telefono" name="telefono" data-validate-length-range="6" required="required" value="<?=$telefono?>" placeholder="Teléfono">
                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                    </div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <input type="text" class="form-control has-feedback-left" id="correo" name="correo" data-validate-length-range="6" required="required" value="<?=$correo?>"  placeholder="Correo">
                      <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    
                    <div class="form-group">
                       <div class="col-md-3 col-sm-3 col-xs-12">
                        <input class="date-picker form-control col-md-7 col-xs-12 has-feedback-left"  id="fecha" name="fecha" required="required" value="<?=$fecha?>" type="text">
                      	<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	                             
                      </div>
                    </div>

                 
                </div>
              </div>

               <script type="text/javascript">
            $(document).ready(function() {
              $('#fecha').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
            });
          </script>
            

            </div>

            <div class="col-md-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Datos de presupuesto</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form class="form-horizontal form-label-left">
                  		<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idtipotratamiento">Tipo de tratamiento <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                      	<select id="idtipotratamiento" name="idtipotratamiento" data-validate-length-range="6"   class="form-control">
		                          <option>Elegir una opción</option>
		                          <?php if($vTipo){
		                                foreach ($vTipo AS $id => $array) {?>

		                                <option value="<?=$array['idtipoTratamiento'];?>" <?php if($idtipotratamiento==$id){echo"selected='selected'";}?>><?=$array['tipoTratamiento'];?></option>
		                          <?php } } ?>
		                        </select>
		                      </div>

		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="duracion">Duración <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="duracion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="duracion" value="<?=$duracion?>" placeholder="Meses" required="required" type="text">
		                      </div>

		                    </div>
		           
								 
							 <div class="item form-group">
							 	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="monto">Inversión <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="monto" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="monto" value="<?=$monto?>" placeholder="" required="required" type="text">
		                      </div>

		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pagoinicial">Pago Inicial <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="pagoinicial" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="pagoinicial" value="<?=$pagoinicial?>" placeholder="" required="required" type="text">
		                      </div>
		                    </div>
							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numcuotas">Cantidad de cuotas <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="numcuotas" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="numcuotas" value="<?=$numcuotas?>" placeholder="" required="required" type="text">
		                      </div>

		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valcuotas">Pago por cita <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="valcuotas" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="valcuotas" value="<?=$valcuotas?>" placeholder="" required="required" type="text">
		                      </div>
		                    </div>

								 
							

                    		<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detalle">Detalle 
		                      </label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                      	<textarea id="detalle" name="detalle" data-validate-length-range="6"    class="form-control" rows="4" placeholder=''><?=$detalle?></textarea>
		                        
		                      </div>
		                    </div>

		                    <h2>Detalle del servicio </h2>
                  
                 		   <div class="clearfix"></div>
                    		
                 		   <div class="item form-group">
		                      <label class="control-label col-md-1 col-xs-12" for="idproducto">Servicio  
		                      </label>
		                      <div class="col-md-4 col-sm-4 col-xs-12">
		                      	<select id="idproducto" name="idproducto"  class="form-control">
		                          <option value = "0">Elegir una opción</option>
		                          <?php if($vProd){
		                                foreach ($vProd AS $id => $array) {?>

		                                <option value="<?=$array['idproducto'];?>" <?php if($idproducto==$id){echo"selected='selected'";}?>><?=$array['nombre'];?></option>
		                          <?php } } ?>
		                        </select>
		                        <input type="hidden" id="idprod" name="idprod" value="" >
		                        <input type="hidden" id="nprod" name="nprod" value="">
		                      </div>
								<label class="control-label col-md-1 col-sm-1 col-xs-12" for="cantidad">Cantidad 
		                      </label>
		                      <div class="col-md-2 col-sm-2 col-xs-12">
		                        <input id="cantidad" class="form-control col-md-7 col-xs-12"  name="cantidad" value="<?=$cantidad?>" placeholder="1"  type="number">
		                      </div>
		                      
		                      <div class="col-md-2 col-sm-2 col-xs-12">
		                        <input id="valor" class="form-control col-md-7	 col-xs-12" name="valor" value="<?=$valor?>" placeholder="0.00"  type="number">
		                      </div>
		                      <input type="button" onClick="agregar();" class="btn btn-primary" value="Agregar">
				                        
		                    </div>

		                    <div class="item form-group">

		                    	<table id="productos" class="table table-striped">
				                    <thead>
				                    <tr>
				                        <th >Cantidad</th>
				                        <th >Descripcion</th>
				                        <th >Precio</th>
				                        <th >Sub total</th>
				                        <th> <input type="hidden" id="linea" name="linea" value="<?php if($vdetalle){ echo count($vdetalle);}else{ echo 0;};?>" /></th>
				                    </tr></thead>

				                    <?php
				                    if($vdetalle){
				                    	$i=1;
				                    	foreach ($vdetalle AS $id => $array){ ?>
						                
						                <tr id="rowDetalle_<?php echo $i; ?>">
						                    <td> <?=$array['cantidad']; ?>
						                       <input type="hidden" id="cantidad_<?php echo $i; ?>" name="cantidad_<?php echo $i; ?>" value="<?=$array['cantidad']; ?>" /> </td>
						                   <td><?=$array['nombre']; ?><input type="hidden" id="idproducto_<?php echo $i; ?>" name="idproducto_<?php echo $i; ?>" value="<?=$array['idproducto']; ?>" /></td>
						                   <td><?=$array['valor']; ?><input type="hidden" id="valor_<?php echo $i; ?>" name="valor_<?php echo $i; ?>" value="<?=$array['valor']; ?>" /></td>
						                   <td><?php echo $array['valor']*$array['cantidad']; ?><input type="hidden" id="total_<?php echo $i; ?>" name="total_<?php echo $i; ?>" value="<?php echo $array['valor']*$array['cantidad']; ?>" /></td>
						                   <td><div class="" onclick="if(confirm('Realmente desea quitar este producto?')){eliminarFila(<?php echo $i; ?>);}"/>Quitar</div></td>
						                </tr>

						            <?php $i++; } ?>
				                    <?php
				                    }

				                   	?>
				                </table>
		                    </div>
		           

                </div>
              </div>
            </div>


            
          </div>	
								 
													
													
								<div class="ln_solid"></div>
				                    <div class="form-group">
				                      <div class="col-md-6 col-md-offset-3">
				                        <input type="button" onClick="cancelar();" class="btn btn-primary" value="Cancelar">
				                        <button  id="send" class="btn btn-success">Guardar</button>
				                      </div>
				                    </div>
				                  </form>
									
								</div>
                     
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
         <? include "pie.php"; ?>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script src="js/custom.js"></script>
  <!-- form validation -->
  <script src="js/validator/validator.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
  
   <!-- Datatables-->
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>


  <script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
      .on('blur', 'input[required], input.optional, select.required', validator.checkField)
      .on('change', 'select.required', validator.checkField)
      .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required')
      .on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);

    $('form').submit(function(e) {
      e.preventDefault();
      var submit = true;

      
      // evaluate the form using generic validaing
      if (!validator.checkAll($(this))) {
        submit = false;
      }

      if (submit)
        guardarformulario();
      return false;
    });

    /* FOR DEMO ONLY */
    $('#vfields').change(function() {
      $('form').toggleClass('mode2');
    }).prop('checked', false);

    $('#alerts').change(function() {
      validator.defaults.alerts = (this.checked) ? false : true;
      if (this.checked)
        $('form .alert').remove();
    }).prop('checked', false);
  </script>
  <!-- pace -->
        <script src="js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
         <script type="text/javascript">
          $(document).ready(function() {

            <?php
              if($option == "m"){
            ?>
                $("#tab1").removeClass('active');
                $("#tab2").addClass('active');
                $("#tab_content1").removeClass('active in');
                $("#tab_content2").addClass('active in');
                
            <? } ?>

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });

            $('#idproducto').change(function(){
            	$('#idprod').val( $( "#idproducto" ).val());
            	$('#nprod').val($( "#idproducto option:selected" ).text());
            });	
          });
          TableManageButtons.init();
        </script>
</body>

</html>

