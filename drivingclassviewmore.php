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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING CLASS DETAIL</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer</th>
			<th>Branch</th>
			<th>Trainer</th>
			<th>Vehicle Type</th>
			<th>Start Date</th>
			<th>Timings</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_class.*,customer.customer_name,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time, time_slots.end_time  FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active' and driving_class.class_id='$_GET[class_id]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		$customer_id = $rs['customer_id'];
		$sqlpayment = "SELECT SUM(paid_amt) as paid_amt FROM payment WHERE class_id='$rs[class_id]'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$balamt = $rs['package_cost'] - $rspayment['paid_amt'];
		echo "<tr>
			<td>$rs[customer_name]</td>
			<td>$rs[branch_name]</td>
			<td>$rs[employee_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>  " . date("d-M-Y",strtotime($rs['start_date'])) . "</td>
			<td>   " . date("h:i A",strtotime($rs['start_time'])) . " - ". date("h:i A",strtotime($rs['end_time'])) ."</td>
		</tr>";
	}
	?>
	</tbody>
</TABLE>					
						</p> 
						<p>
						
<TABLE class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Package detail</th>
			<th>Total Amount</th>
			<th>Paid Amount </th>
			<th>Balance Amount </th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_class.*,customer.customer_name,branch.branch_name,employee.employee_name,package.vehicle_type,package.package_title, time_slots.start_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.status='Active' ";	
	$sql = $sql . " and driving_class.class_id='$_GET[class_id]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlpayment = "SELECT SUM(paid_amt) as paid_amt FROM payment WHERE class_id='$rs[class_id]'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$balamt = $rs['package_cost'] - $rspayment['paid_amt'];
		echo "<tr>
			<td>$rs[package_title]</td>
			<td>₹$rs[package_cost]</td>
			<td>₹$rspayment[paid_amt]</td>
			<td>₹" .   $balamt . "
			</td>
		</tr>";
	}
	?>
	</tbody>
</TABLE>						
						</p> 
						
<hr>
						<p>
<b style='font-size: 25px;color: grey;'>VIEW PAYMENTS</b>				
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Payment Date</th>
			<th>Customer</th>
		<?php
		if($_GET['bookingfor'] == "Driving License")
		{
		?>
			<th>Driving License</th>
		<?php
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
		?>
			<th>Driving Class detail</th>
		<?php
		}
		?>
			<th>
<?php
		if($_GET['bookingfor'] == "Driving License")
		{
			echo "Agent";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
			echo "Trainer";
		}
?>			
			</th>
			<th>Paid Amount</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT payment.*,driving_class.*,employee.*,branch.branch_name FROM payment LEFT JOIN driving_class ON payment.class_id=driving_class.class_id LEFT JOIN  driving_license ON driving_license.dl_id=payment.dl_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id  LEFT JOIN branch ON branch.branch_id=driving_class.branch_id where payment.status='Active' ";
	if(isset($_GET['class_id']))
	{
		$sql  = $sql . " AND payment.class_id='$_GET[class_id]'";
	}
	if(isset($_SESSION['customer_id']))
	{
		if($_GET['bookingfor'] == "Driving License")
		{
		$sql = $sql . " and driving_license.customer_id='$_SESSION[customer_id]'";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
		$sql = $sql . " and driving_class.customer_id='$_SESSION[customer_id]'";
		}
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
	$sqlcustomer ="SELECT * FROM customer where customer_id='$rs[customer_id]'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	$rscustomer = mysqli_fetch_array($qsqlcustomer);
//driving class package starts here
$sqlpackage = "SELECT package.*,branch.* FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_id='$rs[package_id]'";
$qsqlpackage = mysqli_query($con,$sqlpackage);
$rspackage = mysqli_fetch_array($qsqlpackage);
//driving class package ends here
		echo "<tr>";
		echo "<td>$rs[0]</td>";
		echo "<td>" . date("d-M-Y",strtotime($rs['payment_date'])) . "</td>";
		echo "<td style='text-align: left;'>";
	echo $rscustomer['customer_name'] . "<br>";
	echo $rscustomer['customer_address'] . "<br>";
	echo "<b>Email </b>" . $rscustomer['cust_email'] . "<br>";
	echo "<b>Ph No.</b> " .$rscustomer['cust_mob'] . "<br>";		
		echo "</td>";
		if($_GET['bookingfor'] == "Driving License")
		{
			echo "<td>$rs[dl_id]</td>";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
			echo "<td style='text-align: left;'>";
			echo "<b>Vehicle type:</b> " . $rs['vehicle_type'] . "<br>";
			echo "<b>Vehicle type:</b> " . $rs['vehicle_type'] . "<br>";
			echo "<b>Total KM:</b> " . $rspackage['total_km'] ." kms";
			echo "</td>";
		}
			echo "<td style='text-align: left;'>
			<b>Name:</b> $rs[employee_name]<br>
			<b>Code:</b> $rs[login_id]<br>
			<b>Branch:</b> $rs[branch_name]
			</td>
			<td>₹$rs[paid_amt]</td>
			<td>
			<a  href='drivingclassreceipt.php?insid=$rs[0]' class='btn btn-info' target='_blank'>Print</a>
			
			</td>
		</tr>";
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