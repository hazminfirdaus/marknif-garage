<?php

    $database= new mysqli("localhost","root","Jeming_25","marknifgarage");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>