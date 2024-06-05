<?php
ob_start(); // Start output buffering
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != 'a') {
    header("location: ../login.php");
    exit();
}

include("../connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <title>Customers</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .center-align {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="User Profile" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@marknif.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php">
                                        <input type="button" value="Log out" class="logout-btn btn-primary-soft btn">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashboard">
                        <a href="index.php" class="non-style-link-menu">
                            <div><p class="menu-text">Dashboard</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-mechanic">
                        <a href="mechanic.php" class="non-style-link-menu">
                            <div><p class="menu-text">Mechanics</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu">
                            <div><p class="menu-text">Schedule</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div><p class="menu-text">Appointments</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-customer menu-active menu-icon-customer-active">
                        <a href="customer.php" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">Customers</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
                <tr>
                    <td width="13%">
                        <a href="customer.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding: 11px 0; margin-left: 20px; width: 125px;">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Customer Name or Email" list="customer">
                            &nbsp;&nbsp;
                            <?php
                                echo '<datalist id="customer">';
                                $list11 = $database->query("SELECT cname, cemail FROM customer;");
                                while ($row00 = $list11->fetch_assoc()) {
                                    echo "<option value='{$row00["cname"]}'></option>";
                                    echo "<option value='{$row00["cemail"]}'></option>";
                                }
                                echo '</datalist>';
                            ?>
                            <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px 25px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0; text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0; margin: 0;">
                            <?php
                                date_default_timezone_set('Asia/Kuala_Lumpur');
                                echo date('Y-m-d');
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex; justify-content: center; align-items: center;">
                            <img src="../img/calendar.svg" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 10px;">
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49);">
                            All Customers (<?php echo $list11->num_rows; ?>)
                        </p>
                    </td>
                </tr>
                <?php                
                    $keyword = $_POST['search'] ?? '';
                    $sqlmain = empty($keyword)
                        ? "SELECT * FROM customer ORDER BY cid DESC"
                        : "SELECT * FROM customer WHERE cemail='$keyword' OR cname='$keyword' OR cname LIKE '$keyword%' OR cname LIKE '%$keyword%'";

                    $result = $database->query($sqlmain);
                ?>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Name</th>
                                            <th class="table-headin">Telephone</th>
                                            <th class="table-headin">Email</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($result->num_rows == 0) {
                                                echo '<tr>
                                                    <td colspan="5">
                                                        <center>
                                                            <img src="../img/notfound.svg" width="25%">
                                                            <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49);">
                                                                We couldn\'t find any customers related to your keywords!
                                                            </p>
                                                            <a class="non-style-link" href="customer.php">
                                                                <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">
                                                                    &nbsp; Show all Customers &nbsp;
                                                                </button>
                                                            </a>
                                                        </center>
                                                    </td>
                                                </tr>';
                                            } else {
                                                while ($row = $result->fetch_assoc()) {
                                                    $cid = $row['cid'];
                                                    $name = $row['cname'];
                                                    $email = $row['cemail'];
                                                    $tele = $row['ctel'];
                                                    echo '<tr>
                                                        <td style="padding:20px;" class="center-align">&nbsp;'.substr($name,0,30).'</td>
                                                        <td class="center-align">'.substr($tele,0,10).'</td>
                                                        <td class="center-align">'.substr($email,0,30).'</td>
                                                        <td class="center-align">
                                                            <div style="display:flex; justify-content:center;" class="center-align">
                                                                <a href="?action=view&id='.$cid.'" class="non-style-link">   
                                                                    <button class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px; padding-top: 12px;padding-bottom: 12px; margin-top: 10px;>
                                                                        <font class="tn-in-text">View</font>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>';
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
        if ($_GET) {
            $id = $_GET['id'];
            $sqlmain = "SELECT * FROM customer WHERE cid='$id'";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $name = $row['cname'];
            $email = $row['cemail'];
            $tele = $row['ctel'];
            echo "
            <div id='popup1' class='overlay'>
                <div class='popup'>
                    <center>
                        <a class='close' href='customer.php'>&times;</a>
                        <div class='content'></div>
                        <div style='display: flex; justify-content: center;'>
                            <table width='80%' class='sub-table scrolldown add-mec-form-container' border='0'>
                                <tr>
                                    <td>
                                        <p style='padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;'>View Details.</p>
                                        <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='name' class='form-label'>Customer ID: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>C-{$id}<br><br></td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='name' class='form-label'>Name: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>{$name}<br><br></td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='Email' class='form-label'>Email: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>{$email}<br><br></td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='Tele' class='form-label'>Telephone: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>{$tele}<br><br></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        <a href='customer.php'>
                                            <input type='button' value='OK' class='login-btn btn-primary-soft btn'>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </center>
                    <br><br>
                </div>
            </div>";
        }
    ?>
</body>
</html>
<?php ob_end_flush(); // Flush the output buffer ?>
