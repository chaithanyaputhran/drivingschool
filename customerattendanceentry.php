<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
$sql = "SELECT driving_class.*,customer.customer_name,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time, time_slots.end_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active' AND class_id='$_GET[class_id]' ";
$qsql = mysqli_query($con,$sql);
echo mysqli_error($con);
$rs = mysqli_fetch_array($qsql);
if(isset($_POST['submit']))
{
	$sql = "INSERT INTO customer_attendance(customer_id,employee_id,timeslot_id,scheduled_date,note,status,total_km,class_id) values('$rs[customer_id]','$rs[employee_id]','$rs[timeslot_id]','$_POST[schedule_date]','$_POST[note]','$_POST[status]','$_POST[totalkm]','$rs[class_id]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
//Customer Attendace Record starts here
$sqldriving_class = "SELECT driving_class.*,customer.customer_name,customer.cust_email,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time, time_slots.end_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active' AND class_id='$rs[class_id]' ";
$qsqldriving_class = mysqli_query($con,$sqldriving_class);
echo mysqli_error($con);
$rsdriving_class = mysqli_fetch_array($qsqldriving_class);	
//##############
$sqlpackage = "SELECT * FROM package where package_id='$rsdriving_class[package_id]'";
$qsqlpackage = mysqli_query($con,$sqlpackage);
$rspackage = mysqli_fetch_array($qsqlpackage);
//#####
$sqltime_schedule = "SELECT ifnull(sum(total_km),0) as totkm FROM customer_attendance where customer_id='$rsdriving_class[customer_id]' AND class_id='$rsdriving_class[class_id]'";
$qsqltime_schedule = mysqli_query($con,$sqltime_schedule);
echo mysqli_error($con);
$rstime_schedule = mysqli_fetch_array($qsqltime_schedule);
//######		
$balkm =$rspackage['total_km'] -  $rstime_schedule['totkm'];
//Customer Attendace Detail ends here
	//PHP Mailer Starts here
	$subject = "Attendance Report - 24X7 Driving School..";
	$message = "Hello $_POST[customer_name],<br>This mail has Attendance report of Driving..<br> Current updated -  " . date("d-M-Y h:i A") . " attendance report is here...
	<br><br>";
	$message = $message . "<TABLE  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
	<thead>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Customer</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Branch</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Trainer</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Vehicle Type</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Start Date & Timings</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Total KM</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>My Spendings</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Available</th>
		</tr>
	</thead>
	<tbody style='border: 1px solid black; border-collapse: collapse;'><tr style='border: 1px solid black; border-collapse: collapse;'>
			<td style='border: 1px solid black; border-collapse: collapse;'>" . ucfirst($rsdriving_class['customer_name']) . "</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rsdriving_class[branch_name]</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rsdriving_class[employee_name]</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rsdriving_class[vehicle_type]</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>  " . date("d-M-Y",strtotime($rsdriving_class['start_date'])) . "<br>" . 
			date("h:i A",strtotime($rsdriving_class['start_time'])) . " - " . date("h:i A",strtotime($rsdriving_class['end_time'])) ."</td>
			<td style='border: 1px solid black; border-collapse: collapse;'> $rspackage[total_km] KM</td>
			<td style='border: 1px solid black; border-collapse: collapse;'> $rstime_schedule[0] KM</td>
			<td style='border: 1px solid black; border-collapse: collapse;'> $balkm KM</td></tr></tbody></TABLE><hr>";
	$message = $message . "<TABLE  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
	<thead>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Class No.</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Attendance Date</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Total KM</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Note</th>
			<th style='border: 1px solid black; border-collapse: collapse;'>Attendance Status</th>	
		</tr>
	</thead>
	<tbody style='border: 1px solid black; border-collapse: collapse;'>";
$sqlattrec = "SELECT customer_attendance.*, customer.customer_name, customer.cust_email, customer.cust_mob, driving_class.vehicle_type, driving_class.start_date FROM `customer_attendance` LEFT JOIN customer ON customer.customer_id=customer_attendance.customer_id LEFT JOIN driving_class ON driving_class.class_id=customer_attendance.class_id WHERE driving_class.class_id='$rsdriving_class[class_id]' and  customer_attendance.class_id='$rsdriving_class[class_id]'  ORDER BY customer_attendance.scheduled_date";
	$qsqlattrec = mysqli_query($con,$sqlattrec);
	$icount=1;
	while($rsattrec = mysqli_fetch_array($qsqlattrec))
	{
		$message = $message .  "<tr style='border: 1px solid black; border-collapse: collapse;'>
			<td style='border: 1px solid black; border-collapse: collapse;'>$icount</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>" . date("d-M-Y",strtotime($rsattrec['scheduled_date'])) . " </td>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rsattrec[total_km] KM</td>
			<td  style='border: 1px solid black; border-collapse: collapse;'>$rsattrec[note]</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rsattrec[status]</td>";	
		$message = $message .  "</tr>";
		$icount = $icount +1 ;
	}
	$message = $message . "</tbody></TABLE>";
	include("phpmailer.php");
	sendmail($rsdriving_class['cust_email'], $rsdriving_class['customer_name'] , $subject, $message,'');
	//PHP Mailer Ends here
		echo "<script>alert('Customer Attendance Entry done successfully...');</script>";
		echo "<script>window.location='viewcustattdetail.php?class_id=$rs[class_id]';</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}
?>
	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="blog-inner">
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>CUSTOMER ATTENDANCE ENTRY</b> <i class="fa fa-eye"></i></a>
</div>
						<p>
						
<TABLE class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer</th>
			<th>Branch</th>
			<th>Trainer</th>
			<th>Vehicle Type</th>
			<th>Start Date & Timings</th>
			<th>Total KM</th>
			<th>My Spendings</th>
			<th>Available</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$sqlpackage = "SELECT * FROM package where package_id='$rs[package_id]'";
		$qsqlpackage = mysqli_query($con,$sqlpackage);
		$rspackage = mysqli_fetch_array($qsqlpackage);
		//#####
		$sqltime_schedule = "SELECT ifnull(sum(total_km),0) as totkm FROM customer_attendance where customer_id='$rs[customer_id]' AND class_id='$rs[class_id]'";
		$qsqltime_schedule = mysqli_query($con,$sqltime_schedule);
		echo mysqli_error($con);
		$rstime_schedule = mysqli_fetch_array($qsqltime_schedule);
		//######		
		$balkm =$rspackage['total_km'] -  $rstime_schedule['totkm'];
		echo "<tr>
			<td>" . ucfirst($rs['customer_name']) . "</td>
			<td>$rs[branch_name]</td>
			<td>$rs[employee_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>  " . date("d-M-Y",strtotime($rs['start_date'])) . "<br>" . 
			date("h:i A",strtotime($rs['start_time'])) . " - " . date("h:i A",strtotime($rs['end_time'])) ."</td>
			<td> $rspackage[total_km] KM</td>
			<td> $rstime_schedule[0] KM</td>
			<td>";
			echo $balkm;
			echo " KM</td></tr>";
	?>

	</tbody>
</TABLE>						
						
<hr>
<form method="post" action="" enctype="multipart/form-data"onsubmit="return validateform()"> 
<input type="hidden" name="balkm" id="balkm" value="<?php echo $balkm; ?>" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Enter Attendance Detail</h3>
		<p class="description">


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Attendace Date</div>
	<div class="col-md-8">
	<input type="date" name="schedule_date" id="schedule_date" class="form-control" value="<?php echo date("Y-m-d"); ?>"><span id="errschedule_date" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Total KM trained</div>
	<div class="col-md-8">
	<input type="text" name="totalkm" id="totalkm" class="form-control" ><span id="errtotalkm" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Any Note</div>
	<div class="col-md-8">
	<textarea name="note" id="note" class="form-control"><?php echo $rsedit['note']; ?></textarea><span id="errnote" class="errorclass" ></span>
	</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Status</div>
	<div class="col-md-8">
		<select name="status" id="status" class="form-control" >
			<option value="">Attendace Status</option>
			<?php
			$arr = array("Present","Absent");
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
		<input type="submit" class="btn btn-warning" name="submit"  value="Submit Attendace Entry" >
	</div>
</div>

				</div>
				<div class="col-lg-2"></div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
</form>
						</p> 
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<!-- End Blog -->
	
<?php
include("footer.php");
?>
<script>
//balkm totalkm schedule_date note status
function validateform()
{
	var numericExp = /^[0-9]+$/;
	var deciexp = /^\d+(\.\d{1,2})?$/i;
	var alphaExp = /^[a-zA-Z]+$/;
	var alphaSpaceExp = /^[a-zA-Z\s]+$/;
	var alphaNumericExp = /^[0-9a-zA-Z]+$/;
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("schedule_date").value == "")
	{
		document.getElementById("errschedule_date").innerHTML="Attendance date should not be empty..";
		i=1;
	}
	if(parseFloat(document.getElementById("totalkm").value) >parseFloat(document.getElementById("balkm").value))
	{
		document.getElementById("errtotalkm").innerHTML="Total KM exeeds.. Only " + document.getElementById("balkm").value + " KM balance available in this package...";
		i=1;
	}
	if(!document.getElementById("totalkm").value.match(deciexp))
	{
		document.getElementById("errtotalkm").innerHTML="Total KM is not valid..";
		i=1;
	}
	if(document.getElementById("totalkm").value == "")
	{
		document.getElementById("errtotalkm").innerHTML="Total KM should not be empty..";
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