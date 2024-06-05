<?php

// import database
include("../connection.php");

if ($_POST) {
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $spec = $_POST['spec'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        
        // Check if another mechanic has the same email
        $result = $database->query("SELECT mecid FROM mechanic WHERE mecemail='$email' AND mecid != '$id'");
        
        if ($result->num_rows > 0) {
            // Email is already taken by another mechanic
            $error = '1';
        } else {
            // Update mechanic details
            $sql1 = "UPDATE mechanic SET mecemail='$email', mecname='$name', mecpassword='$password', mectel='$tele', specialties='$spec' WHERE mecid='$id'";
            $database->query($sql1);

            // Update webuser email
            $sql2 = "UPDATE webuser SET email='$email' WHERE email='$oldemail'";
            $database->query($sql2);

            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    $error = '3';
}

header("location: settings.php?action=edit&error=" . $error . "&id=" . $id);
?>
