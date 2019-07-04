<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
    	$id 	= $_REQUEST['id'];
    	$tipo 	= $_REQUEST['tipo'];
    	if(file_exists("images/".$tipo."/".$id."/") == false){
			mkdir("images/".$tipo."/".$id."/");
        	move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$tipo.'/' . $id . '/' . $_FILES['file']['name']);
		}else{
			move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$tipo.'/' . $id . '/' . $_FILES['file']['name']);
		}

    	
    }

?>