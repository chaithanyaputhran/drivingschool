<?php
include("header.php");
if(isset($_POST['submit']))
{
	$profile_img = rand(). $_FILES['profile_img']['name'];
	move_uploaded_file($_FILES['profile_img']['tmp_name'],"imgcustprofile/".$profile_img);
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE customer set customer_name='$_POST[customer_name]',customer_address='$_POST[customer_address]',cust_email='$_POST[cust_email]',cust_mob='$_POST[cust_mob]',cust_password='$_POST[cust_password]'";
		if($_FILES['profile_img']['name'] != "")
		 {
		 $sql = $sql . ",profile_img='$profile_img'";
		 }
		$sql= $sql . ",status='$_POST[status]'  WHERE customer_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Customer record updated successfully...');</script>";
			echo "<script>window.location='viewcustomer.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	//UPdate statement ends here
	else
	{
	$sql = "INSERT INTO customer(customer_name,customer_address,cust_email,cust_mob,cust_password,profile_img,status) values('$_POST[customer_name]','$_POST[customer_address]','$_POST[cust_email]','$_POST[cust_mob]'
	 ,'$_POST[cust_password]','$profile_img','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('customer record inserted successfully...');</script>";
		echo "<script>window.location='customer.php';</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM customer WHERE customer_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>


<form method="post" action="" enctype="multipart/form-data" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Customer</h3>
		<p class="description">


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Name</div>
	<div class="col-md-8">
	<input type="text" name="customer_name" id="customer_name" class="form-control"value="<?php echo $rsedit['customer_name']; ?>">
	</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Address</div>
	<div class="col-md-8">
	<textarea name="customer_address" id="customer_address" class="form-control"><?php echo $rsedit['customer_address']; ?></textarea>
</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer Email</div>
	<div class="col-md-8">
	<input type="text" name="cust_email" id="cust_email" class="form-control" value="<?php echo $rsedit['cust_email']; ?>">
	</div>
</div>
<br>


<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Customer Mobile </div>
<div class="col-md-8">
<input type="text" name="cust_mob" id="cust_mob" class="form-control" value="<?php echo $rsedit['cust_mob']; ?>">
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Enter Password </div>
<div class="col-md-8">
<input type="Password" name="cust_password" id="cust_password" class="form-control"value="<?php echo $rsedit['cust_password']; ?>">
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Confirm Password </div>
<div class="col-md-8">
<input type="Password" name="cust_password" id="cust_password" class="form-control"value="<?php echo $rsedit['cust_password']; ?>">
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Profile Image  </div>
<div class="col-md-8" style="text-align: left;">
<input type="file" name="profile_img" id="profile_img" class="form-control">
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

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Status</div>
<div class="col-md-8">
		<select name="status" id="status" class="form-control" >
			<option value="">Select Status</option>
			<?php
			$arr = array("Active","Inactive");
			foreach($arr as $val)
			{
				
				if($val == $rsedit['status'])
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
	</div>
</div>


		</p>
		<input type="submit" class="btn btn-warning" name="submit"  value="Submit" >
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
