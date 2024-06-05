<?php

//import database
include("../connection.php");

if ($_POST) {
    $result = $database->query("SELECT * FROM webuser");
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];
    $id = $_POST['id00'];

    if ($password == $conpassword) {
        $error = '3';

        $sqlmain = "SELECT customer.cid FROM customer INNER JOIN webuser ON customer.cemail=webuser.email WHERE webuser.email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $id2 = $result->fetch_assoc()["cid"];
        } else {
            $id2 = $id;
        }

        if ($id2 != $id) {
            $error = '1';
        } else {
            $sql1 = "UPDATE customer SET cemail=?, cname=?, cpassword=?, ctel=? WHERE cid=?;";
            $stmt = $database->prepare($sql1);
            $stmt->bind_param("ssssi", $email, $name, $password, $tele, $id);
            if ($stmt->execute()) {
                // echo "Customer update successful: " . $sql1;
            } else {
                echo "Customer update failed: " . $stmt->error;
            }

            $sql1 = "UPDATE webuser SET email=? WHERE email=?;";
            $stmt = $database->prepare($sql1);
            $stmt->bind_param("ss", $email, $oldemail);
            if ($stmt->execute()) {
                // echo "Webuser update successful: " . $sql1;
            } else {
                echo "Webuser update failed: " . $stmt->error;
            }

            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    $error = '3';
}

header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>
