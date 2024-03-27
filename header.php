<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
$dt = date("d-M-Y");
$tim = date("H:i:s");
$dttim = date("Y-m-d H:i:s");
$footertext = "All Rights Reserved. &copy; " . date('Y') . " 24X7 Driving School | Designed By : Rajesh Krishna ";
include("dbconnection.php");
include("currenturl.php");
//Email Starts here
$sqlmail_settingrec = "SELECT * FROM mail_setting where settingtype='SMTP'";
$qmail_settingrec = mysqli_query($con,$sqlmail_settingrec);
echo mysqli_error($con);
$rsmail_settingrec = mysqli_fetch_array($qmail_settingrec);
$smtpdetailsrec = unserialize($rsmail_settingrec['settingdetails']);
$email_template_detrec = unserialize($rsmail_settingrec['email_template']);
//Email Ends here
if(isset($_POST["btncustomerlogin"]))
{
	$sql ="SELECT * FROM customer where cust_email='$_POST[customerloginid]' and cust_password='$_POST[customerpassword]' and status='Active'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_num_rows($qsql) == 1)
	{
		$rslogin = mysqli_fetch_array($qsql);
		$_SESSION['customer_id'] = $rslogin['customer_id'];
		$day = date('D');		
		//PHP Mailer Starts here
		$subject = $email_template_detrec['companyname'] . " - Login Notification..";
		$message = "Hello $rslogin[customer_name],<br>This email was sent from 24X7 Driving School website at $day $dt at $tim<br> You have Logged in successfully..
		<br><br>
		Why are we sending this? We take security very seriously and we want to keep you in the loop on important actions in your account. <br><br>
		- $email_template_detrec[companyname]	";
		include("phpmailer.php");
		sendmail($_POST['customerloginid'], $rslogin['customer_name'] , $subject, $message,'');
		//PHP Mailer Ends here
		echo "<script>window.location='customeraccount.php';</script>";
	}
	else
	{
		echo "<script>alert('Invalid login credentials entered..');</script>";
	}
}
if(isset($_POST["btnemployeelogin"]))
{
	$sql ="SELECT * FROM employee where login_id='$_POST[employeeloginid]' and password='$_POST[employeepassword]' and status='Active'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_num_rows($qsql) == 1)
	{
		$rslogin = mysqli_fetch_array($qsql);
		$_SESSION['employee_id'] = $rslogin['employee_id'];
		$_SESSION['employee_type'] = $rslogin['employee_type'];
		echo "<script>window.location='employeeaccount.php';</script>";
	}
	else
	{
		echo "<script>alert('Invalid login credentials entered..');</script>";
	}
}
if(isset($_SESSION['employee_id']))
{
	$sqlemployee ="SELECT * FROM employee where employee_id='$_SESSION[employee_id]'";
	$qsqlemployee = mysqli_query($con,$sqlemployee);
	echo mysqli_error($con);
	$rsemployee = mysqli_fetch_array($qsqlemployee);
}
if(isset($_SESSION['customer_id']))
{
	$sqlcustomer ="SELECT * FROM customer where customer_id='$_SESSION[customer_id]'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	echo mysqli_error($con);
	$rscustomer = mysqli_fetch_array($qsqlcustomer);
}
?>
<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
     <!-- Site Metas -->
    <title>24X7 Driving School</title> 

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="css/pogo-slider.min.css">
	<!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
.errorclass
{
	color: red;
    font-weight: bold;
	   animation-name: flash;
    animation-duration: 0.2s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-play-state: running;
}

@keyframes flash {
    from {color: red;}
    to {color: black;}
}
</style>
<style>
/*
.serviceBox {
    text-align: left;
}
*/
</style>
<style>
@font-face {
    font-family: "MyEncryption";
    src: url("assets/fonts/encryption.ttf");
}

.harlow {
    font-family: "MyEncryption";
}
</style>
<?php
if(isset($_SESSION['employee_id']))
{
?>
<style>
	.top-header .navbar .navbar-collapse ul li a {
		text-transform: uppercase;
		font-size: 14px;
		padding: 10px 6px;
		position: relative;
		font-weight: 500;
	}
</style>	
<?php
}
?>
</head>
<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">

	<!-- LOADER -->
     <!-- <div id="preloader">
		<div class="loader">
			<img src="images/preloader.gif" alt="" />
		</div>
    </div>end loader -->
    <!-- END LOADER -->
	
	<!-- Start top bar -->
	<div class="main-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="left-top">
						<a class="new-btn-d br-2" href="#"><span>Ph. 998605545</span></a>
						<div class="mail-b"><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i> contact@24X7drivingschool.com</a></div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="right-top">
						<ul>
<?php
if(isset($_SESSION['customer_id']))
{
?>
<li><a href="customeraccount.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Account</a></li>
<li><a href="logout.php"  ><i class="fa fa-id-card-o" aria-hidden="true"></i> Logout</a></li>
<?php
}
else if(isset($_SESSION['employee_id']))
{
?>
<li><a href="employeeaccount.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Account</a></li>
<li><a href="logout.php"  ><i class="fa fa-id-card-o" aria-hidden="true"></i> Logout</a></li>
<?php
}
else
{
?>
<li><a href="customerregister.php"  ><i class="fa fa-sign-in" aria-hidden="true"></i> Register</a></li>
<li><a href="#"  data-toggle="modal" data-target="#CustomerLoginModal"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>


<?php
}
?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End top bar -->
	
	<!-- Start header -->
	<header class="top-header">
		<nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
				<a class="navbar-brand" href="index.php"><img src="images/drivinglogo.png" alt="image"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
	<ul class="navbar-nav">
