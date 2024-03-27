<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM payment where payment_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Payment record deleted successfully..');</script>";
		echo "<script>window.location='viewpayment.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW PAYMENT REPORT</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
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
<?php
		if($_GET['bookingfor'] == "Driving Class")
		{
			echo "<th>Trainer</th>";
		}
		if($_GET['bookingfor'] == "Driving License")
		{
			echo "<th>Branch</th>";
		}
?>			
			<th>Paid Amount</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT payment.*";
	if(isset($_SESSION['customer_id']))
	{
		if($_GET['bookingfor'] == "Driving License")
		{
		$sql = $sql . ",driving_license.*,driving_license.customer_id as cstid";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
		$sql = $sql . ",driving_class.*,driving_class.customer_id as cstid";
		}
	}
	if(isset($_GET['class_id']))
	{	
	$sql = $sql . ",driving_class.*,driving_class.customer_id as cstid";
	}
	if(isset($_GET['dl_id']))
	{
	$sql = $sql . ",driving_license.*,driving_license.customer_id as cstid";
	}
	if(isset($_GET['class_id']))
	{
	$sql = $sql . ",employee.*";
	}
	if(isset($_GET['class_id']))
	{
	$sql = $sql . ",branch.branch_name "; 
	}
	$sql = $sql .  " FROM payment ";
	if(isset($_GET['class_id']))
	{	
	$sql = $sql . " LEFT JOIN driving_class ON payment.class_id=driving_class.class_id"; 
	}
	if($_GET['bookingfor'] == "Driving Class")
	{
		$sql = $sql . " LEFT JOIN driving_class ON payment.class_id=driving_class.class_id"; 
	}
	if($_GET['bookingfor'] == "Driving License")
	{
	$sql = $sql . " LEFT JOIN  driving_license ON driving_license.dl_id=payment.dl_id "; 
	}
	if(isset($_GET['dl_id']))
	{
	$sql = $sql . " LEFT JOIN  driving_license ON driving_license.dl_id=payment.dl_id "; 
	}
	if(isset($_GET['class_id']))
	{
	$sql = $sql . " LEFT JOIN employee ON employee.employee_id=driving_class.employee_id  ";
	}
	if(isset($_GET['class_id']))
	{
	$sql = $sql . " LEFT JOIN branch ON branch.branch_id=driving_class.branch_id ";
	}
	if(isset($_GET['dl_id']))
	{
	$sql = $sql . " LEFT JOIN branch ON branch.branch_id=driving_license.branch_id ";
	}
	$sql = $sql . " where payment.status='Active' ";
	if(isset($_GET['class_id']))
	{
		$sql  = $sql . " AND payment.class_id='$_GET[class_id]'";
	}
	if(isset($_GET['dl_id']))
	{
		$sql  = $sql . " AND payment.dl_id='$_GET[dl_id]'";
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
	//echo $sql;
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
	$sqlcustomer ="SELECT * FROM customer where customer_id='$rs[cstid]'";
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
			echo "<td style='text-align: left;'>";
			echo "<b>Package type:</b> " . $rspackage['package_title'] ."<br>";
			echo "<b>License registration:</b> " . $rs['reg_date'] . "<br>";
			echo "<b>Vehicle type:</b> " . $rs['vehicle_type'] . "<br>";
			echo "</td>";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
			echo "<td style='text-align: left;'>";
			echo "<b>Vehicle type:</b> " . $rs['vehicle_type'] . "<br>";
			echo "<b>Vehicle type:</b> " . $rs['vehicle_type'] . "<br>";
			echo "<b>Total KM:</b> " . $rspackage['total_km'] ." kms";
			echo "</td>";
		}
if($_GET['bookingfor'] == "Driving Class")
	{
			//Trainer Starts Here
			$sqlemployee ="SELECT employee.*,branch.* FROM employee LEFT JOIN branch ON employee.branch_id=branch.branch_id where employee_id='$rs[employee_id]'";
			$qsqlemployee = mysqli_query($con,$sqlemployee);
			$rsemployee = mysqli_fetch_array($qsqlemployee);
			//Trainer Ends Here
			echo "<td style='text-align: left;'>
			<b>Name:</b> $rsemployee[employee_name]<br>
			<b>Code:</b> $rsemployee[login_id]<br>
			<b>Branch:</b> $rsemployee[branch_name]
			</td>";
	}
	if($_GET['bookingfor'] == "Driving License")
	{
			$sqlbranch ="SELECT * FROM branch where branch_id='$rs[branch_id]'";
			$qsqlbranch = mysqli_query($con,$sqlbranch);
			$rsbranch = mysqli_fetch_array($qsqlbranch);
			echo "<td style='text-align: left;'>
			 $rsbranch[branch_name]
			</td>";
	}
			echo "<td>₹$rs[paid_amt]</td>
			<td>";
	if($_GET['bookingfor'] == "Driving Class")
	{
		echo "<a  href='drivingclassreceipt.php?insid=$rs[0]' class='btn btn-info' target='_blank'>Print</a>";
	}
	if($_GET['bookingfor'] == "Driving License")
	{
		echo "<a  href='drivinglicensereceipt.php?insid=$rs[0]' class='btn btn-info' target='_blank'>Print</a>";
	}
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