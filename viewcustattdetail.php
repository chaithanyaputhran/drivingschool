<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM customer_attendance where customer_attendance_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Attendance Entry deled successfully..');</script>";
		echo "<script>window.location='viewcustattdetail.php?class_id=$_GET[class_id]';</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}
$sql = "SELECT driving_class.*,customer.customer_name,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time, time_slots.end_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active' AND class_id='$_GET[class_id]' ";
//echo $sql;
$qsql = mysqli_query($con,$sql);
echo mysqli_error($con);
$rs = mysqli_fetch_array($qsql);
?>

	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="blog-inner">
						<div class="item-meta">
							<a href="#"><i class="fa fa-eye"></i> <b>View Customer Attendance Report</b> <i class="fa fa-eye"></i></a>
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
						
<TABLE class="table table-striped table-bordered">
	<thead>
		<tr>
			<th style='width: 100px;'>Class No.</th>
			<th style='width: 150px;'>Attendance Date</th>
			<th style='width: 150px;'>Total KM</th>
			<th style='text-align: left;'>Note</th>
			<th style='width: 155px;'>Attendance Status</th>
<?php
if(isset($_SESSION['employee_id']))
{
?>			
			<th style='width: 150px;'>Action</th>
<?php
}
?>		
		</tr>
	</thead>
	<tbody>
	<?php
$sql = "SELECT customer_attendance.*, customer.customer_name, customer.cust_email, customer.cust_mob, driving_class.vehicle_type, driving_class.start_date FROM `customer_attendance` LEFT JOIN customer ON customer.customer_id=customer_attendance.customer_id LEFT JOIN driving_class ON driving_class.class_id=customer_attendance.class_id WHERE driving_class.class_id='$_GET[class_id]' ";
if(isset($_SESSION['customer_id']))
{
 $sql = $sql . " and  customer_attendance.customer_id='$_SESSION[customer_id]'";
}
else
{
 $sql = $sql . " and  customer_attendance.class_id='$_GET[class_id]'";
}
$sql = $sql . " ORDER BY customer_attendance.scheduled_date";
	$qsql = mysqli_query($con,$sql);
	$icount=1;
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
			<td>$icount</td>
			<td>" . date("d-M-Y",strtotime($rs['scheduled_date'])) . " </td>
			<td>$rs[total_km] KM</td>
			<td style='text-align: left;'>$rs[note]</td>
			<td>$rs[status]</td>";

if(isset($_SESSION['employee_id']))
{			
		echo "<td>
			<a href='viewcustattdetail.php?delid=$rs[0]&class_id=$_GET[class_id]' class='btn btn-danger' onclick='return confirm2delete()'>Delete</a>
			</td>";
}			
		echo "</tr>";
		$icount = $icount +1 ;
	}
	?>
	</tbody>
</TABLE>						
						
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
function confirm2delete()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return true;	
	}
	else
	{
		return false;
	}
}
</script>