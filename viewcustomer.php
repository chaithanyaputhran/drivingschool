<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM customer where customer_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Customer record deleted successfully..');</script>";
		echo "<script>window.location='viewcustomer.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW CUSTOMER  RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Profile Image</th>
			<th>Customer Name</th>
			<th>Customer Address</th>
			<th>Customer Email</th>
			<th>Customer Mobile</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM customer";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		
		if($rs['profile_img'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgcustprofile/".$rs['profile_img']))
		{
			$imgname= "imgcustprofile/".$rs['profile_img'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		echo "<tr>
		<td><img src='$imgname' style='width: 85px; height: 90px;' ></td>
			<td>$rs[customer_name]</td>
			<td>$rs[customer_address]</td>
			<td>$rs[cust_email]</td>
			<td>$rs[cust_mob]</td>
			<td>$rs[status]</td>
			<td>
			<a  href='customer.php?editid=$rs[0]' class='btn btn-info'>Edit</a>			|  
			<a href='viewcustomer.php?delid=$rs[0]' class='btn btn-danger'
			onclick='return confirm2delete()'>Delete</a>
			
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