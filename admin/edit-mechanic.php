<?php
    // Import database connection
    include("../connection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extract and sanitize POST variables
        $name = $database->real_escape_string($_POST['name']);
        $oldemail = $database->real_escape_string($_POST['oldemail']);
        $spec = (int)$_POST['spec'];
        $email = $database->real_escape_string($_POST['email']);
        $tele = $database->real_escape_string($_POST['Tele']);
        $password = $database->real_escape_string($_POST['password']);
        $cpassword = $database->real_escape_string($_POST['cpassword']);
        $id = (int)$_POST['id00'];

        if ($password === $cpassword) {
            $error = '3';

            // Check if the new email already exists for another mechanic
            $stmt = $database->prepare("SELECT mechanic.mecid FROM mechanic INNER JOIN webuser ON mechanic.mecemail = webuser.email WHERE webuser.email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $id2 = $result->fetch_assoc()["mecid"];
            } else {
                $id2 = $id;
            }

            if ($id2 != $id) {
                $error = '1';
            } else {
                // Update mechanic details
                $stmt = $database->prepare("UPDATE mechanic SET mecemail = ?, mecname = ?, mecpassword = ?, mectel = ?, specialties = ? WHERE mecid = ?");
                $stmt->bind_param('ssssii', $email, $name, $password, $tele, $spec, $id);
                $stmt->execute();

                // Update webuser email
                $stmt = $database->prepare("UPDATE webuser SET email = ? WHERE email = ?");
                $stmt->bind_param('ss', $email, $oldemail);
                $stmt->execute();

                $error = '4';
            }
        } else {
            $error = '2';
        }
    } else {
        $error = '3';
    }

    // Redirect to mechanic.php with error and id parameters
    header("Location: mechanic.php?action=edit&error=$error&id=$id");
    exit();
?>
