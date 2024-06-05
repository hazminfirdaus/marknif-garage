<?php

    $database= new mysqli("localhost","your-database-username","your-database-password","marknif_garage");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>