<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM driving_license where dl_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Diving License record deleted successfully..');</script>";
		echo "<script>window.location='viewdrivinglicense.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW DRIVING LICENSE  RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Photo Proof</th>
			<th>Document</th>
			<th>Customer</th>
			<th>Branch</th>
			<th>Applying on</th>
			<th>Package & <br>Vehicle Type</th>
			<th>Package Cost</th>
			<th>License Status</th>
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
			$imgname2="images/default-image.jpg";
		}
		
		if($rs['license_file'] == "")
		{
			$imgname3="images/default-image.jpg";
		}
		else if(file_exists("imgdrvlic/".$rs['license_file']))
		{
			$imgname3= "imgdrvlic/".$rs['license_file'];
		}
		else
		{
			$imgname3="images/default-image.jpg";
		}
		echo "<tr>
		<td><img src='$imgname' style='width: 85px; height: 90px;' ></td>
		<td>
		<a href='$imgname1' class='btn btn-primary' download style='width: 120px;' >ID Proof</a><br>
		<a href='$imgname2' class='btn btn-warning' download  style='width: 120px;'>Address Proof</a>
		</td>
			<td>$rs[customer_name]</td>
			<td>$rs[branch_name]</td>
			<td>" . date("d-M-Y",strtotime($rs['reg_date'])) . "</td>
			<td>$rs[package_title] <br><b>(" . $rs['vehicle_type'] . ")</b></td>
			<td>₹$rs[package_cost]</td>
			<td>";
if(isset($_SESSION['customer_id']))
{
			if($rs['license_type'] == "LLR")
			{
				echo "<a href='$imgname3' class='btn btn-secondary' style='width: 120px;' download >Download<br>LLR</a>";
			}
			else if($rs['license_type'] == "DL")
			{
				echo "<a href='$imgname3' class='btn btn-secondary' style='width: 120px;' download >Download<br>DL</a>";
			}
			else
			{
				echo "<a href='#' class='btn btn-secondary' style='width: 120px;' >Under<br>Process</a>";
			}
}
else
{
			if($rs['license_type'] == "LLR")
			{
				echo "<a href='processdlapplication.php?dl_id=$rs[0]' class='btn btn-secondary' style='width: 120px;' >Upload DL</a>";
				echo "<a href='$imgname3' style='color: red;' download >Download LLR</a>";
			}
			else if($rs['license_type'] == "DL")
			{
				echo "<a href='$imgname3' class='btn btn-secondary' style='width: 120px;' download >Download<br>DL</a>";
			}
			else
			{
				echo "<a href='processdlapplication.php?dl_id=$rs[0]' class='btn btn-secondary' style='width: 120px;' >Upload LLR</a><br>";
			}
}
		echo "</td> 
			<td>
			
				<a href='drivinglicenseviewmore.php?dl_id=$rs[0]' class='btn btn-info' style='width: 100px;' target='_blank'>View</a> 
			<br> 
				<a href='drivinglicensereceipt.php?dl_id=$rs[0]' target='_blank' class='btn btn-danger'  style='width: 100px;'> Receipt</a>				
			
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