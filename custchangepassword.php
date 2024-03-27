<?php
include("header.php");
if(!isset($_SESSION['customer_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
		$sql = "UPDATE customer SET cust_password='$_POST[npassword]' WHERE customer_id='$_SESSION[customer_id]' AND cust_password='$_POST[opassword]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Customer password updated successfully...');</script>";
			
		}
}
?>
<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Customer - Change Password</h3>
		<p class="description">




<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Old Password   </div>
<div class="col-md-8">
<input type="Password" name="opassword" id="opassword" class="form-control"><span id="erropassword" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>new Password  </div>
<div class="col-md-8">
<input type="Password" name="npassword" id="npassword" class="form-control"><span id="errnpassword" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Confirm Password </div>
<div class="col-md-8">
<input type="Password" name="cpassword" id="cpassword" class="form-control"><span id="errcpassword" class="errorclass" ></span>
</div>
</div>
<br>
		</p>
		<centeR><input type="submit" class="btn btn-warning" name="submit"  value="Change Password" ></center>
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
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("opassword").value=="")
	{
		document.getElementById("erropassword").innerHTML="Old Password should not be empty..";
		i=1;
	}
	if(document.getElementById("npassword").value=="")
	{
		document.getElementById("errnpassword").innerHTML="New Password should not be empty..";
		i=1;
	}
	if(document.getElementById("cpassword").value=="")
	{
		document.getElementById("errcpassword").innerHTML="Confirm Password should not be empty...";
		i=1;
	} 
	if(document.getElementById("npassword").value != document.getElementById("cpassword").value)
	{
		document.getElementById("errcpassword").innerHTML="Password and Confirm password not matching.";
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