<?php
include '../data/dataBase.php';
include '../classes/cnotas.php';
 $oNota  = new notas();


  $vNotas   = $oNota->getAllusuario($_SESSION['csmart']['idusuario']);

?>

<div>
<ul class="to_do">
                        <?php if($vNotas){
                                foreach ($vNotas AS $id => $array) {?>

                                <li>
                                  <p>
                                    <button type="button" class="btn btn-xs" onclick="borrarnota(<?=$array['idnota'];?>)"> 
                                <i class="fa fa-check-square-o"></i> </button> <?=$array['detalle'];?> </p>
                                </li>
                                
                        <?php } } ?>
                        
                         
</ul></div>