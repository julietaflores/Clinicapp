<?php 
    include 'data/dataBase.php';
    include 'classes/cUsuario.php';
    include 'classes/ccita.php';
    include 'classes/cpaciente.php';
    include 'classes/cnotas.php';
    include 'classes/cgasto.php';
    include 'classes/cpresupuesto.php';
    include 'classes/cfactura.php';
    
    date_default_timezone_set('UTC'); 

    $oUser  = new Usuario();
    $oCita  = new cita();
    $oPac  = new paciente();
    $oNota  = new notas();
    $ogasto  = new gasto();
    $opresupuesto  = new presupuesto();
    $ofactura = new factura();
      
    if ( !$oUser->verSession() ) {
    //  alert("sesion expirada");
      header("Location: login.php");
      exit();
    }
    $fecha = date("Y-m-d");
    $fechaFin = date("Y-m-t");

    //CITA DE HOY
    $vcita = $oCita->getAllfecha($fecha,$_SESSION['csmart']['clinica']);
    $vcitaXusuario = $oCita->getCitasXusuario($fecha,$_SESSION['csmart']['idusuario']);
    
    //USUARIOS INACTIVOS
    $vcitaInactivos = $oCita->getUsuarioInactivos($fecha,$_SESSION['csmart']['clinica']);
    
    $fecha = date("Y-m-") . "01";
    
    //CITAS DEL MES
    $vcitas = $oCita->getCitasXusuarioXrango($fecha,$fechaFin,$_SESSION['csmart']['idusuario']);

    //TOTAL DE PACIENTES
    //$vpac   = $oPac->getTotalPacientes($_SESSION['csmart']['clinica']);
    //PACIENTES NUEVOS ESTE MES
    $vpacNew   = $oPac->getTotalPacientesXfecha($_SESSION['csmart']['clinica'], $fecha, $fechaFin);
    
    $dia = date("d"); $mes = date("m");


    //CUMPLEANEROS DEL DIA
    $vcumple   = $oPac->getAllCumpleaneros($dia,$mes);

    //TOTAL DE NOTAS
    $vNotas   = $oNota->getAllusuario($_SESSION['csmart']['idusuario']);

    //TOTAL DE GASTOS
    $vGasto = $ogasto -> getGastosXmesXid($_SESSION['csmart']['clinica'],$fecha,$fechaFin);

    //DETALLE DE GASTOS
    $vGastoDetalle = $ogasto -> getGastosDetalleXmesXid($_SESSION['csmart']['clinica'],$fecha,$fechaFin);

    
    //TOTAL DE FACTURACION
    $vFact = $ofactura -> getFacturasXmesXid($_SESSION['csmart']['clinica'],$fecha,$fechaFin);

    //PRESUPUESTOS POR CLINICA
    $vPre   = $opresupuesto->getAllporEstado($_SESSION['csmart']['clinica'],1);
 ?>   

<!DOCTYPE html>
<html >