<?php
if(isset($_SESSION['employee_id']))
{
?>

	<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Driving Class
</a>
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
  <a class="dropdown-item" href="drivingclass.php">Add Driving Class</a>
  <a class="dropdown-item" href="viewdrivingclass.php">View Driving Class</a>
  <div class="dropdown-divider"></div>
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>
  <a class="dropdown-item" href="drivingclasspackage.php">Add Driving Class Package</a>
<?php
	}
?>
  <a class="dropdown-item" href="viewdrivingclasspackage.php">View Driving Class Package</a>
  <?php
if(isset($_SESSION['employee_id']))
{
?>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="viewcustomerattendance.php">Customer Attendance</a>
<?php
}
?>
</div>
</li>	

	<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Driving License
</a>
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
  <a class="dropdown-item" href="drivinglicense.php">Add Driving License</a>
  <a class="dropdown-item" href="viewdrivinglicense.php">View Driving License</a>
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="drivinglicensepackage.php">Add Driving License Package</a>
  <a class="dropdown-item" href="viewdrivinglicensepackage.php">View Driving License Package</a>
<?php
	}
?>
</div>
</li>	

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 Exam
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="questions.php">Add Question</a>
		  <a class="dropdown-item" href="viewquestions.php">View Questions</a>
			<div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="testresult.php">View Exam Result</a>
		</div>
	</li>
	
	
	<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	 Report
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
	  <a class="dropdown-item" href="viewpayment.php">Payment Report</a>
	  <a class="dropdown-item" href="view_attendance_report.php">Attendance Report</a>
	  <a class="dropdown-item" href="viewsalary.php">Salary Report</a>
	  <a class="dropdown-item" href="testresult.php">Examination Report</a>
	</div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 Salary
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>
		  <a class="dropdown-item" href="salary.php">Generate Salary</a>
<?php
	}
?>	
		  <a class="dropdown-item" href="viewsalary.php">View Salary Report</a>
		  
		  <div class="dropdown-divider"></div>
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>
		  <a class="dropdown-item" href="attendance_entry.php">Attendance Entry</a>
<?php
	}
?>	
		  <a class="dropdown-item" href="view_attendance_report.php" >Attendance Report</a>
  
		</div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 Users 
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>		
		  <a class="dropdown-item" href="employee.php">Add Employee</a>
		  <a class="dropdown-item" href="viewemployee.php">View Employees</a>
		  <div class="dropdown-divider"></div>
<?php
	}
?>
		  <a class="dropdown-item" href="customer.php">Add Customer</a>
		  <a class="dropdown-item" href="viewcustomer.php">View Customers</a>
		</div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 SETTING 
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
<?php
	if($_SESSION['employee_type'] == "Admin")
	{
?>
		  <a class="dropdown-item" href="branch.php">Add Branch</a>
		  <a class="dropdown-item" href="viewbranch.php">View Branch</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="vehicle.php">Add Vehicle</a>
		  <a class="dropdown-item" href="viewvehicle.php">View Vehicle</a>
		  <div class="dropdown-divider"></div>
<?php		  
	}
?>
		  <a class="dropdown-item" href="timeslot.php">Add User Time slot</a>
		  <a class="dropdown-item" href="viewtimeslot.php">View User Time slot</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="mailsetting.php">Mail Settings</a>
		</div>
	</li>

	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 ACCOUNT 
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="employeeprofile.php">Employee Profile</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="empchangepassword.php">Change Password</a>
		  <div class="dropdown-divider"></div>
		</div>
	</li>


<?php
}
else if(isset($_SESSION['customer_id']))
{
?>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Driving Class
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="displayselectbranch.php?bookingfor=Driving Class">Apply for Driving Class</a>
		  <a class="dropdown-item" href="viewdrivingclass.php?bookingfor=Driving%20Class">View My Application</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="viewcustomerattendance.php">Customer Attendance</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Driving License
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="displayselectbranch.php?bookingfor=Driving License">Apply for Driving License</a>
		  <a class="dropdown-item" href="viewdrivinglicense.php?bookingfor=Driving%20License">View My Application</a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Practice Tests
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="quizboard.php">Attend Exam</a>
		  <a class="dropdown-item" href="testresult.php">View Result</a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Report
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="viewdrivingclass.php?bookingfor=Driving Class">Driving Class Application Report</a>
		  <a class="dropdown-item" href="viewdrivinglicense.php?bookingfor=Driving License">Driving License Application Report</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="viewpayment.php?bookingfor=Driving Class">Driving Class Payment Report</a>
		  <a class="dropdown-item" href="viewpayment.php?bookingfor=Driving License">Driving License Payment Report</a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		My Account
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="customerprofile.php">My Profile</a>
		  <a class="dropdown-item" href="custchangepassword.php">Change Password</a>
		</div>
	</li>
<?php
}
else
{
?>
	<li><a class="nav-link" href="index.php">Home</a></li>
	<li><a class="nav-link" href="about.php">About Us</a></li>
	<li><a class="nav-link" href="contact.php">Contact</a></li>
<?php
}
?>
	</ul>
                </div>
            </div>
        </nav>
	</header>
	<!-- End header -->