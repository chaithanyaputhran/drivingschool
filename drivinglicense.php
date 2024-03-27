<?php
include("header.php");
if(isset($_POST['submit']))
{
	$photo_proof = rand(). $_FILES['photo_proof']['name'];
	move_uploaded_file($_FILES['photo_proof']['tmp_name'],"imgdrvlic/".$photo_proof);
	
	$id_proof = rand(). $_FILES['id_proof']['name'];
	move_uploaded_file($_FILES['id_proof']['tmp_name'],"imgdrvlic/".$id_proof);
	
	$address_proof = rand(). $_FILES['address_proof']['name'];
	move_uploaded_file($_FILES['address_proof']['tmp_name'],"imgdrvlic/".$address_proof);
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE driving_license set customer_id='$_POST[customer_id]',reg_date='$_POST[reg_date]',package_id='$_POST[package_id]',branch_id='$_POST[branch_id]',vehicle_type='$_POST[vehicle_type]',package_cost='$_POST[package_cost]',photo_proof='$photo_proof',id_proof='$id_proof',address_proof='$address_proof',note='$_POST[note]',status='$_POST[status]'
		 WHERE dl_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Drivinglicense record updated successfully...');</script>";
			echo "<script>window.location='viewdrivinglicense.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
	$sql = "INSERT INTO driving_license(customer_id,reg_date,package_id,branch_id,vehicle_type,package_cost	,photo_proof,id_proof,address_proof,note,status) values('$_POST[customer_id]','$_POST[reg_date]','$_POST[package_id]','$_POST[branch_id]',
	 '$_POST[vehicle_type]','$_POST[package_cost]','$photo_proof','$id_proof','$address_proof','$_POST[note]','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Drivinglicense record inserted successfully...');</script>";
		echo "<script>window.location='drivinglicense.php';</script>";
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
	$sqledit = "SELECT * FROM driving_license WHERE dl_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
	
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Driving License</h3>
		<p class="description">
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer </div>
	<div class="col-md-8">
	<select name="customer_id" id="customer_id" class="form-control">
	<option value="">Select customer</option>
	<?php
	$sqlcustomer = "SELECT * FROM customer where status='Active'";
	$qsqlcustomer=  mysqli_query($con,$sqlcustomer);
	while($rscustomer= mysqli_fetch_array($qsqlcustomer))
	{
		if($rscustomer['customer_id'] == $rsedit['customer_id'])
		{
		echo "<option value='$rscustomer[customer_id]' selected>$rscustomer[customer_name]</option>";
		}
		else
		{
		echo "<option value='$rscustomer[customer_id]'>$rscustomer[customer_name]</option>";
		}
	}
	?>
	</select><span id="errcustomer_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Register Date </div>
	<div class="col-md-8">
	<input type="date" name="reg_date" id="reg_date" class="form-control">
	<span id="errreg_date" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Package </div>
	<div class="col-md-8">
	<select name="package_id" id="package_id" class="form-control">
	<option value="">Select package</option>
	<?php
	$sqlpackage = "SELECT * FROM package where status='Active'";
	$qsqlpackage=  mysqli_query($con,$sqlpackage);
	while($rspackage = mysqli_fetch_array($qsqlpackage))
	{
		if($rspackage['package_id'] == $rsedit['package_id'])
		{
		echo "<option value='$rspackage[package_id]' selected>$rspackage[package_type]</option>";
		}
		else
		{
		echo "<option value='$rspackage[package_id]'>$rspackage[package_type]</option>";
		}
	}
	?>
	</select><span id="errpackage_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Branch </div>
	<div class="col-md-8">
	<select name="branch_id" id="branch_id" class="form-control">
	<option value="">Select Branch</option>
	<?php
	$sqlbranch = "SELECT * FROM branch where status='Active'";
	$qsqlbranch=  mysqli_query($con,$sqlbranch);
	while($rsbranch = mysqli_fetch_array($qsqlbranch))
	{
		if($rsbranch['branch_id'] == $rsedit['branch_id'])
		{
		echo "<option value='$rsbranch[branch_id]' selected>$rsbranch[branch_name]</option>";
		}
		else
		{
		echo "<option value='$rsbranch[branch_id]'>$rsbranch[branch_name]</option>";
		}
	}
	?>
	</select><span id="errbranch_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Vehicle type</div>
	<div class="col-md-8">

<input type="text" name="vehicle_type" id="vehicle_type" class="form-control"value="<?php echo $rsedit['vehicle_type']; ?>"><span id="errvehicle_type" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Photo proof </div>
	<div class="col-md-8">

<input type="file" name="photo_proof" id="photo_proof" class="form-control"value="<?php echo $rsedit['photo_proof']; ?>"><span id="errphoto_proof" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>ID Proof</div>
	<div class="col-md-8">

<input type="file" name="id_proof" id="id_proof" class="form-control"value="<?php echo $rsedit['id_proof']; ?>"><span id="errid_proof" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Address Proof</div>
	<div class="col-md-8">

<input type="file" name="address_proof" id="address_proof" class="form-control"value="<?php echo $rsedit['address_proof']; ?>"><span id="erraddress_proof" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Package Cost</div>
	<div class="col-md-8">

<input type="text" name="package_cost" id="package_cost" class="form-control"value="<?php echo $rsedit['package_cost']; ?>">
<span id="errpackage_cost" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Note</div>
	<div class="col-md-8">
	<textarea name="note" id="note" class="form-control"><?php echo $rsedit['note']; ?></textarea>
	<span id="errnote" class="errorclass" ></span>
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
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("customer_id").value=="")
	{
		document.getElementById("errcustomer_id").innerHTML="Kindly select the customer..";
		i=1;
	}
	if(document.getElementById("reg_date").value=="")
	{
		document.getElementById("errreg_date").innerHTML="Registration date should not be empty..";
		i=1;
	}
	if(document.getElementById("package_id").value=="")
	{
		document.getElementById("errpackage_id").innerHTML="Package id should not be empty..";
		i=1;
	}
	if(document.getElementById("branch_id").value=="")
	{
		document.getElementById("errbranch_id").innerHTML="Branch id should not be empty..";
		i=1;
	}
	if(document.getElementById("vehicle_type").value=="")
	{
		document.getElementById("errvehicle_type").innerHTML="vehicle type should not be empty..";
		i=1;
	}
	if(document.getElementById("photo_proof").value=="")
	{
		document.getElementById("errphoto_proof").innerHTML="Photo proof should not be empty..";
		i=1;
	}
	if(document.getElementById("id_proof").value=="")
	{
		document.getElementById("errid_proof").innerHTML="Id proof should not be empty..";
		i=1;
	}
	if(document.getElementById("address_proof").value=="")
	{
		document.getElementById("erraddress_proof").innerHTML="Address proof should not be empty..";
		i=1;
	}
	if(document.getElementById("package_cost").value=="")
	{
		document.getElementById("errpackage_cost").innerHTML="Package cost should not be empty..";
		i=1;
	}
	if(document.getElementById("note").value=="")
	{
		document.getElementById("errnote").innerHTML="Note should not be empty..";
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