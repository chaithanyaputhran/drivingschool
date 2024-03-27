<?php
include("header.php");
if(isset($_POST['submit']))
{
	$sql = "SELECT driving_license.*,customer.customer_name,customer.cust_email,branch.branch_name,package.vehicle_type,package.package_title FROM driving_license LEFT JOIN customer ON customer.customer_id=driving_license.customer_id	 LEFT JOIN branch ON branch.branch_id=driving_license.branch_id LEFT JOIN package ON package.package_id=driving_license.package_id WHERE driving_license.status='Active' AND driving_license.dl_id='$_GET[dl_id]' ";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	$rs = mysqli_fetch_array($qsql);	
	$file = rand() . $_FILES['file']['name'];
	move_uploaded_file($_FILES['file']['tmp_name'],"imgdrvlic/".$file);
	$upd = "UPDATE driving_license SET license_type='$_POST[filetype]', license_file='$file' where dl_id='$_POST[dl_id]'";
	$qupd = mysqli_query($con,$upd);
	$msg = $_POST['filetype'] . " uploaded successfully...";
	echo "<script>alert('$msg');</script>";
	//PHP Mailer Starts here
	$subject = "Driving License Application process..";
	$message = "Dear ". $rs['customer_name'].",<br>Your " . $_POST['filetype'] ." application process completed successfully.. Login to download copy of " . $_POST['filetype'] ."... You can visit our office to collect " . $_POST['filetype'] ." License.<br><br>
	<center><a style='color:#ffffff; background-color: #00a5b5;  border-top: 10px solid #00a5b5; border-bottom: 10px solid #00a5b5; border-left: 20px solid #00a5b5; border-right: 20px solid #00a5b5; border-radius: 3px; text-decoration:none;' href='$url'>Click Here to Login</a></center>";
	include("phpmailer.php");
	sendmail($rs['cust_email'], $rs['customer_name'] , $subject, $message,'');
	//PHP Mailer Ends here	
	echo "<script>window.location='processdlapplication.php?dl_id=$_GET[dl_id]';</script>";
}
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
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>Documents</b> <i class="fa fa-eye"></i></a>
</div>	
<TABLE class="table table-striped table-bordered">
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
		$license_type = $rs['license_type'];
		$license_file = $rs['license_file'];
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
		<td><img src='$imgname' style='width: 85px; height: 90px;' >
		<br>
		<center><a href='$imgname' target='_blank' class='btn btn-info' >Download</a></center>
		</td>
		<td><img src='$imgname1' style='width: 85px; height: 90px;' >
		<br>
		<center><a href='$imgname1' target='_blank' class='btn btn-info' >Download</a></center>
		</td>
		<td><img src='$imgname2' style='width: 85px; height: 90px;' >
		<br>
		<center><a href='$imgname2' target='_blank' class='btn btn-info' >Download</a></center>
		</td>
		</tr>";
	}
	?>

	</tbody>
</TABLE>		

						</p> 
						
<hr>
						<p>
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>View Payments</b> <i class="fa fa-eye"></i></a>
</div>					
<TABLE class="table table-striped table-bordered">
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
						
						
						
												
<hr>
						<p>
<div class="item-meta">
	<a href="#"><i class="fa fa-eye"></i> <b>Process Application</b> <i class="fa fa-eye"></i></a>
</div>
<form method="post" action="" enctype="multipart/form-data">			
<TABLE class="table table-striped table-bordered">
	<thead>
	<?php
	//$license_type $license_file
	if($license_type == "")
	{
	?>
		<tr>
			<th>Upload LLR Copy</th>
			<th>
			<input type="hidden" name="dl_id" id="dl_id"  value="<?php echo $_GET['dl_id']; ?>">
			<input type="hidden" name="filetype" id="filetype"  value="LLR">
			<input type="file" name="file"  required>			
			</th>
			<th><input type="submit" name="submit" class="btn btn-warning" Value="Click here to Upload"></th>
		</tr>
	<?php
	}
	if($license_type == "LLR")
	{
	?>
		<tr>
			<th>LLR Copy</th>
			<th colspan="2" style="text-align: left;"><a href="imgdrvlic/<?php echo $license_file; ?>" class="btn btn-info" download >Download LLR</a></th>
		</tr>		
		<tr>
			<th>Upload DL Copy</th>
			<th>
			<input type="hidden" name="dl_id" id="dl_id"  value="<?php echo $_GET['dl_id']; ?>">
			<input type="hidden" name="filetype" id="filetype"  value="DL">
			<input type="file" name="file" id="file"  required>
			</th>
			<th><input type="submit" name="submit" class="btn btn-warning" Value="Click here to Upload"></th>
		</tr>
	<?php
	}
	if($license_type == "DL")
	{
	?>
		<tr>
			<th>DL Copy</th>
			<th colspan="2" style="text-align: left;"><a href="imgdrvlic/<?php echo $license_file; ?>" class="btn btn-info" download >Download DL</a></th>
		</tr>	
	<?php
	}	
	?>
	</thead>
</TABLE>			
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
	if(document.getElementById("qstn").value=="")
	{
		document.getElementById("errqstn").innerHTML="Quetion should not be empty..";
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
