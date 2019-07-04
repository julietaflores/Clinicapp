<?php 
		include 'data/dataBase.php';
		include 'classes/cgasto.php';
		include 'classes/cUsuario.php';
		include 'classes/ctipoGasto.php';
		 date_default_timezone_set('UTC'); 
		$oUser 	= new Usuario();
		$otipo	= new tipoGasto();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$ogasto = new gasto();
		$accion 	= "Crear";
		$option 	= "n";
		$idgasto 	= "";
	        $idtipoGasto 	= "";
	        $detalle 	= "";
	        $monto 	= "";
	        $idusuario 	= "";
	        $idclinica 	= "";
	        $fecha 	= "";
	        $idestado 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vgasto = $ogasto->getOne($idObj);
		if($vgasto){
			$accion 	= "Modificar";
			
			   foreach ($vgasto AS $id => $info){ 
			   	  
			   	  $idgasto		= $info["idgasto"];
		        $idtipoGasto		= $info["idtipoGasto"];
		        $detalle		= $info["detalle"];
		        $monto		= $info["monto"];
		        $idusuario		= $info["idusuario"];
		        $idclinica		= $info["idclinica"];
		        $fechagasto		= $info["fechagasto"];
		        $idestado		= $info["idestado"];
		         }
		}else{
			header("Location: gasto.php");
			exit();
		}
	}
	$fecha = date("Y-m-d");
	$fechaInicio = date("Y-m-") . "01";
	$fechaFin = date("Y-m-t");

  $vgasto 		= $ogasto->getAll($_SESSION['csmart']['clinica']);
  $vtipo 		= $otipo->getAll();
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actiongasto.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='gasto.php';",2500);
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
				window.setTimeout("document.location.href='gasto.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actiongasto.php?opt=egasto&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='gasto.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idgasto.";
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
                  <h2>Administración de gasto</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> gasto</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="row">
				            <div class="col-md-10 col-sm-10 col-xs-12">
				              <div class="x_panel">
				                <div class="x_title">
				                  <h2>Gasto actual <small>por fechas</small></h2>
				                  	<div class="col-md-3 col-sm-3 col-xs-12">
				                        <input type="text" class="form-control has-feedback-right" id="fecha" name="fecha" value="<?=$fechaInicio?>"  >
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
				                  <canvas id="pieChart"></canvas>
				                </div>
				              </div>
				            </div>

				          

				          </div>

                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Gastos registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>#</th>
												        <th>Tipo de Gasto</th>
												        <th>Detalle</th>
												        <th>Monto</th>
												        <th>Fecha</th>
												        <th>Estado</th>
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vgasto){
														$i=1;
														foreach ($vgasto AS $id => $array) {

													?>
														<tr><td align="left"><?=$i;?></td>
															<td align="left"><?=$array['gasto'];?></td>
															<td align="left"><?=$array['detalle'];?></td>
															<td align="left"><?=$array['monto'];?></td>
															<td align="left">
																<?php $date = date_create($array['fechagasto']); echo date_format($date, 'd/m/Y'); ?></td>
															<td align="left"><?php if($array['idestado']==0){ ?> <span class="label label-success">Ejecutado</span> 
																			<?php }else{ ?>
																					<span class="label label-warning">Pendiente</span>
																				<?php };?></td>
                            	
														<td>
															
																	<a href="gasto.php?opt=m&id=<?=$id;?>" title="Modificar" >
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
                    </p><span class="section">Ingresar Informacion</span>

                    <?php
                          if ($option == "m") {
                        ?>
                            <input type="hidden" name="idgasto" value="<?=$idgasto?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de gasto <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="idtipoGasto" name="idtipoGasto" class="form-control">
		                          <option>Elegir una opción</option>
		                          <?php if($vtipo){
		                                foreach ($vtipo AS $id => $array) {?>

		                                <option value="<?=$array['idtipoGasto'];?>" <?php if($idtipoGasto==$id){echo"selected='selected'";}?>><?=$array['gasto'];?></option>
		                          <?php } } ?>
		                        </select>
		                      </div>
		                    </div>
							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detalle">Detalle <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="detalle" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="detalle" value="<?=$detalle?>" placeholder="detalle" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monto">Monto <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="monto" class="form-control col-md-3 col-xs-12" data-validate-length-range="6" name="monto" value="<?=$monto?>" placeholder="monto" required="required" type="number">
		                      </div>
		                    </div>

							<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha">Fecha 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input type="text" class="form-control has-feedback-left" id="fechagasto" name="fechagasto" value="<?php if(isset($fechagasto)){ echo $fechagasto;}else{echo $fecha;}?>" required="required" aria-describedby="fecha">
	                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	                               
	                          </div>
		                    </div>
								
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idestado">Estado <span class="required">*</span>
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="idestado" name="idestado" class="form-control" required="required">
		                          <option>Elegir una opción</option>
		                          <option value="1" <?php if($idestado==1){echo"selected='selected'";}?>>Pendiente</option>
		                          <option value="0" <?php if($idestado==0){echo"selected='selected'";}?>>Ejecutado</option>
		                          
		                        </select>

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
  <script src="js/chartjs/chart.min.js"></script>
  
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
         // Pie chart
		   var ctx = document.getElementById("pieChart");
		  
          $(document).ready(function() {
          	construirGrafico();
          	
          	$('#consultar').click(function(){
          		construirGrafico();
          	});

          	function construirGrafico(){
          		var fecha1 = $('#fecha').val();
          		var fecha2 = $('#fecha2').val();
          		$.ajax({
                	url: "actions/actiongasto.php?opt=d",
                    type:"POST",
                    dataType: 'json',
                    data: { f1: fecha1, f2: fecha2},
                    success: function(data) {
                                       
                        var data1 = data;

                        var pieChart = new Chart(ctx, {
								data: data1,
								type: 'pie',
								otpions: {
								    legend: false
								}
							});
                    }
                }) ;
          	};

          	$('#fecha').daterangepicker({
		        singleDatePicker: true,
		        calender_style: "picker_3"
		      }, function(start, end, label) {
		        console.log(start.toISOString(), end.toISOString(), label);
		      });
          	$('#fecha2').daterangepicker({
		        singleDatePicker: true,
		        calender_style: "picker_3"
		      }, function(start, end, label) {
		        console.log(start.toISOString(), end.toISOString(), label);
		      });
          	$('#fechagasto').daterangepicker({
		        singleDatePicker: true,
		        calender_style: "picker_3"
		      }, function(start, end, label) {
		        console.log(start.toISOString(), end.toISOString(), label);
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

        <script>
        	 
		    
        </script>
</body>

</html>

