<?php
include("header.php");
?>
	<!-- Start About us -->
	<div id="about" class="about-box" style="background-color: brown; ">
		<div class="about-a1">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title-box">
							<h2 style="color: white;">Customer Account</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End About us -->


	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="blog-inner">
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING CLASS APPLICATIONS</b> <i class="fa fa-eye"></i></a>
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
	if(isset($_SESSION['customer_id']))
	{
	$sql = $sql . " and driving_class.customer_id='$_SESSION[customer_id]'";
	}
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlpayment = "SELECT SUM(paid_amt) as paid_amt FROM payment WHERE class_id='$rs[class_id]'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$balamt = $rs['package_cost'] - $rspayment['paid_amt'];
		echo "<tr>
			<td>$rs[customer_name]</td>
			<td>$rs[branch_name]</td>
			<td>$rs[employee_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>$rs[package_title]</td>
			<td>  " . date("d-M-Y",strtotime($rs['start_date'])) . "<br>" . 
			date("h:i A",strtotime($rs['start_time'])) . " - " . date("h:i A",strtotime($rs['end_time'])) ."</td>
			<td>₹$rs[package_cost]</td>
			<td>₹$rspayment[paid_amt]</td>
			<td>₹" .   $balamt ."
			<a href='drivingclasspayment.php?class_id=$rs[0]&bookingfor=Driving Class' class='btn btn-success'>Pay</a>
			</td>
			<td>
				<a href='drivingclassviewmore.php?class_id=$rs[0]' class='btn btn-info' style='width: 150px;' target='_blank'>View More</a> 
			<br> 
				<a href='viewpayment.php?bookingfor=Driving%20Class&class_id=$rs[0]' target='_blank' class='btn btn-danger'  style='width: 150px;'>Payment  Receipt</a>			
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
		<div class="container">

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="blog-inner">
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING  LICENSE APPLICATIONS</b> <i class="fa fa-eye"></i></a>
</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Photo Proof</th>
			<th>ID Proof</th>
			<th>Address Proof</th>
			<th>Customer</th>
			<th>Branch</th>
			<th>Applying on</th>
			<th>Package</th>
			<th>Vehicle Type</th>
			<th>Package Cost</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT driving_license.*,customer.customer_name,branch.branch_name,package.vehicle_type,package.package_title FROM driving_license LEFT JOIN customer ON customer.customer_id=driving_license.customer_id	 LEFT JOIN branch ON branch.branch_id=driving_license.branch_id LEFT JOIN package ON package.package_id=driving_license.package_id WHERE driving_license.status='Active' ";
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
			<td>$rs[customer_name]</td>
			<td>$rs[branch_name]</td>
			<td>" . date("d-M-Y",strtotime($rs['reg_date'])) . "</td>
			<td>$rs[package_title]</td>
			<td>$rs[vehicle_type]</td> 
			<td>₹$rs[package_cost]</td>
			<td>
			
				<a href='drivinglicenseviewmore.php?dl_id=$rs[0]' class='btn btn-info' style='width: 150px;' target='_blank'>View More</a> 
			<br> 
				<a href='viewpayment.php?bookingfor=Driving%20License&dl_id=$rs[0]' target='_blank' class='btn btn-danger'  style='width: 150px;'>Payment  Receipt</a>				
			
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
if(isset($_GET['branch_id']))
{
?>	
	<hr>
	
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="title-box">
						<h2>Register for Driving Class </h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="owl-carousel owl-theme">
					
						<div class="item">
							<div class="serviceBox">
								<div class="service-icon"><i class="fa fa-h-square" aria-hidden="true"></i></div>
								<h3 class="title">Lorem ipsum dolor</h3>
								<p class="description">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium consequuntur.
								</p>
								<a href="#" class="new-btn-d br-2">Read More</a>
							</div>
						</div>

					</div>
				</div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
	<hr>
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="title-box">
						<h2>Apply for Driving License </h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div class="owl-carousel owl-theme">
					
					
						<div class="item">
							<div class="serviceBox">
								<div class="service-icon"><i class="fa fa-h-square" aria-hidden="true"></i></div>
								<h3 class="title">Lorem ipsum dolor</h3>
								<p class="description">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium consequuntur.
								</p>
								<a href="#" class="new-btn-d br-2">Read More</a>
							</div>
						</div>
						
						
						
					</div>
				</div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
<?php
}
?>
<?php
include("footer.php");
?>