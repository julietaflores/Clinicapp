<?php 
		include 'data/dataBase.php';
		include 'classes/cpaciente.php';
		include 'classes/cUsuario.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$opaciente = new paciente();
		$accion 	= "Crear";
		$option 	= "n";
		$idpaciente 	= "";
	        $nombre 	= "";
	        $apellido 	= "";
	        $identificacion 	= "";
	        $genero 	= "";
	        $imagen 	= "";
	        $direccion 	= "";
	        $telefono1 	= "";
	        $telefono2 	= "";
	        $correo 	= "";
	        $fecha_nac 	= "";
	        $fecha_mod 	= "";
	        $fecha_cre 	= "";
	        $notas 	= "";
	        $idestado 	= "";
	        $iddepartamento 	= "";
	        $responsable 	= "";
	        $telefono_resp 	= "";
	        $medico_fam 	= "";
	        $ocupacion 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vpaciente = $opaciente->getOne($idObj);
		if($vpaciente){
			$accion 	= "Modificar";
			
			   foreach ($vpaciente AS $id => $info){ 
			   	  
			   	  $idpaciente		= $info["idpaciente"];
		        $nombre		= $info["nombre"];
		        $apellido		= $info["apellido"];
		        $identificacion		= $info["identificacion"];
		        $genero		= $info["genero"];
		        $imagen		= $info["imagen"];
		        $direccion		= $info["direccion"];
		        $telefono1		= $info["telefono1"];
		        $telefono2		= $info["telefono2"];
		        $correo		= $info["correo"];
		        $fecha_nac		= $info["fecha_nac"];
		        $fecha_mod		= $info["fecha_mod"];
		        $fecha_cre		= $info["fecha_cre"];
		        $notas		= $info["notas"];
		        $idestado		= $info["idestado"];
		        $iddepartamento		= $info["iddepartamento"];
		        $responsable		= $info["responsable"];
		        $telefono_resp		= $info["telefono_resp"];
		        $medico_fam		= $info["medico_fam"];
		        $ocupacion		= $info["ocupacion"];
		         }
		}else{
			header("Location: paciente.php");
			exit();
		}
	}
  $vpaciente 		= $opaciente->getAll();
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionpaciente.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='paciente.php';",2500);
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
				window.setTimeout("document.location.href='paciente.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionpaciente.php?opt=epaciente&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='paciente.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idpaciente.";
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

			function irperfil(id){
				window.setTimeout("document.location.href='pacienteperfil.php?id="+id+"';",500);
			}

			function ireditar(id){
				window.setTimeout("document.location.href='pacientenuevo.php?opt=m&id="+id+"';",500);
			}
			// $('#perfil').click(function(){
				
			// });
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
                  <h2>Administración de paciente</h2>
                    
                   <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Buscar...">
                  <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Ir!</button>
                                        </span>
                </div>
              </div>
            </div><div class="clearfix"></div>
                </div>
               
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                       <li id="tab2" role="presentation" class="active"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="true">paciente</a>
                      </li>
                     <li id="tab1" role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Listado</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade " id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Pacientes registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los paciente registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>#</th>
												        <th>nombre</th>
												        <th>apellido</th>
												        <th>identificación</th>
												        <th>teléfono </th>
												        <th>celular 	</th>
												        <th>correo</th>
												        <th>estado</th>
												        
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vpaciente){
														$i=1;
														foreach ($vpaciente AS $id => $array) {
													?>
														<tr><td align="left"><?=$i;?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['apellido'];?></td>
															<td align="left"><?=$array['identificacion'];?></td>
															<td align="left"><?=$array['telefono1'];?></td>
															<td align="left"><?=$array['telefono2'];?></td>
															<td align="left"><?=$array['correo'];?></td>
															<td align="left"><?php if($array['idestado']==1){ ?> <span class="label label-success">Activo</span> 
																			<?php }else{ ?>
																					<span class="label label-warning">Inactivo</span>
																				<?php };?></td>	
														<td>
															
																	<a href="pacienteperfil.php?id=<?=$id;?>" title="Perfil" >
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
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="profile-tab">
                        
                     <?php
						if($vpaciente){
							foreach ($vpaciente AS $id => $array) {   ?>
					<div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
						                      <div class="well profile_view">
						                        <div class="col-sm-12">
						                          <!-- <h4 class="brief"><i>Digital Strategist</i></h4> -->
						                          <div class="left col-xs-7">
						                            <h2><?=$array['nombre'];?> <?=$array['apellido'];?></h2>
						                            <!-- <p><strong>About: </strong> Web Designer / UI. </p> -->
						                            <ul class="list-unstyled">
						                              <li><i class="fa fa-phone"></i>  <?=$array['telefono1'];?> </li>
						                              <li><i class="fa fa-phone"></i>  <?=$array['telefono2'];?></li>
													 <li><i class="fa fa-email"></i>  <?=$array['correo'];?></li>

						                            </ul>
						                            <br>
						                          </div>
						                          <div class="right col-xs-5 text-center">
						                            <img src="images/paciente/<?=$array['idpaciente'];?>/<?=$array['imagen'];?>" alt="" class="img-circle img-responsive">
						                          </div>
						                        </div>
						                        <div class="col-xs-12 bottom text-center">
						                          <div class="col-xs-12 col-sm-6 emphasis">
						                            <!-- <p class="ratings">
						                              <a>4.0</a>
						                              <a href="#"><span class="fa fa-star"></span></a>
						                              <a href="#"><span class="fa fa-star"></span></a>
						                              <a href="#"><span class="fa fa-star"></span></a>
						                              <a href="#"><span class="fa fa-star"></span></a>
						                              <a href="#"><span class="fa fa-star-o"></span></a>
						                            </p> -->
						                          </div>
						                          <div class="col-xs-12 col-sm-6 emphasis">
						                            <button type="button" class="btn btn-success btn-xs" onclick="ireditar(<?=$array['idpaciente'];?>)"> 
						                            <i class="fa fa-edit"></i> Editar </button>

						                            <button type="button" id="perfil" class="btn btn-primary btn-xs" onclick="irperfil(<?=$array['idpaciente'];?>)"> <i class="fa fa-user">
						                                                            </i> Ver Perfil </button>
						                          </div>
						                        </div>
						                      </div>
						                    </div>

														
						<?php }
							}	?>
                      	

                       
									
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

<!-- form wizard -->
  <script type="text/javascript" src="js/wizard/jquery.smartWizard.js"></script>
  
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
          	// Smart Wizard
		      $('#wizard_verticle').smartWizard({
		        transitionEffect: 'slide'
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

