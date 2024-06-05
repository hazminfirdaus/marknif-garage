<?php

session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'c') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// Import Database
include("../connection.php");

// Get User Info
$sqlmain = "select * from customer where cemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["cid"];
$username = $userfetch["cname"];

date_default_timezone_set('Asia/Kuala_Lumpur');
$today = date('Y-m-d');
$current_time = date('H:i:s');
$twoWeeksLater = date('Y-m-d', strtotime('+2 weeks'));

// Handle search functionality
if ($_POST) {
    if (!empty($_POST["search"])) {
        $keyword = $_POST["search"];
        // Check if the keyword is a valid date
        if (strtotime($keyword)) {
            // If it's a valid date, search by scheduledate
            $sqlmain = "SELECT * FROM schedule 
                        INNER JOIN mechanic ON schedule.mecid = mechanic.mecid 
                        WHERE schedule.scheduledate = ? 
                        AND (schedule.scheduledate > ? OR (schedule.scheduledate = ? AND schedule.scheduletime > ?))
                        AND (SELECT COUNT(*) FROM appointment WHERE scheduleid = schedule.scheduleid) < schedule.noc
                        AND schedule.scheduleid NOT IN (SELECT scheduleid FROM appointment WHERE cid = ?)
                        ORDER BY schedule.scheduledate ASC";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("sssss", $keyword, $today, $today, $current_time, $userid);
        } else {
            // If it's not a date, search by mechanic name or session title
            $keyword = "%$keyword%";
            $sqlmain = "SELECT * FROM schedule 
                        INNER JOIN mechanic ON schedule.mecid = mechanic.mecid 
                        WHERE (mechanic.mecname LIKE ? OR schedule.title LIKE ?)
                        AND (schedule.scheduledate > ? OR (schedule.scheduledate = ? AND schedule.scheduletime > ?))
                        AND schedule.scheduledate BETWEEN ? AND ?
                        AND (SELECT COUNT(*) FROM appointment WHERE scheduleid = schedule.scheduleid) < schedule.noc
                        AND schedule.scheduleid NOT IN (SELECT scheduleid FROM appointment WHERE cid = ?)
                        ORDER BY schedule.scheduledate ASC";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("ssssssss", $keyword, $keyword, $today, $today, $current_time, $today, $twoWeeksLater, $userid);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $insertkey = $_POST["search"];
        $searchtype = "Search Result:";
        $q = '"';
    }
} else {
    // SQL query to fetch available sessions within the next 2 weeks
    $sqlmain = "SELECT * FROM schedule 
                INNER JOIN mechanic ON schedule.mecid = mechanic.mecid 
                WHERE (schedule.scheduledate > ? OR (schedule.scheduledate = ? AND schedule.scheduletime > ?))
                AND schedule.scheduledate BETWEEN ? AND ?
                AND (SELECT COUNT(*) FROM appointment WHERE scheduleid = schedule.scheduleid) < schedule.noc
                AND schedule.scheduleid NOT IN (SELECT scheduleid FROM appointment WHERE cid = ?)
                ORDER BY schedule.scheduledate ASC";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("ssssss", $today, $today, $current_time, $today, $twoWeeksLater, $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $insertkey = "";
    $searchtype = "Available";
    $q = '';
}
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
        
    <title>Sessions</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
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
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username, 0, 13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-mechanic">
                        <a href="mechanic.php" class="non-style-link-menu"><div><p class="menu-text">All Mechanics</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Available Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment  menu-active">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="schedule.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Mechanic Name or Email or Date (YYYY-MM-DD)" list="mechanics" value="<?php echo $insertkey ?>">&nbsp;&nbsp;
                            <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                            <datalist id="mechanics">
<?php
                                $list11 = $database->query("select DISTINCT mecname from mechanic;");
                                $list12 = $database->query("select DISTINCT title from schedule;");
                                while ($row = $list11->fetch_assoc()) {
                                    echo "<option value='" . $row["mecname"] . "'></option>";
                                }
                                while ($row = $list12->fetch_assoc()) {
                                    echo "<option value='" . $row["title"] . "'></option>";
                                }
                                ?>
                            </datalist>
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0; text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0; margin: 0;">
<?php echo $today; ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex; justify-content: center; align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px; width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)"><?php echo $searchtype . " Sessions (" . $result->num_rows . ")"; ?></p>
                        <p class="heading-main12" style="margin-left: 45px; font-size:22px; color:rgb(49, 49, 49)"><?php echo $q . $insertkey . $q; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px; border:none">
                                    <tbody>
<?php
if ($result->num_rows == 0) {
    echo '<tr>
            <td colspan="4">
                <br><br><br><br>
                <center>
                <img src="../img/notfound.svg" width="25%">
                <br>
                <p class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)">There is no available session related to your keywords!</p>
                <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left:20px;">&nbsp; Show Available Sessions &nbsp;</button></a>
                </center>
                <br><br><br><br>
            </td>
        </tr>';
} else {
    for ($x = 0; $x < ($result->num_rows); $x++) {
        echo "<tr>";
        for ($q = 0; $q < 3; $q++) {
            $row = $result->fetch_assoc();
            if (!isset($row)) {
                break;
            }
            $scheduleid = $row["scheduleid"];
            $title = $row["title"];
            $mecname = $row["mecname"];
            $scheduledate = $row["scheduledate"];
            $scheduletime = $row["scheduletime"];
            
            if ($scheduleid == "") {
                break;
            }

            echo '
            <td style="width: 25%;">
                <div class="dashboard-items search-items">
                    <div style="width:100%">
                        <div class="h1-search">
                            ' . substr($title, 0, 21) . '
                        </div><br>
                        <div class="h3-search">
                            ' . substr($mecname, 0, 30) . '
                        </div>
                        <div class="h4-search">
                            ' . $scheduledate . '<br>Starts: <b>@' . substr($scheduletime, 0, 5) . '</b>
                        </div>
                        <br>
                        <a href="booking.php?id=' . $scheduleid . '" ><button class="login-btn btn-primary-soft btn" style="padding-top:11px; padding-bottom:11px; width:100%"><font class="tn-in-text">Book Now</font></button></a>
                    </div>
                </div>
            </td>';
        }
        echo "</tr>";
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
</body>
</html>
