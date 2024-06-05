<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// Import database
include("../connection.php");

// Fetch current user details
$sqlmain = "SELECT * FROM mechanic WHERE mecemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["mecid"];
$username = $userfetch["mecname"];

if ($_GET) {
    $id = $_GET["id"];

    // Fetch the email of the mechanic to delete
    $sqlmain = "SELECT mecemail FROM mechanic WHERE mecid=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result001 = $stmt->get_result();
    $mechanic = $result001->fetch_assoc();

    if ($mechanic) {
        $email = $mechanic["mecemail"];

        // Delete from webuser
        $sqlmain = "DELETE FROM webuser WHERE email=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo "Error deleting from webuser: " . $stmt->error;
            exit;
        }

        // Delete from mechanic
        $sqlmain = "DELETE FROM mechanic WHERE mecemail=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo "Error deleting from mechanic: " . $stmt->error;
            exit;
        }

        // Redirect to logout
        header("location: ../logout.php");
    } else {
        echo "Mechanic not found.";
    }
}
?>
