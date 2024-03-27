<?php
include("header.php");
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
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer</th>
			<th>Branch</th>
			<th>Trainer</th>
			<th>Vehicle Type</th>
			<th>Start Date & Timings</th>
			<th>Total KM Package</th>
			<th>Total KM trained</th>
			<th>Available KM</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_class.*,customer.customer_name,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time, time_slots.end_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active'";
	if($_SESSION['employee_type'] == "Employee")
	{
		$sql = $sql . " and driving_class.employee_id='$_SESSION[employee_id]' ";
	}
	if(isset($_SESSION['customer_id']))
	{
	$sql = $sql . " and driving_class.customer_id='$_SESSION[customer_id]'";
	}
	//echo $sql;
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
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
			echo " KM</td><td>";
if(isset($_SESSION['employee_id']))
{
	echo "<a href='customerattendanceentry.php?class_id=$rs[0]' class='btn btn-info' style='width: 150px;' target='_blank'>Attendance Entry</a>";			
	echo "<hr>";
}
			echo "<a href='viewcustattdetail.php?class_id=$rs[0]' class='btn btn-danger'  style='width: 150px;'>View Report</a>";	
			echo "</td></tr>";
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