<head>
  <?php include "header.php";?>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

           
          <!-- sidebar menu -->
            <?php include "menu.php" ?>
          <!-- /sidebar menu -->



          <!-- /menu footer buttons -->
         <!--  <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div> -->
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
        <?php include 'top_nav.php'; ?>
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">

        <!-- top tiles -->
        <div class="row tile_count">
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-clock-o"></i> Citas Hoy</span>
              <div class="count green"><?php echo $vcitaXusuario; ?></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> que la semana pasada</span> -->
            </div>
          </div>
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total citas mes</span>
              <div class="count green"><?php echo $vcitas; ?></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> que el mes pasado</span> -->
            </div>
          </div>
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-user"></i> Pacientes Activos</span>
              <div class="count">0</div>
              
            </div>
          </div>
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-user"></i> Nuevos Pacientes</span>
              <div class="count"><?php echo $vpacNew; ?></div>
              
            </div>
          </div>
          
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-hand-o-up"></i> Total Facturado</span>
              <div class="count"><?php echo $vFact; ?></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>0% </i> más</span> -->
            </div>
          </div>
          <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
            <div class="left"></div>
            <div class="right">
              <span class="count_top"><i class="fa fa-hand-o-down"></i> Total Gastos </span>
              <div class="count"><?php echo $vGasto; ?></div>
              <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>0% </i> más</span> -->
            </div>
          </div>
          

        </div>
        <!-- /top tiles -->

        <!-- <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

              <div class="row x_title">
                <div class="col-md-6">
                  <h3>Network Activities <small>Graph title sub-title</small></h3>
                </div>
                <div class="col-md-6">
                  <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                  </div>
                </div>
              </div>

              <div class="col-md-9 col-sm-9 col-xs-12">
                <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                <div style="width: 100%;">
                  <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                <div class="x_title">
                  <h2>Top Campaign Performance</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-6">
                  <div>
                    <p>Facebook Campaign</p>
                    <div class="">
                      <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <p>Twitter Campaign</p>
                    <div class="">
                      <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-6">
                  <div>
                    <p>Conventional Media</p>
                    <div class="">
                      <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <p>Bill boards</p>
                    <div class="">
                      <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="clearfix"></div>
            </div>
          </div>

        </div>
        <br /> -->

        <div class="row">


          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Agenda de Hoy </h2> &nbsp; 
                  
                <ul class="nav navbar-right panel_toolbox">
                  <li><a href="agenda.php" class="btn btn-default btn-success btn-xs">Nueva Cita</a></li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>

              <div class="x_content">
                <ul class="list-unstyled msg_list">
                  <?php if($vcita){
                                foreach ($vcita AS $id => $array) {?>
                  <li>
                    <a>
                      <span class="image">
                                    <img src="images/paciente/<?=$array['idpaciente'];?>/<?=$array['imagen'];?>" alt="img" />
                                </span>
                      <span>
                                    <span><?=$array['title'];?> | <?=$array['tipo'];?></span>
                      <span class="time"><i class="fa fa-clock-o"> </i> <?php $date = date_create($array['start']); echo date_format($date, 'H:i'); ?> Hrs.</span>
                      </span>
                      <span class="message">
                                    <?=$array['comentario'];?>
                                </span>
                    </a>
                  </li>
                   <?php } } ?>
                </ul>
              </div>
              
            </div>
          </div>

         
           <!-- Start to do list -->
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Notas <small>importantes</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="">
                      
                      <ul class="to_do">
                        <?php if($vNotas){
                                foreach ($vNotas AS $id => $array) {?>
                                
                                <!-- <div > -->
                                <li id="<?=$array['idnota'];?>">
                                  <p>
                                    <button type="button" class="btn btn-xs" onclick="borrarnota(<?=$array['idnota'];?>)"> 
                                <i class="fa fa-square-o"></i> </button> <?=$array['detalle'];?> </p>
                                </li>
                                <!-- </div> -->
                        <?php } } ?>
                        
                         <div id="nnotas">

                         </div>
                      </ul>
                    
                      <input id="nota" name="nota" type="text" /> 
                      <button type="button" class="btn btn-success btn-xs" onclick="guardarnota()"> 
                                 Agregar <i class="fa fa-chevron-right"></i> </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End to do list -->

         

        </div>


        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Actividades Recientes <small>actualidad</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="dashboard-widget-content">

                  <ul class="list-unstyled timeline widget">
                    <li>
                      <div class="block">
                        <div class="block_content">
                          <h2 class="title">
                                            <a>ClinicApp te de la Bienvenida!</a>
                                        </h2>
                          <div class="byline">
                            <span>05/01/2017 14:00 </span> por <a>Clan</a>
                          </div>
                          <p class="excerpt"> Gracias por confiar en nuestro producto. Te aseguramos que tu trabajo estará más organizado y tus clientes más satisfechos. Toma el control de tu clínica ahora mismo y conoce cuál es tu actividad. <a>Leer más</a>
                          </p>
                        </div>
                      </div>
                    </li>
                    <!-- <li>
                      <div class="block">
                        <div class="block_content">
                          <h2 class="title">
                                            <a>Productos a bajo costo...</a>
                                        </h2>
                          <div class="byline">
                            <span>13 hours ago</span> by <a>Jane Smith</a>
                          </div>
                          <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                          </p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="block">
                        <div class="block_content">
                          <h2 class="title">
                                            <a>Semana de la salud bucal</a>
                                        </h2>
                          <div class="byline">
                            <span>13 hours ago</span> by <a>Clan</a>
                          </div>
                          <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                          </p>
                        </div>
                      </div>
                    </li> -->
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>


           <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel tile fixed_height_320">
              <div class="x_title">
                <h2>Cumpleañeros de Hoy</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <ul class="quick-list">
                <?php if($vcumple){
                        foreach ($vcumple AS $id => $array) {?>

                        
                          <li><i class="fa fa-birthday-cake"></i><?=$array['nombre'];?> 
                          </li>
                       
                               
                        <?php } }else{

                          ?>
                          <p class="excerpt">No hay Cumpleañeros este día.</p>
                          <?php

                        } ?>
                      </ul>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel tile fixed_height_320">
              <div class="x_title">
                <h2>Presupuestos Pendientes</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                
                <lu>
                  <?php if($vPre){
                        foreach ($vPre AS $id => $array) {?>

                        
                          <li><i class="fa fa-reorder"></i> <?=$array['nombre'];?> | <?=$array['fecha'];?> 
                          
                            
                          </li>
                       
                               
                        <?php } }else{

                          ?>
                          <p class="excerpt">No hay Presupuesto pendientes.</p>
                          <?php

                        } ?>

                      </lu>
              </div>
            </div>
          </div>
          
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel tile fixed_height_320 overflow_hidden">
              <div class="x_title">
                <h2>Distribución de Gastos</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">

                <table class="" style="width:100%">
                  <tr>
                    <!-- <th style="width:37%;">
                      <p>Mes de Junio</p>
                    </th> -->
                    <th>
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                        <p class="">Tipo de gasto</p>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <p class="">Porcentaje %</p>
                      </div>
                    </th>
                  </tr>
                  <tr>
                    <!-- <td>
                      <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                    </td>
                     --><td>
                      <table class="tile_info">
                        <?php if($vGastoDetalle){
                          foreach ($vGastoDetalle AS $id => $array) {?>
                            <tr>
                              <td>
                                <p><i class="fa fa-square green"></i><?=$array['gasto'] ?> </p>
                              </td>
                              <td><?=round(($array['total']*100)/$vGasto,2); ?> %  </td>
                            </tr>
                        <?php }
                        } ?>
                        
                      </table>
                    </td>
                  </tr>
                </table>
              </div>
            </div>


          </div>

          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel tile fixed_height_320">
              <div class="x_title">
                <h2>Pacientes Inactivos</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="panel-body">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Nombre</th>
                                <th>Ultima Cita</th>
                                
                              </tr>
                            </thead>
                            <tbody>
                            <?php if($vcitaInactivos){
                              foreach ($vcitaInactivos AS $id => $array) {?>  
                              <tr>
                                <td><?=$array['nombres'];?></td>
                                <td><?=$array['start'];?></td>
                                
                              </tr>
                            <?php } 
                                }else{

                                      ?>
                                <p class="excerpt">No hay Pacientes inactivos.</p>
                            <?php  } ?>  
                             
                            </tbody>
                          </table>
                        </div>
                      </div>
                
              </div>
            </div>
          </div>

        </div>

        <!-- footer content -->

        <?php include "pie.php" ?>
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

  <!-- gauge js -->
  <script type="text/javascript" src="js/gauge/gauge.min.js"></script>
  <script type="text/javascript" src="js/gauge/gauge_demo.js"></script>
  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  <!-- chart js -->
  <script src="js/chartjs/chart.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- flot js -->
  <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
  <script type="text/javascript" src="js/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="js/flot/date.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.spline.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.stack.js"></script>
  <script type="text/javascript" src="js/flot/curvedLines.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.resize.js"></script>
  <script>
    $(document).ready(function() {
      // [17, 74, 6, 39, 20, 85, 7]
      //[82, 23, 66, 9, 99, 6, 2]
      var data1 = [
        [gd(2012, 1, 1), 17],
        [gd(2012, 1, 2), 74],
        [gd(2012, 1, 3), 6],
        [gd(2012, 1, 4), 39],
        [gd(2012, 1, 5), 20],
        [gd(2012, 1, 6), 85],
        [gd(2012, 1, 7), 7]
      ];

      var data2 = [
        [gd(2012, 1, 1), 82],
        [gd(2012, 1, 2), 23],
        [gd(2012, 1, 3), 66],
        [gd(2012, 1, 4), 9],
        [gd(2012, 1, 5), 119],
        [gd(2012, 1, 6), 6],
        [gd(2012, 1, 7), 9]
      ];
      $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
        data1, data2
      ], {
        series: {
          lines: {
            show: false,
            fill: true
          },
          splines: {
            show: true,
            tension: 0.4,
            lineWidth: 1,
            fill: 0.4
          },
          points: {
            radius: 0,
            show: true
          },
          shadowSize: 2
        },
        grid: {
          verticalLines: true,
          hoverable: true,
          clickable: true,
          tickColor: "#d5d5d5",
          borderWidth: 1,
          color: '#fff'
        },
        colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
        xaxis: {
          tickColor: "rgba(51, 51, 51, 0.06)",
          mode: "time",
          tickSize: [1, "day"],
          //tickLength: 10,
          axisLabel: "Date",
          axisLabelUseCanvas: true,
          axisLabelFontSizePixels: 12,
          axisLabelFontFamily: 'Verdana, Arial',
          axisLabelPadding: 10
            //mode: "time", timeformat: "%m/%d/%y", minTickSize: [1, "day"]
        },
        yaxis: {
          ticks: 8,
          tickColor: "rgba(51, 51, 51, 0.06)",
        },
        tooltip: false
      });

      function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
      }
    });
  </script>

  <!-- worldmap -->
  <script type="text/javascript" src="js/maps/jquery-jvectormap-2.0.3.min.js"></script>
  <script type="text/javascript" src="js/maps/gdp-data.js"></script>
  <script type="text/javascript" src="js/maps/jquery-jvectormap-world-mill-en.js"></script>
  <script type="text/javascript" src="js/maps/jquery-jvectormap-us-aea-en.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script>
      function guardarnota(){
        var detalle = $('#nota').val();
        $.ajax({
          url:'actions/actionnotas.php',
          type:'POST',
          data: { opt: 'n', val: detalle  }
        }).done(function( data ){
            var num = data;
            var codigo = $('#nnotas').html();
            $('#nnotas').html(codigo + '<li id="'+num+'"><p><button type="button" class="btn btn-xs" onclick="borrarnota('+num+')"><i class="fa fa-square-o"></i> </button>'+detalle +'  </p></li>');
            //$('#nnotas').load('divs/div_notas.php');

          
        });

        $("#nota").val('');
      }

      function borrarnota(id){
        var cod = id;
        $.ajax({
          url:'actions/actionnotas.php',
          type:'POST',
          data: { opt: 'b', val: cod  }
        }).done(function( data ){
          
            //var codigo = $('#nnotas').html();
            //$('#nnotas').html(codigo + '<li><p><button type="button" class="btn btn-xs" onclick="borrarnota()"><i class="fa fa-square-o"></i> </button>'+detalle +'  </p></li>');
            //$('#nnotas').load('divs/div_notas.php');
            $('#'+id+'').hide();
            
        });

      }
  </script>
  <script>
    $(function() {
      $('#world-map-gdp').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        zoomOnScroll: false,
        series: {
          regions: [{
            values: gdpData,
            scale: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
          }]
        },
        onRegionTipShow: function(e, el, code) {
          el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
        }
      });
    });
  </script>
  <!-- skycons -->
  <script src="js/skycons/skycons.min.js"></script>
  <script>
    var icons = new Skycons({
        "color": "#73879C"
      }),
      list = [
        "clear-day", "clear-night", "partly-cloudy-day",
        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
        "fog"
      ],
      i;

    for (i = list.length; i--;)
      icons.set(list[i], list[i]);

    icons.play();
  </script>

  <!-- dashbord linegraph -->
  <script>
  //$(document).ready(function() {
    Chart.defaults.global.legend = {
       enabled: false
    }; 

      var valores2 = $.ajax({
                url: "actions/actiongasto.php?opt=d",
                                type:"POST",
                                dataType: 'json',
                                data: {
                                        maxRows: 10,
                                        q: '0'
                                },
                                success: function(data) {
                                       
                                  var data1 = data;


                                  var canvasDoughnut = new Chart(document.getElementById("canvas1"), {
                                    type: 'doughnut',
                                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                                    data: data1
                                  });
                                  }
                        }) ;

 // });
    

    
    
  </script>
  <!-- /dashbord linegraph -->
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
          days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>
  <script>
    NProgress.done();
  </script>
  <!-- /datepicker -->
  <!-- /footer content -->
</body>

</html>
