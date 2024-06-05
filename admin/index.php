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
        
    <title>Admin Dashboard</title>
    <style>
        .dashboard-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    
<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");

    
    ?>
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
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashboard menu-active menu-icon-dashboard-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-mechanic ">
                        <a href="mechanic.php" class="non-style-link-menu "><div><p class="menu-text">Mechanics</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointments</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-customer">
                        <a href="customer.php" class="non-style-link-menu"><div><p class="menu-text">Customers</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                            <td colspan="2" class="nav-bar" >
                                
                                <form action="mechanic.php" method="post" class="header-search">
        
                                    <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Mechanic Name or Email" list="mechanics">&nbsp;&nbsp;
                                    
                                    <?php
                                        echo '<datalist id="mechanics">';
                                        $list11 = $database->query("select  mecname,mecemail from  mechanic;");
        
                                        for ($y=0;$y<$list11->num_rows;$y++){
                                            $row00=$list11->fetch_assoc();
                                            $d=$row00["mecname"];
                                            $c=$row00["mecemail"];
                                            echo "<option value='$d'><br/>";
                                            echo "<option value='$c'><br/>";
                                        };
        
                                    echo ' </datalist>';
                                    ?>
                                    
                               
                                    <input type="Submit" value="Search" class="login-btn btn-primary-soft btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                
                                </form>
                                
                            </td>
                            <td width="15%">
                                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    Today's Date
                                </p>
                                <p class="heading-sub12" style="padding: 0;margin: 0;">
                                    <?php 
                                date_default_timezone_set('Asia/Kuala_Lumpur');
        
                                $today = date('Y-m-d');
                                echo $today;


                                $customerrow = $database->query("select  * from  customer;");
                                $mechanicrow = $database->query("select  * from  mechanic;");
                                $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                                $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");


                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                <tr>
                <td colspan="4">
                    <center>
                        <table class="filter-container" style="border: none; width: 98%; text-align: center;">
                        <tr>
                            <td colspan="4">
                               <p style="font-size: 20px; font-weight: 600; text-align: left;">Status</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <div class="dashboard-items" style="padding: 20px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <div class="h1-dashboard">
                                            <?php echo $mechanicrow->num_rows; ?>
                                        </div>
                                        <div class="h3-dashboard">All Mechanics</div>
                                    </div>
                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/mechanic-hover.svg');"></div>
                                </div>
                            </td>
                            <td style="width: 25%;">
                                <div class="dashboard-items" style="padding: 20px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <div class="h1-dashboard">
                                            <?php echo $customerrow->num_rows; ?>
                                        </div>
                                        <div class="h3-dashboard">All Customers</div>
                                    </div>
                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/customer-hover.svg');"></div>
                                </div>
                            </td>
                            <td style="width: 25%;">
                                <div class="dashboard-items" style="padding: 20px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <div class="h1-dashboard">
                                            <?php echo $appointmentrow->num_rows; ?>
                                        </div>
                                        <div class="h3-dashboard">New Booking</div>
                                    </div>
                                     <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/book-hover.svg');"></div>
                                 </div>
                            </td>
                            <td style="width: 25%;">
                                <div class="dashboard-items" style="padding: 20px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <div class="h1-dashboard">
                                            <?php echo $schedulerow->num_rows; ?>
                                        </div>
                                        <div class="h3-dashboard" style="font-size: 17px">Today's Session</div>
                                    </div>
                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                </div>
                                </td>
                        </tr>
                        </table>
                    </center>
                </td>

                </tr>

                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" class="dashboard-tables">
                            <tr>
                                <td>
                                    <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Upcoming Appointments until Next <?php  
                                        echo date("l",strtotime("+1 week"));
                                        ?>
                                    </p>
                                    <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                        Here's quick access to Upcoming Appointments until 7 days.<br>
                                        More details available in <a class="non-style-link" href="appointment.php">@Appointments</a> section.
                                    </p>

                                </td>
                                <td>
                                    <p style="text-align:left; padding:10px;padding-left:48px;padding: bottom 20px; font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Upcoming Sessions  until Next <?php  
                                        echo date("l",strtotime("+1 week"));
                                        ?>
                                    </p>
                                    <p style="padding-bottom:19px; text-align:left; padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                        Here's quick access to Upcoming Scheduled Sessions until 7 days.<br>
                                        Add,Remove and Many features available in <a class="non-style-link" href="schedule.php">@Schedule</a> section.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <center>
                                        <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>    
                                                <th class="table-headin">
                                                        
                                                    Appointment
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    Customer
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Mechanic
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Session
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,mechanic.mecname,customer.cname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join customer on customer.cid=appointment.cid inner join mechanic on schedule.mecid=mechanic.mecid  where schedule.scheduledate>='$today'  and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc";

                                                $result= $database->query($sqlmain);
                
                                                if($result->num_rows==0){
                                                    echo '<tr>
                                                    <td colspan="3">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img style="margin-left: 40px;" src="../img/notfound.svg" width="45%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 65px;font-size:20px;color:rgb(49, 49, 49)">No Upcoming Appointments.</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:60px;">&nbsp; Show All Appointments &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    
                                                }
                                                else{
                                                for ( $x=0; $x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    $appoid=$row["appoid"];
                                                    $scheduleid=$row["scheduleid"];
                                                    $title=$row["title"];
                                                    $mecname=$row["mecname"];
                                                    $scheduledate=$row["scheduledate"];
                                                    $scheduletime=$row["scheduletime"];
                                                    $cname=$row["cname"];
                                                    $apponum=$row["apponum"];
                                                    $appodate=$row["appodate"];
                                                    echo '<tr>


                                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">
                                                            '.$apponum.'
                                                            
                                                        </td>

                                                        <td style="font-weight:600; tex-align:center;"> &nbsp;'.
                                                        
                                                        substr($cname,0,25)
                                                        .'</td >
                                                        <td style="font-weight:600; text-align:center;"> &nbsp;'.
                                                        
                                                            substr($mecname,0,25)
                                                        .'</td >                                                  
                                                        <td style="text-align: center;">
                                                        '.substr($title,0,15).'
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
                                <td width="50%" style="padding: 0;">
                                    <center>
                                        <div class="abc scroll" style="height: 200px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0" >
                                        <thead>
                                        <tr>
                                                <th class="table-headin">
                                                    
                                                
                                                Session Title
                                                
                                                </th>
                                                
                                                <th class="table-headin">
                                                    Mechanic
                                                </th>
                                                <th class="table-headin">
                                                    
                                                    Date & Time
                                                    
                                                </th>
                                                    
                                                </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "select schedule.scheduleid,schedule.title,mechanic.mecname,schedule.scheduledate,schedule.scheduletime,schedule.noc from schedule inner join mechanic on schedule.mecid=mechanic.mecid  where schedule.scheduledate>='$today' and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc"; 
                                                $result= $database->query($sqlmain);
                
                                                if($result->num_rows==0){
                                                    echo '<tr>
                                                    <td colspan="4">
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="../img/notfound.svg" width="35%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 25px;font-size:20px;color:rgb(49, 49, 49)">No Upcoming Sessions.</p>
                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show All Sessions &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    
                                                }
                                                else{
                                                for ( $x=0; $x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    $scheduleid=$row["scheduleid"];
                                                    $title=$row["title"];
                                                    $mecname=$row["mecname"];
                                                    $scheduledate=$row["scheduledate"];
                                                    $scheduletime=$row["scheduletime"];
                                                    $noc=$row["noc"];
                                                    echo '<tr>
                                                        <td style="padding:20px; text-align:center;"> &nbsp;'.
                                                        substr($title,0,30)
                                                        .'</td>
                                                        <td style="text-align:center;">
                                                        '.substr($mecname,0,20).'
                                                        </td>
                                                        <td style="text-align:center;">
                                                            '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
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
                            <tr>
                                <td>
                                    <center>
                                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show All Appointments</button></a>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show All Sessions</button></a>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                        </table>
                        </center>
                        </td>
                </tr>
            </table>
        </div>
    </div>


</body>
</html>