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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING LICENSE  DETAIL</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer</th>
			<th>Branch</th>
			<th>Applying on</th>
			<th>Package</th>
			<th>Vehicle Type</th>
			<th>Package Cost</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_license.*,customer.customer_name,branch.branch_name,package.vehicle_type,package.package_title FROM driving_license LEFT JOIN customer ON customer.customer_id=driving_license.customer_id	 LEFT JOIN branch ON branch.branch_id=driving_license.branch_id LEFT JOIN package ON package.package_id=driving_license.package_id WHERE driving_license.status='Active' AND driving_license.dl_id='$_GET[dl_id]' ";
	if(isset($_SESSION['customer_id']))
	{
	$sql = $sql . " and driving_license.customer_id='$_SESSION[customer_id]'";
	}
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		
		if($rs['photo_proof'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['photo_proof']))
		{
			$imgname= "imgdrvlic/".$rs['photo_proof'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		
		if($rs['id_proof'] == "")
		{
			$imgname1="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['id_proof']))
		{
			$imgname1= "imgdrvlic/".$rs['id_proof'];
		}
		else
		{
			$imgname1="images/default-image.jpg";
		}
		
		
		if($rs['address_proof'] == "")
		{
			$imgname2="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['address_proof']))
		{
			$imgname2= "imgdrvlic/".$rs['address_proof'];
		}
		else
		{
			$imgname3="images/default-image.jpg";
		}
		
		echo "<tr>
			<td>$rs[customer_name]</td>
			<td>$rs[branch_name]</td>
			<td>" . date("d-M-Y",strtotime($rs['reg_date'])) . "</td>
			<td>$rs[package_title]</td>
			<td>$rs[vehicle_type]</td> 
			<td>₹$rs[package_cost]</td>
		</tr>";
	}
	?>

	</tbody>
</TABLE>						

<HR>
<b>ID PROOF</b><br>
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Photo Proof</th>
			<th>ID Proof</th>
			<th>Address Proof</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_license.*,customer.customer_name,branch.branch_name,package.vehicle_type,package.package_title FROM driving_license LEFT JOIN customer ON customer.customer_id=driving_license.customer_id	 LEFT JOIN branch ON branch.branch_id=driving_license.branch_id LEFT JOIN package ON package.package_id=driving_license.package_id WHERE driving_license.status='Active' AND driving_license.dl_id='$_GET[dl_id]' ";
	if(isset($_SESSION['customer_id']))
	{
	$sql = $sql . " and driving_license.customer_id='$_SESSION[customer_id]'";
	}
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		
		if($rs['photo_proof'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['photo_proof']))
		{
			$imgname= "imgdrvlic/".$rs['photo_proof'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		
		if($rs['id_proof'] == "")
		{
			$imgname1="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['id_proof']))
		{
			$imgname1= "imgdrvlic/".$rs['id_proof'];
		}
		else
		{
			$imgname1="images/default-image.jpg";
		}
		
		
		if($rs['address_proof'] == "")
		{
			$imgname2="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['address_proof']))
		{
			$imgname2= "imgdrvlic/".$rs['address_proof'];
		}
		else
		{
			$imgname3="images/default-image.jpg";
		}
		
		echo "<tr>
		<td><img src='$imgname' style='width: 85px; height: 90px;' ></td>
		<td><img src='$imgname1' style='width: 85px; height: 90px;' ></td>
		<td><img src='$imgname2' style='width: 85px; height: 90px;' ></td>
		</tr>";
	}
	?>

	</tbody>
</TABLE>		

						</p> 
						
<hr>
						<p>
<b>View Payments</b>						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Payment Date</th>
			<th>Customer</th>

			<th>Branch</th>

			<th>Paid Amount</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT payment.*,driving_license.*,branch.branch_name FROM payment LEFT JOIN driving_license ON payment.dl_id=driving_license.dl_id LEFT JOIN branch ON branch.branch_id=driving_license.branch_id where payment.status='Active'  ";
	if(isset($_GET['dl_id']))
	{
		$sql  = $sql . " AND payment.dl_id='$_GET[dl_id]'";
	}
	if(isset($_SESSION['customer_id']))
	{

		$sql = $sql . " and driving_license.customer_id='$_SESSION[customer_id]'";
	}
	//echo $sql;
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
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
			<b>Branch:</b> $rs[branch_name]
			</td>
			<td>₹$rs[paid_amt]</td>
			<td>
			<a  href='drivinglicensereceipt.php?insid=$rs[0]' class='btn btn-info' target='_blank'>Print</a>
			
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