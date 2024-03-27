<?php
include("header.php");
if(!isset($_SESSION['customer_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		//Update statement starts here
		$sql = "UPDATE driving_class set customer_id='$_POST[customer_id]',branch_id='$_POST[branch_id]',employee_id='$_POST[employee_id]',vehicle_type='$_POST[vehicle_type]',
		package_id='$_POST[package_id]',package_cost='$_POST[package_cost]',start_date='$_POST[start_date]',timeslot_id='$_POST[timeslot_id]',note='$_POST[note]',status='$_POST[status]'WHERE class_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Drivingclass record updated successfully...');</script>";
			echo "<script>window.location='viewdrivingclass.php';</script>";
		}
		//Update statement ends here
	}	
	else
	{
		//Insert statement starts here
		$sqlpackage = "SELECT package.*,branch.branch_name FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_type='Driving Class' AND package.package_id='$_GET[package_id]'";
		$qsqlpackage = mysqli_query($con,$sqlpackage);
		$rspackage = mysqli_fetch_array($qsqlpackage);
		$sql = "INSERT INTO driving_class(customer_id,branch_id,employee_id,vehicle_type,package_id,package_cost,start_date,end_date,timeslot_id,note,status) values('$_SESSION[customer_id]','$_GET[branch_id]','$_POST[employee_id]','$rspackage[vehicle_type]','$rspackage[package_id]','$rspackage[package_cost]','$_POST[start_date]','$_POST[end_date]','$_POST[timeslot_id]','$_POST[note]','Pending')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			$insid = mysqli_insert_id($con);			
			echo "<script>alert('Driving class application submission under process...');</script>";
			echo "<script>window.location='drivingclasspayment.php?insid=$insid';</script>";
		}
		//Insert statement ends here
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM driving_class WHERE package_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
	<!-- Start About us -->
	<div id="about" class="about-box" style="background-color: brown; ">
		<div class="about-a1">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title-box">
<h2 style="color: white;">Driving Class Application Form</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End About us -->
			<div class="row">
				<div class="col-lg-12">
					<div class="">
<?php
$sqlpackage = "SELECT * FROM `package` where package_type='Driving Class' AND branch_id='$_GET[branch_id]' AND package_id='$_GET[package_id]'";
$qsqlpackage = mysqli_query($con,$sqlpackage);
$rspackage = mysqli_fetch_array($qsqlpackage);
?>
<div class="item">
	<div class="serviceBox">
		<div class="service-icon">
		<?php
		if($rspackage['vehicle_type'] == "Two Wheeler")
		{
		?>
		<i class="fa fa-motorcycle" aria-hidden="true"></i>
		<?php
		}
		if($rspackage['vehicle_type']== "Four Wheeler")
		{
		?>
		<i class="fa fa-car" aria-hidden="true"></i>
		<?php
		}
		if($rspackage['vehicle_type']== "Both")
		{
		?>
		<i class="fa fa-motorcycle" aria-hidden="true"></i><i class="fa fa-car" aria-hidden="true"></i>
		<?php
		}
		?>
		</div>
		<h3 class="title"><?php echo $rspackage['package_title']; ?></h3>
		<p class="description">			
			<b>Vehile Type:</b> <?php echo $rspackage['vehicle_type']; ?> | <b>Total KM:</b> <?php echo $rspackage['total_km']; ?>km
			| <b>No. of Days:</b> <?php echo $rspackage['no_of_days']; ?><br>
			<?php echo $rspackage['note']; ?>
			<hr>
			<b>Cost - ₹<?php echo $rspackage['package_cost']; ?></b>
			
		</p>
	</div>
</div>
					</div>
				</div>
			</div>	

<form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform()">
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
	<div class="col-md-4" style="padding-top: 7px;"	>Start Date</div>
	<div class="col-md-8">
	<input type="date" name="start_date" id="start_date" class="form-control" value="<?php $date = date("Y-m-d"); echo $start_date = date('Y-m-d', strtotime($date . ' +1 day'));
	?>" min="<?php $date = date("Y-m-d"); echo $start_date = date('Y-m-d', strtotime($date . ' +1 day')); ?>" onchange="changeenddate(this.value,<?php echo $rspackage['no_of_days']; ?>)" >
	<span id="errstart_date" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>End Date</div>
	<div class="col-md-8" id="divenddt"><input type="date" name="end_date" id="end_date" class="form-control" value="<?php $date = date("Y-m-d"); echo date('Y-m-d', strtotime($date . " +$rspackage[no_of_days] day"));?>" readonly ><span id="errend_date" class="errorclass" ></span></div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Select Employee</div>
	<div class="col-md-8">
<?php
if($rspackage['vehicle_type'] == "Two Wheeler")
{
?>
<select name="employee_id" id="employee_id" class="form-control" onchange="loadtimeslots()" >
	<option value=''>Select Employee</option>
	<?php
	$sql = "SELECT employee.*,branch.branch_name from employee LEFT JOIN branch ON employee.branch_id=branch.branch_id  LEFT JOIN vehicle ON employee.employee_id=vehicle.employee_id WHERE employee.branch_id='$_GET[branch_id]' AND employee.status='Active' AND employee.gender='$rscustomer[gender]'  AND vehicle.vehicle_type='$rspackage[vehicle_type]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<option value='$rs[employee_id]'>$rs[employee_name] ($rs[gender] Trainer)</option>";
	}
	?>
</select>
<span id="erremployee_id" class="errorclass" ></span>
<?php
}
else
{
?>
<select name="employee_id" id="employee_id" class="form-control" onchange="loadtimeslots()" >
	<option value=''>Select Employee</option>
	<?php
		echo $sql = "SELECT employee.*,branch.branch_name from employee LEFT JOIN branch ON employee.branch_id=branch.branch_id  LEFT JOIN vehicle ON employee.employee_id=vehicle.employee_id WHERE employee.branch_id='$_GET[branch_id]' AND employee.status='Active' AND vehicle.vehicle_type='$rspackage[vehicle_type]' ";
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
			echo "<option value='$rs[employee_id]'>$rs[employee_name] ($rs[gender] Trainer)</option>";
		}
	?>
