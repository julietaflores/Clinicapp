<?php 
    include 'data/dataBase.php';
    include 'classes/ccita.php';
    include 'classes/cUsuario.php';
    include 'classes/ctipocita.php';
    include 'classes/cpaciente.php';
    
    $oUser  = new Usuario();
    $oTipocita  = new tipocita();
    $opaciente  = new paciente();
      
    if ( !$oUser->verSession() ) {
      header("Location: login.php");
      exit();
    }
    $ocita = new cita();
    $accion   = "Crear";
    $option   = "n";
    $idcita   = "";
          $idusuario  = "";
          $fecha  = "";
          $fecha_prog   = "";
          $idestado   = "";
          $comentario   = "";
          $idtipocita   = "";
          $idpaciente   = "";
          
      if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
    $option = $_REQUEST['opt'];
    $idObj  = $_REQUEST['id'];
  }

  if ($option == "m") {
    $vcita = $ocita->getOne($idObj);
    if($vcita){
      $accion   = "Modificar";
      
         foreach ($vcita AS $id => $info){ 
            
            $idcita   = $info["idcita"];
            $idusuario    = $info["idusuario"];
            $fecha    = $info["fecha"];
            $fecha_prog   = $info["fecha_prog"];
            $idestado   = $info["idestado"];
            $comentario   = $info["comentario"];
            $idtipocita   = $info["idtipocita"];
            $idpaciente   = $info["idpaciente"];
             }
    }else{
      header("Location: cita.php");
      exit();
    }
  }
  //$vcita    = $ocita->getAll();
  $vtcita    = $oTipocita->getAll();
  $vUsuarios   = $oUser->getAllxClinica($_SESSION['csmart']['clinica']);

  //echo $opaciente->getalljson();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "header.php" ?>

  <link href="css/calendar/fullcalendar.css" rel="stylesheet">
  <link href="css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          

          <!-- sidebar menu -->
          <?php include "menu.php"; ?>
          <!-- /sidebar menu -->

          
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
        <?php include "top_nav.php"; ?>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="page-title">
            <div class="title_left">
              <h3>
                                    Agenda
                                    <small>
                                        Click para agregar/editar citas
                                    </small>
                                </h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Buscar...">
                  <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Ir!</button>
                                        </span>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Agenda de Citas</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div id='calendar'></div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        <?php include "pie.php" ?>
        <!-- /footer content -->

      </div>


      <!-- Start Calender modal -->
      <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">Nueva cita</h4>
            </div>
            <div class="modal-body">
              <div id="testmodal" style="padding: 5px 20px;">
                <form id="antoform" class="form-horizontal calender" role="form">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Paciente</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control"  id="paciente" name="paciente" /> 
                        <!-- <div id="log" style="height: 40px; width: 350px; overflow: auto;" ></div> -->

                        <input type="hidden" id="idpaciente" name="idpaciente" value="0"/>
                    </div>
                     
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Usuario </label>
                      <div class="col-sm-9">
                        <select id="idusuario" name="idusuario" class="form-control">
                          <?php if($vUsuarios){
                                foreach ($vUsuarios AS $id => $array) {?>

                                <option value="<?=$array['idusuario'];?>" <?php if($idusuario==$id){echo"selected='selected'";}?>><?=$array['nombre'];?> <?=$array['apellido'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>

                  <div class="form-group">
                      <label class="col-sm-3 control-label">Tipo de cita </label>
                      <div class="col-sm-9">
                        <select id="idtipocita" name="idtipocita" class="form-control">
                          <?php if($vtcita){
                                foreach ($vtcita AS $id => $array) {?>

                                <option value="<?=$array['idtipocita'];?>" <?php if($idtipocita==$id){echo"selected='selected'";}?>><?=$array['tipo'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha / Hora</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="fecha" name="fecha">
                     </div>
                    <div class="col-sm-3">
                      <select id="hora" name="hora" class="form-control">
                          <option value="08:00" >8:00</option>
                          <option value="08:30" >8:30</option>
                          <option value="09:00" >9:00</option>
                          <option value="09:30" >9:30</option>
                          <option value="10:00" >10:00</option>
                          <option value="10:30" >10:30</option>
                          <option value="11:00" >11:00</option>
                          <option value="11:30" >11:30</option>
                          <option value="12:00" >12:00</option>
                          <option value="12:30" >12:30</option>
                          <option value="13:00" >13:00</option>
                          <option value="13:30" >13:30</option>
                          <option value="14:00" >14:00</option>
                          <option value="14:30" >14:30</option>
                          <option value="15:00" >15:00</option>
                          <option value="15:30" >15:30</option>
                          <option value="16:00" >16:00</option>
                          <option value="16:30" >16:30</option>
                          <option value="17:00" >17:00</option>
                          <option value="17:30" >17:30</option>
                          
                         </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Nota</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary antosubmit">Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel2">Eliminar de la agenda</h4>
            </div>
            <div class="modal-body">

              <div id="testmodal2" style="padding: 5px 20px;">
                
                  <div class="form-group">
                    <label class="col-sm-9 control-label">Confirma que desea elminar este registro?</label>
                    <input type="hidden" class="form-control" id="idcita" name="idcita">
                  </div>
                  
                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger antosubmit2">Eliminar</button>
            </div>
          </div>
        </div>
      </div>

      <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
      <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>

      <!-- End Calender modal -->
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

  <script src="js/nprogress.js"></script>
  
  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <script src="js/moment/moment.min.js"></script>
  <script src="js/calendar/fullcalendar.min.js"></script>
  <!-- Autocomplete 

   <script src="js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>-->
   <script src="js/jquery-ui-1.9.2.custom.js" type="text/javascript"></script>
   <link href="css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
   <link href="css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
         
  <!--<script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
   pace -->
  <script src="js/pace/pace.min.js"></script>
  
  <script>
    $(document).ready(function() {

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
                                                        id: item.idpaciente
                                                        
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
                
                
            }
        });
        function log( message ) {
            $( "#log" ).html(''); //se tiene q limpiar el div
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
                                    
        }
        var zone = "05:30";  //Change this to your timezone

          $.ajax({
            url: 'actions/actioncita.php',
                type: 'POST', // Send post data
                data: 'opt=j',
                async: false,
                success: function(s){
                  json_events = s;
                }
          });


    });
    
    $(document).ready(function() {

      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();
      var started;
      var categoryClass;

      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        selectHelper: true,
        editable: true,
        events: 'events.php',
        //slotDuration: '00:30:00',
        eventRender: function(event, element, view) {
          if (event.allDay === 'true') {
           event.allDay = true;
          } else {
           event.allDay = false;
          }
         },
         select: function(start, end, allDay) {
           //var title = prompt('Event Title:');
           //var url = prompt('Type Event url, if exits:');
           $('#fc_create').click();
           fecha = start.format("YYYY-MM-DD");
           hora = start.format("hh:mm");
           ended = end;
           $('#fecha').val(fecha);
           $('#hora').val(hora);
           //$('#descr').val(hora);
           $(".antosubmit").on("click", function() {
                var title = $("#paciente").val();
                if (title) {
                   var idpaciente =  $("#idpaciente").val();
                   var idusuario =  $("#idusuario").val();
                   var idtipocita = $("#idtipocita").val();
                   var detalle = $("#descr").val();

                   var start = $('#fecha').val() + " " + $('#hora').val();
                   var hora = $('#hora').val().charAt(0) + $('#hora').val().charAt(1);
                   var min = $('#hora').val().charAt(3) + $('#hora').val().charAt(4);
                   hora = parseInt(hora) + 1;
                   var end = $('#fecha').val() + " " +  hora + ":" + min ;
                   var url = '';
                   $.ajax({
                       url: 'actions/actioncita.php?opt=ja',
                       data: 'title='+ title+'&start='+ start +'&end='+ end +'&url='+ url +'&tipocita=' + idtipocita +'&idpaciente=' + idpaciente +'&detalle=' + detalle + '&idusuario=' + idusuario + '&allDay='  ,
                       type: "POST",
                       success: function(json) {
                         //alert('Added Successfully: '+json);
                     }
                   });
                   calendar.fullCalendar('renderEvent',
                   {
                     title: title,
                     start: start,
                     end: end,
                     allDay: ''
                   }   // make the event "stick"
                   );
               }
               $("#title").val('');
               calendar.fullCalendar('unselect');

               $('.antoclose').click();

               return false;

           });

        },
        eventClick: function(calEvent, jsEvent, view) {
          //alert(calEvent.title, jsEvent, view);
          $('#fc_edit').click();
          $('#idcita').val(calEvent.id);
          
          $(".antosubmit2").on("click", function() {
            var id = $("#idcita").val();
            $.ajax({
                       url: 'actions/actioncita.php?opt=jr',
                       data: 'id=' + id  ,
                       type: "POST",
                       success: function(json) {
                        //alert('remove Successfully: '+json);
                        calendar.fullCalendar('removeEvents', id);
                     }
                   });

            //calendar.fullCalendar('updateEvent', calEvent);
            $('.antoclose2').click();
            return false;
          });
          calendar.fullCalendar('unselect');
        },
         eventDrop: function(event, delta) {
        var start = event.start.format("YYYY-MM-DD hh:mm");
        var end = (event.end == null) ? start : event.end.format("YYYY-MM-DD hh:mm");
           
         // var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
         // var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
         $.ajax({
           url: 'actions/actioncita.php?opt=jm',
           data: 'start='+ start +'&end='+ end +'&id='+ event.id ,
           type: "POST",
             success: function(json) {
              alert("Actualizado Correctamente.");
             }
         });
         },
         eventResize: function(event, delta) {
        var start = event.start.format("YYYY-MM-DD hh:mm");
        var end = (event.end == null) ? start : event.end.format("YYYY-MM-DD hh:mm");
           
         // var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
         // var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
         $.ajax({
           url: 'actions/actioncita.php?opt=jm',
           data: 'start='+ start +'&end='+ end +'&id='+ event.id ,
           type: "POST",
             success: function(json) {
              alert("Actualizado Correctamente.");
             }
         });
         }
      });
    });
  </script>
 
</body>

</html>
