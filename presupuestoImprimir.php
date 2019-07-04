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
  //$vProd 		= $oprod->getAll($_SESSION['csmart']['clinica']);
  
?>
<!DOCTYPE HTML><html>
<head>

 	 <?php include 'header.php'; ?>

		

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
                  <h2>Presupuesto de Servicio</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    
                    <div id="myTabContent" class="tab-content">
                      
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        
                        <form id="form" class="form-horizontal form-label-left" novalidate>
                   

                  
           <div class="row">
                      <div class="col-xs-12 invoice-header">
                        <h1>
                                        <i class="fa fa-globe"></i> ClinicApp.
                                        <small class="pull-right">Fecha: <?php $date = date_create($array['fecha']); echo date_format($date, 'd/m/Y'); ?></small>
                                    </h1>
                      </div>
                      <!-- /.col -->
                    </div>        
           <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Datos de Paciente</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  
                  
                    <span class="fa fa-user"><b> </b></span> <?=$nombre?>
                     <br>
                    
                    <span class="fa fa-phone "> </span> <?=$telefono?>
                    <br>
                    
                    <span class="fa fa-envelope "></span> <?=$correo?><br>
                    
                  
                    
                    
                 
                </div>
              </div>

                          

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
                  		
                  	<div class="row">
                  		<div class="col-sm-6 invoice-col">
                  			<div class="col-md-12 col-sm-12 col-xs-12">
		                      	<b>Tipo de tratamiento: </b> <?php if($vTipo){
		                                foreach ($vTipo AS $id => $array) {?>

		                                <?php if($idtipotratamiento==$id){echo $array['tipoTratamiento'];}?>                          

		                          <?php } } ?>
		                    
							<br>
							<b>Inversión: </b> $ <?=$monto?>
		                    <br>
		                    <b>Cantidad de cuotas: </b> <?=$numcuotas?>

		                    </div>

		                      
                  		</div>

                  		<div class="col-sm-6 invoice-col">
                  			<div class="col-md-12 col-sm-12 col-xs-12">
		                      	<b>Duración: </b> <?=$duracion?> Meses
		                      
		                      	<br>

		                      	<b>Pago Inicial: </b> $ <?=$pagoinicial?>
		                    	<br>
		                    	<b>Pago por cita: </b> $ <?=$valcuotas?>

		                    </div> 
                  		</div>

                  	</div>

							<br>
							<div class="item form-group">
							 
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                      	<b>Detalle de tratamiento: </b> <br> <?=$detalle?>
		                      </div>
			                 </div>

							
							<br>
							<bR>
                    		
		                    <h2>Detalle del servicio </h2>
                  
                 		                   		   

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
				                        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Imprimir</button>
                        				
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

