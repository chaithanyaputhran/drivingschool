<?php
include("header.php");
if(isset($_POST['submit']))
{
	$profile_img = rand(). $_FILES['profile_img']['name'];
	move_uploaded_file($_FILES['profile_img']['tmp_name'],"imgcustprofile/".$profile_img);
	
	//Update statement starts here
	if(isset($_SESSION['customer_id']))
	{
		$sql = "UPDATE customer set customer_name='$_POST[customer_name]',gender='$_POST[gender]',dob='$_POST[dob]',customer_address='$_POST[customer_address]',cust_email='$_POST[cust_email]',cust_mob='$_POST[cust_mob]'";
		if($_FILES['profile_img']['name'] != "")
		 {
		 $sql = $sql . ",profile_img='$profile_img'";
		 }
		$sql= $sql . "  WHERE customer_id='$_SESSION[customer_id]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Customer Profile updated successfully...');</script>";
			echo "<script>window.location='customerprofile.php';</script>";
		}
	}
	//UPdate statement ends here
}
?>
<?php
if(isset($_SESSION['customer_id']))
{
	$sqledit = "SELECT * FROM customer WHERE customer_id='$_SESSION[customer_id]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>

<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Customer Profile</h3>
		<p class="description">


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Name</div>
	<div class="col-md-8">
	<input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $rsedit['customer_name']; ?>">
	<span id="errcustomer_name" class="errorclass" ></span>
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
			if($val == $rsedit['gender'])
			{
			echo "<option value='$val' selected>$val</option>";
			}
			else
			{
			echo "<option value='$val'>$val</option>";
			}
		}
		?>
	</select>
	<span id="errgender" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Date of Birth</div>
	<div class="col-md-8">
	<input type="date" name="dob" id="dob" class="form-control"value="<?php echo  $rsedit['dob']; ?>" max="<?php $StaringDate= date("Y-m-d"); echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($StaringDate)) . " - 5 years")); ?>" >
	<span id="errdob" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Address</div>
	<div class="col-md-8">
	<textarea name="customer_address" id="customer_address" class="form-control"><?php echo $rsedit['customer_address']; ?></textarea>
	<span id="errcustomer_address" class="errorclass" ></span>
</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Email</div>
	<div class="col-md-8">
	<input type="text" name="cust_email" id="cust_email" class="form-control" value="<?php echo $rsedit['cust_email']; ?>">
	<span id="errcust_email" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Customer Mobile </div>
<div class="col-md-8">
<input type="text" name="cust_mob" id="cust_mob" class="form-control" value="<?php echo $rsedit['cust_mob']; ?>">
	<span id="errcust_mob" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Profile Image  </div>
<div class="col-md-8" style="text-align: left;">
<input type="file" name="profile_img" id="profile_img" class="form-control">
	<span id="errprofile_img" class="errorclass" ></span><br>
<?php
if(isset($_SESSION['customer_id']))
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
		<centeR><input type="submit" class="btn btn-warning" name="submit"  value="Update Profile" ></center>
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
	if(document.getElementById("gender").value=="")
	{
		document.getElementById("errgender").innerHTML="Customer name should not be empty..";
		i=1;
	}
	if(document.getElementById("dob").value=="")
	{
		document.getElementById("errdob").innerHTML="Customer address should not be empty..";
		i=1;
	}
	if(document.getElementById("customer_address").value=="")
	{
		document.getElementById("errcustomer_address").innerHTML="Customer email should not be empty..";
		i=1;
	}
	//      
	if(document.getElementById("cust_email").value=="")
	{
		document.getElementById("errcust_email").innerHTML="Customer mobile number should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_mob").value=="")
	{
		document.getElementById("errcust_mob").innerHTML="Customer password should not be empty..";
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