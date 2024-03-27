<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		//Update statement starts here
		$sql = "UPDATE time_slots set employee_id='$_POST[employee_id]',start_time='$_POST[start_time]',end_time='$_POST[end_time]',status='$_POST[status]' WHERE timeslot_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('TimeSlot record updated successfully...');</script>";
			echo "<script>window.location='viewtimeslot.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
		//UPdate statement ends here
	}
	else
	{
		//Insert statement starts here
		$sqlchk = "SELECT * FROM time_slots WHERE employee_id='$_POST[employee_id]' AND start_time='$_POST[start_time]' AND end_time='$_POST[end_time]'";
		$qsqlchk = mysqli_query($con,$sqlchk);
		if(mysqli_num_rows($qsqlchk) == 0)
		{
			$sql = "INSERT INTO time_slots(employee_id,start_time,end_time,status) values('$_POST[employee_id]','$_POST[start_time]','$_POST[end_time]','$_POST[status]')";
			$qsql = mysqli_query($con,$sql);
			if(mysqli_affected_rows($con) == 1)
			{
				echo "<script>alert('Timeslot record inserted successfully...');</script>";
				echo "<script>window.location='timeslot.php';</script>";
			}
			else
			{
				echo mysqli_error($con);
			}
		}
		else
		{
			echo "<script>alert('Time slot already assigned..');</script>";
			echo "<script>window.location='timeslot.php';</script>";
		}
		//Insert statement starts here
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM time_slots WHERE timeslot_id='$_GET[editid]'";
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
		<h3 class="title">TimeSlot</h3>
		<p class="description">

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Employee </div>
	<div class="col-md-8">
	<select name="employee_id" id="employee_id" class="form-control">
	<option value="">Select Employee</option>
	<?php
	$sqlemployee = "SELECT employee.*, branch.branch_name FROM employee LEFT JOIN branch ON employee.branch_id=branch.branch_id where employee.status='Active' AND employee.employee_type = 'Employee'";
	$qsqlemployee=  mysqli_query($con,$sqlemployee);
	while($rsemployee = mysqli_fetch_array($qsqlemployee))
	{
		if($_SESSION['employee_type'] == "Admin")
		{		
			if($rsemployee['employee_id'] == $rsedit['employee_id'])
			{
			echo "<option value='$rsemployee[employee_id]' selected>$rsemployee[employee_name] ($rsemployee[branch_name])</option>";
			}
			else
			{
			echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name] ($rsemployee[branch_name])</option>";
			}
		}
		else
		{
			if($_SESSION['employee_id'] == $rsemployee['employee_id'])
			{
			echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name] ($rsemployee[branch_name])</option>";
			}
		}
	}
	?>
	</select><span id="erremployee_id" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Start Time </div>
	<div class="col-md-8">
	<input type="time" name="start_time" id="start_time" class="form-control"value="<?php echo $rsedit['start_time']; ?>"><span id="errstart_time" class="errorclass" ></span>
	</div>
</div>

<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>End Time </div>
	<div class="col-md-8">
	<input type="time" name="end_time" id="end_time" class="form-control"value="<?php echo $rsedit['end_time']; ?>"><span id="errend_time" class="errorclass" ></span>
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
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	var i = 0;

	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML =" Kindly select employee..";
		i=1;
	}
	if(document.getElementById("start_time").value=="")
	{
		document.getElementById("errstart_time").innerHTML="Start time should not be empty..";
		i=1;
	}	   
	if(document.getElementById("end_time").value=="")
	{
		document.getElementById("errend_time").innerHTML="End time should not be empty..";
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