</select>
<span id="erremployee_id" class="errorclass" ></span>
<?php
}
?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Time slot</div>
	<div class="col-md-8" id="divtimeslot"><?php include("ajaxtimeslot.php"); ?></div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Any Note?</div>
	<div class="col-md-8">
	<textarea name="note" id="note" class="form-control"><?php echo $rsedit['note']; ?></textarea>
	<span id="errnote" class="errorclass" ></span>
	</div>
</div>
		</p>
		<hr>

<center><input type="submit" class="btn btn-warning" name="submit"  value="Apply for Driving Class" ></center>
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
	
	if(document.getElementById("start_date").value=="")
	{
		document.getElementById("errstart_date").innerHTML="Kindly select start_date..";
		i=1;
	}
	if(document.getElementById("end_date").value=="")
	{
		document.getElementById("errend_date").innerHTML="End Date should not be empty..";
		i=1;
	}
      
	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML="Kindly select employee..";
		i=1;
	}
	if(document.getElementById("timeslot_id").value=="")
	{
		document.getElementById("errdivtimeslot").innerHTML="Kindly select Timeslot..";
		i=1;
	}
	if(document.getElementById("note").value=="")
	{
		document.getElementById("errnote").innerHTML="Note should not be empty..";
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
function loadtimeslots() 
{
	employee_id = document.getElementById("employee_id").value;
	start_date = document.getElementById("start_date").value;
	end_date = document.getElementById("end_date").value;
	
	//alert(document.getElementById("start_date").value);
	//alert(document.getElementById("end_date").value);
		if(employee_id == "") 
		{
			document.getElementById("divtimeslot").innerHTML = "<select name='timeslot_id' id='timeslot_id' class='form-control' ><option value=''>Select Time slot</option></select><span id='errdivtimeslot' class='errorclass' ></span>";
			return;
		} 
		else
		{
			if(window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("divtimeslot").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET","ajaxtimeslot.php?empid="+employee_id+"&start_date="+start_date+"&end_date="+end_date,true);
			xmlhttp.send();
		}
}
function changeenddate(dt,no_of_days)
{
	if(window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divenddt").innerHTML = this.responseText;
			loadtimeslots();
		}
	};
	xmlhttp.open("GET","ajaxchangedate.php?dt="+dt+"&no_of_days="+no_of_days,true);
	xmlhttp.send();
}
</script>