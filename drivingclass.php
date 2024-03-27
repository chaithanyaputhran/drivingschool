<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE driving_class set customer_id='$_POST[customer_id]',branch_id='$_POST[branch_id]',employee_id='$_POST[employee_id]',vehicle_type='$_POST[vehicle_type]',
		package_id='$_POST[package_id]',package_cost='$_POST[package_cost]',start_date='$_POST[start_date]',timeslot_id='$_POST[timeslot_id]',note='$_POST[note]',status='$_POST[status]'WHERE class_id='$_GET[editid]'";
		
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Drivingclass record updated successfully...');</script>";
			echo "<script>window.location='viewdrivingclass.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
		$sql = "INSERT INTO driving_class(customer_id,branch_id,employee_id,vehicle_type,package_id,package_cost,start_date,timeslot_id,note,status) values('$_POST[customer_id]','$_POST[branch_id]','$_POST[employee_id]','$_POST[vehicle_type]'
		 ,'$_POST[package_id]','$_POST[package_cost]','$_POST[start_date]','$_POST[timeslot_id]','$_POST[note]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Drivingclass record inserted successfully...');</script>";
			echo "<script>window.location='drivingclass.php';</script>";
		}
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM driving_class WHERE package_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
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
		<h3 class="title">Driving class</h3>
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
		if($rscustomer['customer_id'] == $rsedit['customer_id'] )
		{
		echo "<option value='$rscustomer[customer_id]' selected>$rscustomer[customer_name]</option>";
		}
		else
		{
		echo "<option value='$rscustomer[customer_id]'>$rscustomer[customer_name]</option>";
		}
	}
	?>
	</select><span id="errcustomer_id" class="errorclass"></span>
	</div>
</div>
<br>
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
	<div class="col-md-8"  id="divemployee"><?php include("ajaxemployee.php"); ?></div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>vehicle type</div>
	<div class="col-md-8">

<input type="text" name="vehicle_type" id="vehicle_type" class="form-control"value="<?php echo $rsedit['vehicle_type']; ?>"><span id="errvehicle_type" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Package </div>
	<div class="col-md-8">

<input type="text" name="package_id" id="package_id" class="form-control"value="<?php echo $rsedit['package_id']; ?>"><span id="errpackage_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Package Cost</div>
	<div class="col-md-8">

<input type="text" name="package_cost" id="package_cost" class="form-control"value="<?php echo $rsedit['package_cost']; ?>"><span id="errpackage_cost" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Start Date</div>
	<div class="col-md-8">
	<input type="date" name="start_date" id="start_date" class="form-control"value="<?php echo $rsedit['start_date']; ?>"><span id="errstart_date" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Timeslot ID</div>
	<div class="col-md-8">
	<select name="timeslot_id" id="timeslot_id" class="form-control"value="<?php echo $rsedit['timeslot_id']; ?>">
	<option value="">Select Timeslot</option>
	<?php
	$sqltime_slots = "SELECT * FROM time_slots where status='Active'";
	$qsqltime_slots=  mysqli_query($con,$sqltime_slots);
	while($rstime_slots = mysqli_fetch_array($qsqltime_slots))
	{
		if($rstime_slots['timeslot_id'] == $rsedit['timeslot_id'])
		{
		echo "<option value='$rstime_slots[timeslot_id]' selected>$rstime_slots[start_time]</option>";
		}
		else
		{
		echo "<option value='$rstime_slots[timeslot_id]'>$rstime_slots[start_time]</option>";
		}
	}
	?>
	</select><span id="errtimeslot_id" class="errorclass" ></span>
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
		document.getElementById("errcustomer_id").innerHTML="Kindly select customer..";
		i=1;
	}
	if(document.getElementById("branch_id").value=="")
	{
		document.getElementById("errbranch_id").innerHTML="Kindly select the branch..";
		i=1;
	}
	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML="Kindly select Employee..";
		i=1;
	}
	if(document.getElementById("vehicle_type").value=="")
	{
		document.getElementById("errvehicle_type").innerHTML="Vehicle type should not be empty..";
		i=1;
	} 
	if(document.getElementById("package_id").value=="")
	{
		document.getElementById("errpackage_id").innerHTML="Package should not be empty..";
		i=1;
	}
	if(document.getElementById("package_cost").value=="")
	{
		document.getElementById("errpackage_cost").innerHTML="Package cost should not be empty..";
		i=1;
	}
	if(document.getElementById("start_date").value=="")
	{
		document.getElementById("errstart_date").innerHTML="Start date should not be empty..";
		i=1;
	}
	if(document.getElementById("timeslot_id").value=="")
	{
		document.getElementById("errtimeslot_id").innerHTML="Timeslot should not be empty..";
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