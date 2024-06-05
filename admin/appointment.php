<?php
    // Start the session
    session_start();

    // Check if the user is logged in and if they are an administrator
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    } else {
        header("location: ../login.php");
    }
    
    // Import database connection
    include("../connection.php");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Linking external CSS files for animations, main styles, and admin-specific styles -->
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
        
    <title>Appointments</title>
    <style>
        /* Inline styles for popup and sub-table animations */
        .popup {
            max-height: 80%;
            animation: transitionIn-Y-bottom 0.5s;
            overflow-y: auto;
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
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@marknif.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Logout button -->
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Menu navigation links -->
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
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">Appointments</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-customer">
                        <a href="customer.php" class="non-style-link-menu">
                            <div><p class="menu-text">Customers</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <!-- Back button -->
                        <a href="appointment.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Appointment Manager</p>
                    </td>
                    <td width="15%">
                        <!-- Display today's date -->
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Kuala_Lumpur');
                            $today = date('Y-m-d');
                            echo $today;
                            $list110 = $database->query("select * from appointment;");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <!-- Calendar button -->
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                            <img src="../img/calendar.svg" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Appointments (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                        <table class="filter-container" border="0">
                            <tr>
                                <td width="10%"></td> 
                                <td width="5%" style="text-align: center;">Date:</td>
                                <td width="30%">
                                    <form action="" method="post">
                                        <input type="date" name="scheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                </td>
                                <td width="5%" style="text-align: center;">Mechanic:</td>
                                <td width="30%">
                                    <select name="mecid" id="" class="box filter-container-items" style="width:90%;height: 37px;margin: 0;">
                                        <option value="" disabled selected hidden>Choose Mechanic Name from the list</option>
                                        <?php 
                                        $list11 = $database->query("select * from mechanic order by mecname asc;");
                                        for ($y=0;$y<$list11->num_rows;$y++){
                                            $row00=$list11->fetch_assoc();
                                            $sn=$row00["mecname"];
                                            $id00=$row00["mecid"];
                                            echo "<option value=".$id00.">$sn</option><br/>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td width="12%">
                                    <input type="submit" name="filter" value=" Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>
                            </tr>
                        </table>
                        </center>
                    </td>
                </tr>
                <?php
                // Handle form submission and construct SQL query based on filters
                if($_POST){
                    $sqlpt1 = !empty($_POST["scheduledate"]) ? " schedule.scheduledate='{$_POST["scheduledate"]}' " : "";
                    $sqlpt2 = !empty($_POST["mecid"]) ? " mechanic.mecid={$_POST["mecid"]} " : "";
                    $sqlmain = "select appointment.appoid,schedule.scheduleid,schedule.title,mechanic.mecname,customer.cname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join customer on customer.cid=appointment.cid inner join mechanic on schedule.mecid=mechanic.mecid";
                    $sqllist = array($sqlpt1, $sqlpt2);
                    $sqlkeywords = array(" where ", " and ");
                    $key2 = 0;
                    foreach($sqllist as $key){
                        if(!empty($key)){
                            $sqlmain .= $sqlkeywords[$key2].$key;
                            $key2++;
                        }
                    }
                } else {
                    $sqlmain = "select appointment.appoid,schedule.scheduleid,schedule.title,mechanic.mecname,customer.cname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join customer on customer.cid=appointment.cid inner join mechanic on schedule.mecid=mechanic.mecid order by schedule.scheduledate desc";
                }
                ?>
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll" style="height: 100%; padding: 0; margin: 0;">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                            <th class="table-headin">Mechanic Name</th>
                            <th class="table-headin">Customer Name</th>
                            <th class="table-headin">Appointment No.</th>
                            <th class="table-headin">Session Title</th>
                            <th class="table-headin">Session Date & Time</th>
                            <th class="table-headin">Appointment Date</th>
                            <th class="table-headin">Events</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Execute query and display results
                            $result = $database->query($sqlmain);
                            if($result->num_rows==0){
                                echo '<tr><td colspan="7"><br><br><br><br><center><img src="../img/notfound.svg" width="25%"><br><p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn\'t find anything related to your filters!</p><a class="non-style-link" href="appointment.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">Show All Appointments</button></a></center><br><br><br><br></td></tr>';
                            } else {
                                while($row=$result->fetch_assoc()){
                                    $appoid = $row["appoid"];
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $mecname = $row["mecname"];
                                    $scheduledate = $row["scheduledate"];
                                    $scheduletime = $row["scheduletime"];
                                    $cname = $row["cname"];
                                    $apponum = $row["apponum"];
                                    $appodate = $row["appodate"];
                                    echo '<tr>
                                        <td style="padding:20px; text-align:center;">&nbsp;'.substr($mecname,0,30).'</td>
                                        <td style="text-align:center;">'.substr($cname,0,20).'</td>
                                        <td style="text-align:center;">'.$apponum.'</td>
                                        <td style="text-align:center;">'.substr($title,0,30).'</td>
                                        <td style="text-align:center;">'.substr($scheduledate,0,10).' @ '.substr($scheduletime,0,5).'</td>
                                        <td style="text-align:center;">'.$appodate.'</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                <a href="?action=view&id='.$appoid.'" class="non-style-link">
                                                    <button class="btn-primary-soft btn button-icon btn-view" style="padding: 12px 40p; margin-top: 10px; text-align: center;">
                                                        <font class="tn-in-text">View</font>
                                                    </button>
                                                </a>&nbsp;&nbsp;&nbsp;<a href="?action=drop&id='.$appoid.'&name='.$cname.'" class="non-style-link">
                                                    <button class="btn-primary-soft btn button-icon btn-delete" style="padding: 12px 40p; margin-top: 10px;">
                                                        <font class="tn-in-text">Cancel</font>
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
    // Handle view and cancel actions
    if($_GET){
        $id = $_GET["id"];
        $action = $_GET["action"];
        if($action == 'view'){
            $sqlmain = "select * from appointment inner join customer on appointment.cid=customer.cid inner join schedule on schedule.scheduleid=appointment.scheduleid inner join mechanic on schedule.mecid=mechanic.mecid where appointment.appoid=$id";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $mecname = $row["mecname"];
            $cname = $row["cname"];
            $appoid = $row["appoid"];
            $apponum = $row["apponum"];
            $title = $row["title"];
            $scheduledate = $row["scheduledate"];
            $scheduletime = $row["scheduletime"];
            $appodate = $row["appodate"];
            $cid = $row["cid"];
            $ctel = $row["ctel"];
            $cemail = $row["cemail"];
            echo '<div id="popup1" class="overlay">
                    <div class="popup">
                    <center><h2></h2><a class="close" href="appointment.php">&times;</a><div class="content">Quick view<br></div><div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-mec-form-container" border="0">
                            <tr>
                                <td><p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Appointment Details.</p><br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2"><label for="name" class="form-label">Appointment number: </label></td></tr><tr><td class="label-td" colspan="2">'.$apponum.'<br><br><td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2"><label for="name" class="form-label">Session Title: </label></td></tr><tr><td class="label-td" colspan="2">'.$title.'<br><br></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2"><label for="name" class="form-label">Mechanic: </label></td></tr><tr><td class="label-td" colspan="2">'.$mecname.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Customer Name: </label></td></tr><tr><td class="label-td" colspan="2">'.$cname.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Customer Contact Number: </label></td></tr><tr><td class="label-td" colspan="2">'.$ctel.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Customer Email: </label></td></tr><tr><td class="label-td" colspan="2">'.$cemail.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Appointment Date: </label></td></tr><tr><td class="label-td" colspan="2">'.$appodate.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Session Date: </label></td></tr><tr><td class="label-td" colspan="2">'.$scheduledate.'<br><br></td></tr><tr><td class="label-td" colspan="2"><label for="name" class="form-label">Session Time: </label></td></tr><tr><td class="label-td" colspan="2">'.$scheduletime.'<br><br></td></tr><tr><td colspan="2"><a href="appointment.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a></td>
                            </tr>
                        </table>
                    </div>
                    </center><br><br></div></div>';
        } elseif($action == 'drop'){
            $name = $_GET["name"];
            echo '<div id="popup1" class="overlay"><div class="popup"><center><h2></h2><a class="close" href="appointment.php">&times;</a><div class="content">You want to delete this record<br>'.substr($name,0,40).'?</div><div style="display: flex;justify-content: center;"><a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">Yes</button></a>&nbsp;&nbsp;&nbsp;<a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">No</button></a></div></div></div>';
        }
    }
    ?>
</body>
</html>
