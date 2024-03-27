<?php
include("header.php");
if(isset($_POST['submit']))
{	
	$profile_img = rand(). $_FILES['profile_img']['name'];
	move_uploaded_file($_FILES['profile_img']['tmp_name'],"imgcustprofile/".$profile_img);
	if(isset($_GET['editid']))
	{
		//Update statement starts here
		$sql = "UPDATE customer set customer_name='$_POST[customer_name]',gender='$_POST[gender]',dob='$_POST[dob]',customer_address='$_POST[customer_address]',cust_email='$_POST[cust_email]',cust_mob='$_POST[cust_mob]',cust_password='$_POST[cust_password]'";
		if($_FILES['profile_img']['name'] != "")
		 {
		 $sql = $sql . ",profile_img='$profile_img'";
		 }
		$sql= $sql . ",status='$_POST[status]'  WHERE customer_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Customer record updated successfully...');</script>";
			echo "<script>window.location='viewcustomer.php';</script>";
		}
		//UPdate statement ends here
	}
	else
	{
		//Insert statement Starts here
		$sql = "INSERT INTO customer(customer_name,customer_address,cust_email,cust_mob,cust_password,profile_img,status,gender,dob) values('$_POST[customer_name]','$_POST[customer_address]','$_POST[cust_email]','$_POST[cust_mob]','$_POST[cust_password]','$profile_img','Active','$_POST[gender]','$_POST[dob]')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			include("currenturl.php");
			//PHP Mailer Starts here
			$subject = "Successfull Registration for Driving school..";
			$message = "Hello $_POST[customer_name],<br>Thanks for Registration<br> You have registered successfully.. Login to Apply for Driving school Registration and for Driving license...
			<br><br>
			<center><a style='color:#ffffff; background-color: #00a5b5;  border-top: 10px solid #00a5b5; border-bottom: 10px solid #00a5b5; border-left: 20px solid #00a5b5; border-right: 20px solid #00a5b5; border-radius: 3px; text-decoration:none;' href='$url'>Click Here to Login</a></center>
			";
			include("phpmailer.php");
			sendmail($_POST['cust_email'], $_POST['customer_name'] , $subject, $message,'');
			//PHP Mailer Ends here
			echo "<script>alert('Customer Registration done  successfully...');</script>";
			echo "<script>window.location='index.php';</script>";
		}
		else
		{
			echo "<script>alert('You have already registered..');</script>";
			echo "<script>window.location='index.php';</script>";
		}
		//Insert statement Ends here
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM customer WHERE customer_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>


<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Customer Registration Panel</h3>
		<p class="description">

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Name</div>
	<div class="col-md-8">
	<input type="text" name="customer_name" id="customer_name" class="form-control"value="<?php echo $rsedit['customer_name']; ?>"><span id="errcustomer_name" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Gender</div>
	<div class="col-md-8">
	<select name="gender" id="gender" class="form-control">
		<option value="">Select Gender</option>
		<?php
		$arr = array("Male","Female");
		foreach($arr as $val)
		{
			echo "<option value='$val'>$val</option>";
		}
		?>
	</select><span id="errgender" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Date of Birth</div>
	<div class="col-md-8">
	<input type="date" name="dob" id="dob" class="form-control"value="<?php $StaringDate= date("Y-m-d"); echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($StaringDate)) . " - 15 years")); ?>" max="<?php $StaringDate= date("Y-m-d"); echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($StaringDate)) . " - 5 years")); ?>" ><span id="errdob" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Address</div>
	<div class="col-md-8">
	<textarea name="customer_address" id="customer_address" class="form-control"><?php echo $rsedit['customer_name']; ?></textarea><span id="errcustomer_address" class="errorclass" ></span>
</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Email</div>
	<div class="col-md-8">
	<input type="text" name="cust_email" id="cust_email" class="form-control" value="<?php echo $rsedit['cust_email']; ?>"><span id="errcust_email" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Customer Mobile </div>
<div class="col-md-8">
<input type="text" name="cust_mob" id="cust_mob" class="form-control" value="<?php echo $rsedit['cust_mob']; ?>"><span id="errcust_mob" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Enter Password </div>
<div class="col-md-8">
<input type="Password" name="cust_password" id="cust_password" class="form-control"value="<?php echo $rsedit['cust_password']; ?>"><span id="errcust_password" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Confirm Password </div>
<div class="col-md-8">
<input type="Password" name="cust_cpassword" id="cust_cpassword" class="form-control"value="<?php echo $rsedit['cust_password']; ?>"><span id="errcust_cpassword" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Profile Image  </div>
<div class="col-md-8" style="text-align: left;">
<input type="file" name="profile_img" id="profile_img" class="form-control"><span id="errprofile_img" class="errorclass" ></span>
<?php
if(isset($_GET['editid']))
{
	if($rsedit['profile_img'] == "")
	{
		$imgname="images/default-image.jpg";
	}
	else if(file_exists("imgcustprofile/".$rsedit['profile_img']))
	{
		$imgname= "imgcustprofile/".$rsedit['profile_img'];
	}
	else
	{
		$imgname="images/default-image.jpg";
	}
	echo "<img src='$imgname' style='width: 125px; height: 150px;' >";
}
?>
</div>
</div>
<br>
</p>
<center><input type="submit" class="btn btn-warning" name="submit"  value="Click here to Register" ></center>
	</div>
</div>

				</div>
				<div class="col-lg-2"></div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
</form>
<?php
include("footer.php");
?>
<script>
function validateform()
{	
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	
	var i = 0;

	
	if(document.getElementById("customer_name").value=="")
	{
		document.getElementById("errcustomer_name").innerHTML="Customer name should not be empty..";
		i=1;
	}
	if(document.getElementById("customer_address").value=="")
	{
		document.getElementById("errcustomer_address").innerHTML="Customer address should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_email").value=="")
	{
		document.getElementById("errcust_email").innerHTML="Customer email should not be empty..";
		i=1;
	}
	if(document.getElementById("gender").value=="")
	{
		document.getElementById("errgender").innerHTML="Gender should not be empty..";
		i=1;
	} 
	if(document.getElementById("dob").value=="")
	{
		document.getElementById("errdob").innerHTML="Date of Birth should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_mob").value=="")
	{
		document.getElementById("errcust_mob").innerHTML="Customer mobile number should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_password").value=="")
	{
		document.getElementById("errcust_password").innerHTML="Customer password should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_cpassword").value == "")
	{
		document.getElementById("errcust_cpassword").innerHTML=" Confirm password should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_cpassword").value != document.getElementById("cust_password").value)
	{
		document.getElementById("errcust_cpassword").innerHTML="Password and Confirm password not matching..";
		i=1;
	}
	if(document.getElementById("profile_img").value=="")
	{
		document.getElementById("errprofile_img").innerHTML="Kindly upload profile image.";
		i=1;
	}
	if(i==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>