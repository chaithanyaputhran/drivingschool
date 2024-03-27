<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM driving_class where class_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Driving Class record deleted successfully..');</script>";
		echo "<script>window.location='viewdrivingclass.php';</script>";
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
	<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING CLASS RECORDS</b> <i class="fa fa-eye"></i></a>
</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer</th>
			<th>Branch</th>
			<th>Trainer</th>
			<th>Vehicle Type</th>
			<th>Package detail</th>
			<th>Timings</th>
			<th>Total Amount</th>
			<th>Paid Amount </th>
			<th>Balance Amount </th>
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
		$sqlpayment = "SELECT SUM(paid_amt) as paid_amt FROM payment WHERE class_id='$rs[class_id]'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$balamt = $rs['package_cost'] - $rspayment['paid_amt'];
		echo "<tr>
			<td>" . ucfirst($rs['customer_name']) . "</td>
			<td>$rs[branch_name]</td>
			<td>$rs[employee_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>$rs[package_title]</td>
			<td>  " . date("d-M-Y",strtotime($rs['start_date'])) . "<br>" . 
			date("h:i A",strtotime($rs['start_time'])) . " - " . date("h:i A",strtotime($rs['end_time'])) ."</td>
			<td>₹$rs[package_cost]</td>
			<td>₹$rspayment[paid_amt]</td>
			<td>₹" .   $balamt ;

			echo "<a href='drivingclasspayment.php?class_id=$rs[0]&bookingfor=Driving Class' class='btn btn-success'>Pay</a>";
	
			echo "</td><td>";
			echo "<a href='drivingclassviewmore.php?class_id=$rs[0]' class='btn btn-info' style='width: 150px;' target='_blank'>View More</a>";
			echo "<br>";
			echo "<a href='viewpayment.php?bookingfor=Driving%20Class&class_id=$rs[0]' target='_blank' class='btn btn-danger'  style='width: 150px;'>Payment  Receipt</a>";	
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