		<?php 
		include 'data/dataBase.php';
		include 'classes/cfactura.php';
		include 'classes/cUsuario.php';
		 date_default_timezone_set('UTC'); 
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$ofactura = new factura();
		$accion 	= "Crear";
		$option 	= "n";
		$idfactura 	= "";
	        $total 	= "";
	        $idestado 	= "";
	        $fecha 	= "";
	        $tipo 	= "";
	        $idpaciente 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vfactura = $ofactura->getOne($idObj);
		if($vfactura){
			$accion 	= "Modificar";
			
			   foreach ($vfactura AS $id => $info){ 
			   	  
			    $idfactura		= $info["idfactura"];
		        $total		= $info["total"];
		        $idestado	= $info["idestado"];
		        $fecha		= $info["fecha"];
		        $tipo		= $info["tipo"];
		        $idpaciente		= $info["idpaciente"];
		        $nombre		= $info["nombre"];
		        $apellido		= $info["apellido"];
		        $nit		= $info["identificacion"];
		        $correlativo		= $info["correlativo"];
		         }
		        $vfactDetalle = $ofactura->getFactDetalle($idfactura);
		}else{
			header("Location: factura.php");
			exit();
		}
	}
	$fecha = date("Y-m-d");
	$fechaInicio = date("Y-m-") . "01";
	$fechaFin = date("Y-m-t");

  $vfactura 		= $ofactura->getAll($_SESSION['csmart']['clinica']);
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionfactura.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='factura.php';",2500);
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
				window.setTimeout("document.location.href='factura.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionfactura.php?opt=efactura&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='factura.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idfactura.";
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
			function agregar() {
				if( $("#cantidad").val()=='' ||  $("#valor").val()==''){
                  alert('Debe de Buscar y seleccionar un producto, o completar todos los datos para ingresar uno nuevo. ');
                  
                }else{
                	var idprod = $("#idproducto").val() ; 
                	var nprod = $("#producto").val() ; 
                	var valor = $("#valor").val();
                	var cantidad = $("#cantidad").val();
                	precioxcant = parseFloat($("#valor").val() ) * parseInt($("#cantidad").val());
                	$("#linea").val(parseInt($("#linea").val())+ 1);
                

                	$("#productos").append('<tr id="rowDetalle_' + $("#linea").val() + '">'+
	                '<td><input type="hidden" id="idproducto_' + $("#linea").val() + '" name="idproducto_' + $("#linea").val() + '" value="'+ $("#idprod").val()+'" />' + 
	                $("#cantidad").val() + '<input type="hidden" id="cantidad_' + $("#linea").val() + '" name="cantidad_' + $("#linea").val() + '" value="'+ parseFloat($("#cantidad").val())+'" /></td>' +
	                '<td>' + nprod + '<input type="hidden" id="idproducto_' + $("#linea").val() + '" name="idproducto_' + $("#linea").val() + '" value="'+ idprod +'" /></td>'+
	                '<td>' + valor + '<input type="hidden" id="valor_' + $("#linea").val() + '" name="valor_' + $("#linea").val() + '" value="'+ $("#valor").val() +'" /></td>'+
	                '<td>' + precioxcant + '<input type="hidden" id="total_' + $("#linea").val() + '" name="total_' + $("#linea").val() + '" value="'+ precioxcant +'" /></td>'+
	                '<td><div class="" onclick="if(confirm(\'Realmente desea quitar este producto?\')){eliminarFila('+ $("#linea").val() +');}" >Quitar</div></td>'+
	                '</tr>');

					$("#total").val(parseFloat($("#total").val()) + parseFloat(precioxcant));
					$('#ltotal span').text('Bs'+$("#total").val());
					$("#producto").val('') ; 
                	$("#idproducto").val('0') ; 
                	$("#valor").val('0.00');
                	$("#cantidad").val('1');
                	
				}
			}

			function eliminarFila(oId){
				$("#total").val(parseFloat($("#total").val()) - parseFloat($("#total_"+oId).val()) );
				$('#ltotal span').text('Bs'+$("#total").val());
					
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
                  <h2>Administración de factura</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab2" role="presentation" class="active"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> factura</a>
                      </li>
                      <li id="tab1" role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                        
                        <div class="row">
				            <!-- <div class="col-md-10 col-sm-10 col-xs-12">
				              <div class="x_panel">
				                <div class="x_title">
				                  <h2>Ventas  <small>por fechas</small></h2>
				                  	<div class="col-md-3 col-sm-3 col-xs-12">
				                        <input type="text" class="form-control has-feedback-right" id="fecha1" name="fecha1" value="<?=$fechaInicio?>"  >
			                              <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
			                               
			                          </div>
			                        <div class="col-md-3 col-sm-3 col-xs-12">
				                        <input type="text" class="form-control has-feedback-right" id="fecha2" name="fecha2" value="<?=$fechaFin?>" >
			                              <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
			                               
			                          </div>
				                  	<button type="button" id="consultar" name="consultar" class="btn btn-info btn-xs">Consultar</button>
				                  <ul class="nav navbar-right panel_toolbox">
				                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				                    </li>
				                    <li><a class="close-link"><i class="fa fa-close"></i></a>
				                    </li>
				                  </ul>
				                  <div class="clearfix"></div>
				                </div>
				                <div class="x_content">
				                  <canvas id="mybarChart"></canvas>
				                </div>
				              </div>
				            </div> -->

				          

				          </div>
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>factura Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los factura registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>Código</th>
												        <th>fecha</th>
												        <th>tipo</th>
												        <th>Paciente</th>
												         <th>total</th>
												        <th>Estado</th>
												       
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vfactura){
														foreach ($vfactura AS $id => $array) {
													?>
														<tr><td align="left"><?=$array['idfactura'];?></td>
															<td align="left"><?=$array['fecha'];?></td>
															<td align="left"><?=$array['tipo'];?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['total'];?></td>
															<td align="left"><?php if($array['idestado']=='1'){ ?>
																<span class="label label-success">Pagada</span>
															 <?php }; ?>
															 	<?php if($array['idestado']=='2'){ ?>
																<span class="label label-warning">Pendiente</span>
															 <?php }; ?></td>
																
														<td>
															
																	<a href="factura.php?opt=m&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																	
																	 
																	<span class="label label-default" onClick="eliminar(<?=$id?>)" >
																		<i class="fa fa-trash-o" title="Eliminar"></i>	
																
																	</span>	
																	
															</td>										
																
														</tr>
													<?php
														}
													}	
													?>
												</tbody>
											  </table>
						                	
						                	</div>
                        </div>
                      </div>

                      </div>
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="profile-tab">
                        
                        <form id="form" class="form-horizontal form-label-left" novalidate>
                    

                    	<?php
                          if ($option == "m") {
                        ?>
                            <input type="hidden" name="idfactura" value="<?=$idfactura?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   
							<div class="col-md-12 col-xs-12">
				              <div class="x_panel">
				                <div class="x_title">
				                  <h2>Generales</h2>
				                  <ul class="nav navbar-right panel_toolbox">

				                  	 <div class="animated flipInY col-md-3 col-sm-3 col-xs-12 tile_stats_count">
					                   Total: <div id="ltotal" name="ltotal" class="count green"><span>Bs<?php if($total){ echo $total;}else{ echo 0;}?></span></div>
					                 </div>
				                  </ul>
				                 
				                  <div class="clearfix"></div>
				                </div>
				                <div class="x_content">
				                  <br />
				                  <div class="form-group">
				                    <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
				                    	<input type="text" class="form-control has-feedback-left" required="required" id="paciente" name="paciente" placeholder="Nombre completo" value="<?php if($nombre){ echo $nombre.' '.$apellido;}?>"/> 
                        				<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                       					 <input type="hidden" id="idpaciente" name="idpaciente" value="<?php if($idpaciente){ echo $idpaciente;}else{ echo 0;} ?>"/>
				                      
				                    </div>

				                    <div class="col-md-3 col-sm-3 col-xs-12">
				                        	<input class="date-picker form-control col-md-7 col-xs-12 has-feedback-left"  id="nit" name="nit" value="<?=$nit;?>" type="text" placeholder="NIT" disabled>
				                      		<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
					                    </div>


									<div class="col-md-3 col-sm-3 col-xs-12">
				                        	<input class="date-picker form-control col-md-7 col-xs-12 has-feedback-left"  id="fecha" name="fecha" required="required" value="<?php if($fecha){$date = date_create($fecha); echo date_format($date, 'Y-m-d');}else{echo $fecha;} ?>" type="text">
				                      		<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					                    </div>

				                      
				                     
				                     </div>
				                    <!-- <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
				                      <input type="text" class="form-control has-feedback-left" id="telefono" name="telefono" data-validate-length-range="6" required="required" value="<?=$telefono?>" placeholder="Teléfono">
				                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				                    </div>
									 -->
				                    
				                    <div class="form-group">
					                    
					                    <div class="col-md-3 col-sm-3 col-xs-12">
				                       	
						                   	<select id="tipo" name="tipo" class="form-control" >
					                          <option value="Factura" <?php if($tipo=="Factura"){echo"selected='selected'";}?>>Factura</option>
					                          <option value="Recibo" <?php if($tipo=="Recibo"){echo"selected='selected'";}?>>Recibo</option>
					                          
					                        </select>

					                     </div> 

					                    <div class="col-md-3 col-sm-3 col-xs-12">
				                        	<input class="date-picker form-control col-md-7 col-xs-12 has-feedback-left"  id="correlativo" name="correlativo" placeholder="Número de Factura" value="<?=$correlativo;?>" type="text" >
				                      		<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
					                    </div> 

					                    

				                  		
				                   
				                   		<input id="total" name="total" value="<?php if($total){ echo $total;}else{ echo 0;}?>" type="hidden">
				                      
										<div class="col-md-3 col-sm-3 col-xs-12">
						                    	<div class="checkbox"  >
						                          <label>
						                            <input id="estado" name="estado" type="checkbox" class="" <?php if($idestado){ if($idestado==2){echo 'checked';} }?> > Pendiente de pago
							                        <input id="idestado" name="idestado" type="hidden" value="<?php if($idestado){ echo $idestado;}else{ echo 1;}?>"  > 
						                          </label>
						                        </div>
						                    </div>	 
				                    	

				                 		<div class="col-md-3 col-sm-3 col-xs-12">
					                    	
					                    </div>

					                </div>
				                </div>
				              </div>

				         <script type="text/javascript">
				            
				            $(document).ready(function() {
				            	$('#estado').change(function(){
									if ($('#estado').is(":checked"))
									{
										console.log('2');
									  $('#idestado').val('2');
									}else{
										$('#idestado').val('1');
										console.log('1');
									}
									console.log('3');
				            	});
				     //        	$('#estado').change(function(){
							  //     	var valor = $("input:checkbox[name ='estado']:checked").val();
									// $('#idestado').val(valor);
							  //     });
											            	
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
				                  
				                  

				                   <div class="item form-group">
				                      <label class="control-label col-md-1 col-xs-12" for="idproducto">Producto  
				                      </label>
				                      <div class="col-md-4 col-sm-4 col-xs-12">
				                      	<input type="text" class="form-control "  id="producto" name="producto" placeholder="Nombre de producto"/> 
                        				 <input type="hidden" id="idproducto" name="idproducto" value="0"/>
				                      
				                        
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

				                  <div class="clearfix"></div>
				                </div>
				                <div class="x_content">
						                  
								
									
				                	<div class="item form-group">

				                    	<table id="productos" class="table table-striped">
						                    <thead>
						                    <tr>
						                        <th >Cantidad</th>
						                        <th >Descripción</th>
						                        <th >Precio</th>
						                        <th >Sub total</th>
						                        <th> <input type="hidden" id="linea" name="linea" value="<?php if($vfactDetalle){ echo count($vfactDetalle);}else{ echo 0;};?>" /></th>
						                    </tr></thead>

						                    <?php
						                    if($vfactDetalle){
						                    	$i=1;
						                    	foreach ($vfactDetalle AS $id => $array){ ?>
								                
								                <tr id="rowDetalle_<?php echo $i; ?>">
								                    <td> <?=$array['cantidad']; ?>
								                       <input type="hidden" id="cantidad_<?php echo $i; ?>" name="cantidad_<?php echo $i; ?>" value="<?=$array['cantidad']; ?>" /> </td>
								                   <td><?=$array['nombre']; ?><input type="hidden" id="idproducto_<?php echo $i; ?>" name="idproducto_<?php echo $i; ?>" value="<?=$array['idproducto']; ?>" /></td>
								                   <td><?=$array['valor']; ?><input type="hidden" id="valor_<?php echo $i; ?>" name="valor_<?php echo $i; ?>" value="<?=$array['valor']; ?>" /></td>
								                   <td><?php echo $array['valor']*$array['cantidad']; ?><input type="hidden" id="total_<?php echo $i; ?>" name="total_<?php echo $i; ?>" value="<?php echo $array['valor']*$array['cantidad']; ?>" /></td>
								                   <td><div class="" onclick="if(confirm('Realmente desea quitar este producto?')){eliminarFila(<?php echo $i; ?>);}"/>quitar</div></td>
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

<!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
 
   <script src="js/jquery-ui-1.9.2.custom.js" type="text/javascript"></script>
   <link href="css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
   <link href="css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
   <script src="js/chartjs/chart.min.js"></script>
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
         	var ctx = document.getElementById("mybarChart");
		    			
          $(document).ready(function() {
          	construirGrafico();
          	
          	$('#consultar').click(function(){
          		construirGrafico();
          	});

          	function construirGrafico(){
          		var fecha1 = $('#fecha1').val();
          		var fecha2 = $('#fecha2').val();
          		$.ajax({
                	url: "actions/actionfactura.php?opt=d",
                    type:"POST",
                    dataType: 'json',
                    data: { f1: fecha1, f2: fecha2},
                    success: function(data) {
                        console.log(data);        
                        var data1 = data;

                        var mybarChart = new Chart(ctx, {
					      type: 'bar',
					      data: data1,

					      options: {
					        scales: {
					          yAxes: [{
					            ticks: {
					              beginAtZero: true
					            }
					          }]
					        }
					      }
					    });
                    }
                }) ;
          	};

          	$( "#paciente" ).autocomplete({
	            source: function( request, response ) {
	                        var dato=0;
	                        dato = request.term.replace(' ','');
	                        $.ajax({
	                                url: "actions/actionpaciente.php?opt=j",
	                                type:"POST",
	                                dataType: "json",
	                                data: {
	                                        maxRows: 10,
	                                        q: dato
	                                },
	                                success: function(data) {
	                                        console.log(data);
	                                        response( $.map( data, function( item ) {
	                                                return {
	                                                        label: item.nombre,
	                                                        value: item.nombre,
	                                                        id: item.idpaciente,
	                                                        nit: item.identificacion
	                                                        
	                                               }
	                                        }));
	                                }
	                        });
	              }
	                ,
	            minLength: 2,
	            select: function( event, ui ) {
	                // log( ui.item ?  
	                //     "COD:" + ui.item.id + " " + ui.item.label :
	                //     "Nada seleccionado, input was " + this.value );
	                    $("#idpaciente").val(ui.item.id);
	                	$("#nit").val(ui.item.nit);
	                
	                
	            }
	        });

			$( "#producto" ).autocomplete({
	            source: function( request, response ) {
	                        var dato=0;
	                        dato = request.term.replace(' ','');
	                        $.ajax({
	                                url: "actions/actionproducto.php?opt=j",
	                                type:"POST",
	                                dataType: "json",
	                                data: {
	                                        maxRows: 10,
	                                        q: dato
	                                },
	                                success: function(data) {
	                                        console.log(data);
	                                        response( $.map( data, function( item ) {
	                                                return {
	                                                        label: item.nombre,
	                                                        value: item.nombre,
	                                                        id: item.idproducto,
	                                                        precio: item.precio
	                                                        
	                                               }
	                                        }));
	                                }
	                        });
	              }
	                ,
	            minLength: 2,
	            select: function( event, ui ) {
	                // log( ui.item ?  
	                //     "COD:" + ui.item.id + " " + ui.item.label :
	                //     "Nada seleccionado, input was " + this.value );
	                    $("#idproducto").val(ui.item.id);
	                	$("#valor").val(ui.item.precio);
	                	$("#cantidad").val(1);
	                
	                
	            }
	        });
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
          });
          TableManageButtons.init();
        </script>
</body>

</html>

