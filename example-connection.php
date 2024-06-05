<?php

    $database= new mysqli("localhost","your-database-username","your-database-password","your-database-name");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>