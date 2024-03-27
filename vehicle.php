<?php
include("header.php");
if(isset($_POST['submit']))
{
	$vehicle_img = rand(). $_FILES['vehicle_img']['name'];
	move_uploaded_file($_FILES['vehicle_img']['tmp_name'],"imgvehicle/".$vehicle_img);
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE vehicle set employee_id='$_POST[employee_id]',branch_id='$_POST[branch_id]',vehicle_type='$_POST[vehicle_type]',vehicle_no='$_POST[vehicle_no]',
	 	vehicle_name='$_POST[vehicle_name]'";
	 	if($_FILES['vehicle_img']['name'] != "")
	 	{
	 	$sql = $sql . ",vehicle_img='$vehicle_img'";
	 	}
	 	$sql = $sql . ",note='$_POST[note]',status='$_POST[status]' WHERE vehicle_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('vehicle record updated successfully...');</script>";
			echo "<script>window.location='viewvehicle.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
		$sql = "INSERT INTO vehicle(employee_id,branch_id,vehicle_type,vehicle_no,vehicle_name,vehicle_img,note,status) values('$_POST[employee_id]','$_POST[branch_id]','$_POST[vehicle_type]','$_POST[vehicle_no]',
	 '$_POST[vehicle_name]','$vehicle_img','$_POST[note]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Vehicle record inserted successfully...');</script>";
			echo "<script>window.location='vehicle.php';</script>";
		}
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM vehicle WHERE vehicle_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
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
		<center><h3 class="title">Vehicle</h3></center><hr>
		<p class="description">



<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Branch </div>
	<div class="col-md-8">
	<select name="branch_id" id="branch_id" class="form-control" onchange="loademployee(this.value)">
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
	<div class="col-md-4" style="padding-top: 7px;"	>Employee </div>
	<div class="col-md-8" id="divemployee">
<?php
include("ajaxemployee.php");
?>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Vehicle type</div>
	<div class="col-md-8">
		<select name="vehicle_type" id="vehicle_type" class="form-control" >
			<option value="">Select Vehicle type</option>
			<?php
			$arr = array("Two Wheeler","Four Wheeler");
			foreach($arr as $val)
			{
				if($val == $rsedit['vehicle_type'])
				{
				echo "<option value='$val' selected>$val</option>";
				}
				else
				{
				echo "<option value='$val'>$val</option>";
				}
			}
			?>
		</select><span id="errvehicle_type" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Vehicle Number</div>
	<div class="col-md-8">

<input type="text" name="vehicle_no" id="vehicle_no" class="form-control" value="<?php echo $rsedit['vehicle_no']; ?>"><span id="errvehicle_no" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Vehicle name</div>
	<div class="col-md-8">

<input type="text" name="vehicle_name" id="vehicle_name" class="form-control" value="<?php echo $rsedit['vehicle_name']; ?>"><span id="errvehicle_name" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Vehicle image</div>
	<div class="col-md-8" style="text-align: left;">

<input type="file" name="vehicle_img" id="vehicle_img" class="form-control" >
<?php
if(isset($_GET['editid']))
{
	echo "<img src='imgvehicle/$rsedit[vehicle_img]' style='width: 150px; height: 100px;'>";
}
?><span id="errvehicle_img" class="errorclass" ></span>
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


		</p><hr>
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
<?php
if(isset($_GET['editid']))
{
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
	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML="Kindly select employee..";
		i=1;
	}
	if(document.getElementById("branch_id").value=="")
	{
		document.getElementById("errbranch_id").innerHTML="Kindly select branch..";
		i=1;
	}
	if(document.getElementById("vehicle_type").value=="")
	{
		document.getElementById("errvehicle_type").innerHTML="Kindly select vehicle..";
		i=1;
	}
	if(document.getElementById("vehicle_no").value=="")
	{
		document.getElementById("errvehicle_no").innerHTML="Vehicle number should not be empty.. ";
		i=1;
	}
	if(document.getElementById("vehicle_name").value=="")
	{
		document.getElementById("errvehicle_name").innerHTML="Vehicle name should not be empty..";
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
<?php
}
else
{
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
	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML="Kindly select employee..";
		i=1;
	}
	if(document.getElementById("branch_id").value=="")
	{
		document.getElementById("errbranch_id").innerHTML="Kindly select branch..";
		i=1;
	}
	if(document.getElementById("vehicle_type").value=="")
	{
		document.getElementById("errvehicle_type").innerHTML="Kindly select vehicle..";
		i=1;
	}
	if(document.getElementById("vehicle_no").value=="")
	{
		document.getElementById("errvehicle_no").innerHTML="Vehicle number should not be empty.. ";
		i=1;
	}
	if(document.getElementById("vehicle_name").value=="")
	{
		document.getElementById("errvehicle_name").innerHTML="Vehicle name should not be empty..";
		i=1;
	}
	if(document.getElementById("vehicle_img").value=="")
	{
		document.getElementById("errvehicle_img").innerHTML="Vehicle image should not be empty..";
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
<?php
}
?>
<script>
function loademployee(branch_id)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
		document.getElementById("divemployee").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","ajaxemployee.php?branch_id="+branch_id,true);
	xmlhttp.send();
}
</script>