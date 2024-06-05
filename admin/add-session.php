<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_POST){
        //import database
        include("../connection.php");
        $title=$_POST["title"];
        $mecid=$_POST["mecid"];
        $noc=$_POST["noc"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $sql="insert into schedule (mecid,title,scheduledate,scheduletime,noc) values ($mecid,'$title','$date','$time',$noc);";
        $result= $database->query($sql);
        header("location: schedule.php?action=session-added&title=$title");
        
    }


?>