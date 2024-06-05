<?php
// Start the session
session_start();

// Unset all the server-side variables
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

// Import database connection
include("connection.php");

if ($_POST) {
    // Check if personal session data is set
    if (isset($_SESSION['personal'])) {
        $fname = $_SESSION['personal']['fname'];
        $lname = $_SESSION['personal']['lname'];
        $name = $fname . " " . $lname;
        $email = $_POST['newemail'];
        $tele = $_SESSION['personal']['tele'];
        $newpassword = $_POST['newpassword'];
        $conpassword = $_POST['conpassword'];

        
        // Validate password confirmation
        if ($newpassword == $conpassword) {
            $sqlmain = "SELECT * FROM webuser WHERE email=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">An account with this email address already exists.</label>';
            } else {
                // Insert into customer table
                $stmt = $database->prepare("INSERT INTO customer (cemail, cname, cpassword, ctel) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $name, $newpassword, $tele);
                $stmt->execute();
                
                // Insert into webuser table
                $stmt = $database->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 'c')");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                // Set session variables and redirect
                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "c";
                $_SESSION["username"] = $fname;

                header('Location: customer/index.php');
                exit();
            }
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password confirmation error! Please re-confirm your password.</label>';
        }
    } else {
        // Redirect to signup page if personal data is not set
        header('Location: signup.php');
        exit();
    }
} else {
    $error = '<label for="promter" class="form-label"></label>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<center>
<div class="container">
    <table border="0" style="width: 69%;">
        <tr>
            <td colspan="2">
                <p class="header-text">Let's Get Started</p>
                <p class="sub-text">It's Okay, Now Create User Account.</p>
            </td>
        </tr>
        <tr>
            <form action="" method="POST">
            <td class="label-td" colspan="2">
                <label for="newemail" class="form-label">Email: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="newpassword" class="form-label">Create New Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="conpassword" class="form-label">Confirm Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="conpassword" class="input-text" placeholder="Confirm Password" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $error; ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
            </td>
            <td>
                <input type="submit" value="Sign Up" class="login-btn btn-primary btn" style="border: none;">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                <a href="login.php" class="hover-link1 non-style-link">Login</a>
                <br><br><br>
            </td>
        </tr>
            </form>
        </tr>
    </table>
</div>
</center>
</body>
</html>
