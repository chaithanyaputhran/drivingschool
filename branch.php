<?php
include("header.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		//Update statement starts here
		$sql = "UPDATE branch set branch_name='$_POST[branch_name]',branch_address='$_POST[branch_address]',contact_no='$_POST[contact_no]',status='$_POST[status]' WHERE branch_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Branch record updated successfully...');</script>";
			echo "<script>window.location='viewbranch.php';</script>";
		}
		//UPdate statement ends here
	}
	else
	{
		//Insert statement starts here
		$sql = "INSERT INTO branch(branch_name,branch_address,contact_no,status) values('$_POST[branch_name]','$_POST[branch_address]','$_POST[contact_no]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Branch record inserted successfully...');</script>";
			echo "<script>window.location='branch.php';</script>";
		}
		//Insert statement starts here
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM branch WHERE branch_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Branch</h3>
		<p class="description">


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Branch Name</div>
	<div class="col-md-8">
	<input type="text" name="branch_name" id="branch_name" class="form-control"value="<?php echo $rsedit['branch_name']; ?>"><span id="errbranch_name" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Branch address</div>
	<div class="col-md-8">
	<textarea name="branch_address" id="branch_address" class="form-control"><?php echo $rsedit['branch_address']; ?></textarea><span id="errbranch_address" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Contact number</div>
	<div class="col-md-8">
	<input type="text" name="contact_no" id="contact_no" class="form-control"value="<?php echo $rsedit['contact_no']; ?>"><span id="errcontact_no" class="errorclass" ></span>
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
		</select><span id="errstatus" class="errorclass" ></span>
	</div>
</div>
</p>
		<center><input type="submit" class="btn btn-warning" name="submit"  value="Submit" ></center>
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
	if(document.getElementById("branch_name").value=="")
	{
		document.getElementById("errbranch_name").innerHTML="Branch Name should not be empty..";
		i=1;
	}
	if(document.getElementById("branch_address").value=="")
	{
		document.getElementById("errbranch_address").innerHTML="Branch address should not be empty..";
		i=1;
	}
	
	if(document.getElementById("branch_address").value=="")
	{
		document.getElementById("errcontact_no").innerHTML="Contact number should not be empty..";
		i=1;
	}
	if(document.getElementById("status").value=="")
	{
		document.getElementById("errstatus").innerHTML="Kindly select status.";
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