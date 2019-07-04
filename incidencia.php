		<?php 
		include 'data/dataBase.php';
		include 'classes/cincidencia.php';
		include 'classes/cUsuario.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$oincidencia = new incidencia();
		$accion 	= "Crear";
		$option 	= "n";
		$id 	= "";
	        $idusuario 	= "";
	        $asunto 	= "";
	        $detalle 	= "";
	        $fecha 	= "";
	        $idestado 	= "";
	        $respuesta 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vincidencia = $oincidencia->getOne($idObj);
		if($vincidencia){
			$accion 	= "Modificar";
			
			   foreach ($vincidencia AS $id => $info){ 
			   	  
			   	  $id		= $info["id"];
		        $idusuario		= $info["idusuario"];
		        $asunto		= $info["asunto"];
		        $detalle		= $info["detalle"];
		        $fecha		= $info["fecha"];
		        $idestado		= $info["idestado"];
		        $respuesta		= $info["respuesta"];
		         }
		}else{
			header("Location: incidencia.php");
			exit();
		}
	}
  $vincidencia 		= $oincidencia->getAll();
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionincidencia.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='incidencia.php';",2500);
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
				window.setTimeout("document.location.href='incidencia.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionincidencia.php?opt=eincidencia&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='incidencia.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idincidencia.";
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
                  <h2>Administración de incidencia</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> incidencia</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>incidencia Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los incidencia registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
												        <th>asunto</th>
												        <th>detalle</th>
												        <th>fecha</th>
												        <th>estado</th>
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vincidencia){
														foreach ($vincidencia AS $id => $array) {
													?>
														<tr><td align="left"><?=$array['asunto'];?></td>
															<td align="left"><?=$array['detalle'];?></td>
															<td align="left"><?=$array['fecha'];?></td>
															<td align="left"><?php if($array['idestado']=='1'){ ?>
																<span class="label label-warning">Pendiente</span>
															 <?php }; ?>
															 	<?php if($array['idestado']=='2'){ ?>
																<span class="label label-success">Resuelta</span>
															 <?php }; ?></td>
																
														<td>
															
																	
																	 
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
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        
                        <form id="form" class="form-horizontal form-label-left" novalidate>
                    <p>Ingrese la información en la casilla correspondiente  
                    </p><span class="section">Ingresar Informacion</span>

                    <?php
                          if ($option == "m") {
                        ?>
                            <input type="hidden" name="id" value="<?=$id?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   						
												
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asunto">Asunto <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="asunto" name="asunto" class="form-control">
		                          <option value="1" <?php if($asunto==1){echo"selected='selected'";}?>>Información</option>
		                          <option value="2" <?php if($asunto==2){echo"selected='selected'";}?>>Error de Sistema</option>
		                          <option value="3" <?php if($asunto==3){echo"selected='selected'";}?>>Pagos</option>
		                          
		                        </select> 
		                       </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detalle">Detalle <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                      	<textarea id="detalle" name="detalle" class="form-control col-md-7 col-xs-12"><?=$detalle?></textarea>
		                      </div>
		                    </div>

							
														
													
								 
							 <!-- <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="respuesta">respuesta <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="respuesta" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="respuesta" value="<?=$respuesta?>" placeholder="respuesta" required="required" type="text">
		                      </div>
		                    </div> -->

							
								 
													
													
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
          });
          TableManageButtons.init();
        </script>
</body>

</html>

