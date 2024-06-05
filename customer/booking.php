<?php


    // Start session and check user authentication  
    session_start();

    if (isset($_SESSION["user"])) {
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='c'){
            header("location: ../login.php");
        } else {
            $useremail=$_SESSION["user"];
        }

    } else {
        header("location: ../login.php");
    }
    
    // Import database connection
    include("../connection.php");

    $sqlmain= "select * from customer where cemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["cid"];
    $username=$userfetch["cname"];

    date_default_timezone_set('Asia/Kuala_Lumpur');

    $today = date('Y-m-d');
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
        
    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
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
                                 <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                 <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
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
             <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-mechanic">
                        <a href="mechanic.php" class="non-style-link-menu"><div><p class="menu-text">All Mechanics</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Available Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="schedule.php" method="post" class="header-search">

                                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Mechanic name or Email or Date (YYYY-MM-DD)" list="mechanics" >&nbsp;&nbsp;
                                        
                                        <?php
                                            echo '<datalist id="mechanics">';
                                            $list11 = $database->query("SELECT DISTINCT mecname FROM mechanic;");
                                            $list12 = $database->query("SELECT DISTINCT title FROM schedule GROUP BY title;");


                                            for ($y=0;$y<$list11->num_rows;$y++){
                                                $row00=$list11->fetch_assoc();
                                                $d=$row00["mecname"];
                                               
                                                echo "<option value='$d'><br/>";
                                               
                                            };


                                            for ($y=0;$y<$list12->num_rows;$y++){
                                                $row00=$list12->fetch_assoc();
                                                $d=$row00["title"];
                                               
                                                echo "<option value='$d'><br/>";
                                                                                         };

                                        echo ' </datalist>';
            ?>
                                        
                                
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                                
                                echo $today;

                                

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <!-- <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);font-weight:400;">Available Sessions / Booking / <b>Review Booking</b></p> -->
                        
                    </td>
                    
                </tr>
                
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                            
                        <tbody>
                        
                            <?php
                            
                            if (($_GET)) {
                                if (isset($_GET["id"])){
                                    
                                    $id=$_GET["id"];
                                    $useremail=$_SESSION["user"];

                                    // Get the user's ID based on their email
                                    $sql_get_user_id = "SELECT cid FROM customer WHERE cemail = ?";
                                    $stmt_get_user_id = $database->prepare($sql_get_user_id);
                                    $stmt_get_user_id->bind_param("s", $useremail);
                                    $stmt_get_user_id->execute();
                                    $result_get_user_id = $stmt_get_user_id->get_result();
                                    $row_get_user_id = $result_get_user_id->fetch_assoc();
                                    $userid = $row_get_user_id['cid'];

                                    // Query to check if the customer has already booked an appointment for this session
                                    $sql_check_booking = "SELECT COUNT(*) AS num_bookings FROM appointment WHERE scheduleid = ? AND cid = ?";
                                    $stmt_check_booking = $database->prepare($sql_check_booking);
                                    $stmt_check_booking->bind_param("ii", $id, $userid);
                                    $stmt_check_booking->execute();
                                    $result_check_booking = $stmt_check_booking->get_result();
                                    $row_check_booking = $result_check_booking->fetch_assoc();
                                    $num_bookings = $row_check_booking['num_bookings'];

                                    // If the customer has already booked this session, prevent booking
                                    if ($num_bookings > 0) {
                                        echo '
                                        <div id="popup1" class="overlay" style="padding: 200px;">
                                            <div class="popup">
                                                <h2>You have already booked this session.</h2>
                                                <a class="close" href="appointment.php">&times;</a>
                                                <div class="content">
                                                    Please check <a href="appointment.php" class="non-style-link" style="font-size: 18px; color: #C17817;">@My Bookings</a> section.
                                                </div>
                                            </div>
                                        </div>
                                        ';
                                    } else {
                                        $sqlmain= "SELECT * FROM schedule
                                                    INNER JOIN mechanic ON schedule.mecid = mechanic.mecid
                                                    WHERE schedule.scheduleid = ? ORDER BY schedule.scheduledate DESC";
                                        $stmt = $database->prepare($sqlmain);
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        //echo $sqlmain;
                                        $row=$result->fetch_assoc();
                                        $scheduleid=$row["scheduleid"];
                                        $title=$row["title"];
                                        $mecname=$row["mecname"];
                                        $mecemail=$row["mecemail"];
                                        $scheduledate=$row["scheduledate"];
                                        $scheduletime=$row["scheduletime"];
    
                                        // Count the number of existing appointments for this session
                                        $sql2="SELECT COUNT(*) AS total_appointments FROM appointment WHERE scheduleid = ?";
                                        $stmt = $database->prepare($sql2);
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $total_appointments = $row['total_appointments'];
    
                                        // Retrieve the maximum number of customers allowed for this session
                                        $sql3 = "SELECT noc FROM schedule WHERE scheduleid = ?";
                                        $stmt = $database->prepare($sql3);
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $max_customers_allowed = $row['noc'];
                                        
                                        // Check if the session is fully booked
                                        if ($total_appointments < $max_customers_allowed) {
                                            // Allow the customer to make a booking
                                            $apponum = $total_appointments + 1;
                                            echo '
                                            <form action="booking-complete.php" method="post">
                                                <input type="hidden" name="scheduleid" value="'.$scheduleid.'" >
                                                <input type="hidden" name="apponum" value="'.$apponum.'" >
                                                <input type="hidden" name="date" value="'.$today.'" >
    
                                                <td style="width: 50%;" rowspan="2">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                    <div style="width:100%">
                                                            <div class="h1-search" style="font-size:25px;">
                                                                Session Details
                                                            </div><br><br>
                                                            <div class="h3-search" style="font-size:18px;line-height:30px">
                                                                Mechanic name:  &nbsp;&nbsp;<b>'.$mecname.'</b><br>
                                                                Mechanic Email:  &nbsp;&nbsp;<b>'.$mecemail.'</b> 
                                                            </div>
                                                            <div class="h3-search" style="font-size:18px;">
                                                              
                                                            </div><br>
                                                            <div class="h3-search" style="font-size:18px;">
                                                                Session Title: '.$title.'<br>
                                                                Session Scheduled Date: '.$scheduledate.'<br>
                                                                Session Starts : '.$scheduletime.'<br>
    
                                                            </div>
                                                            <br>
                                                            
                                                    </div>
                                                            
                                                </div>
                                            </td>
    
                                            <td style="width: 25%;">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                    <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                                            <div class="h1-search" style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                                                Your Appointment Number
                                                            </div>
                                                            <center>
                                                            <div class=" dashboard-icons" style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">'.$apponum.'</div>
                                                        </center>
                                                           
                                                            </div><br>
                                                            
                                                            <br>
                                                            <br>
                                                    </div>
                                                            
                                                </div>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="Submit" class="login-btn btn-primary btn btn-book" style="margin-left:10px;padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;width:95%;text-align: center;" value="Book Now" name="booknow"></button>
                                                </form>
                                                </td>
                                            </tr>
                                            </form>';
                                        } else {
                                            // Display a message to inform the customer that the session is fully booked
                                            echo '
                                            <div id="popup1" class="overlay" style="padding: 200px;">
                                                <div class="popup">
                                                    <h2>Sorry, this session is fully booked.</h2>
                                                    <a class="close" href="schedule.php">&times;</a>
                                                    <div class="content">
                                                        Please check other session <a href="schedule.php" class="non-style-link" style="font-size: 18px; color: #C17817;">@Available Sessions</a>.
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                                        }
                                    }
                                } else {
                                    // Display an error message if session ID is not provided
                                    echo '<tr><td colspan="2">Session ID not provided.</td></tr>';
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
    </div>

</body>
</html>