<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];
        $sqlmain= "select * from customer where cemail=?";
        $sql= $database->query("delete from appointment where appoid='$id';");
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $userrow = $stmt->get_result();
        $userfetch=$userrow->fetch_assoc();
        $userid= $userfetch["cid"];
        $username=$userfetch["cname"];
        //$sql= $database->query("delete from mechanic where mecemail='$email';");
        //print_r($email);
        header("location: appointment.php");
    }


?>