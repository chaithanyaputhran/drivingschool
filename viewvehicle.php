<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM vehicle where vehicle_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Vehicle record deleted successfully..');</script>";
		echo "<script>window.location='viewvehicle.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW VEHICLE RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Vehicle Image</th>
			<th>Employee</th>
			<th>Branch</th>
			<th>Vehicle Type</th>
			<th>Vehicle Number</th>
			<th>Vehicle name</th>
			<th>Note</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT vehicle.*,employee.employee_name,branch.branch_name FROM vehicle LEFT JOIN employee on vehicle.employee_id=employee.employee_id LEFT JOIN branch ON branch.branch_id=vehicle.branch_id";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		if($rs['vehicle_img'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgvehicle/".$rs['vehicle_img']))
		{
			$imgname= "imgvehicle/".$rs['vehicle_img'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		echo "<tr>
		
		<td><img src='$imgname' style='width: 85px; height: 90px;' ></td>
		<td>$rs[employee_name]</td>
			<td>$rs[branch_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>$rs[vehicle_no]</td>
			<td>$rs[vehicle_name]</td>
			<td>$rs[note]</td>
			<td>$rs[status]</td>
			<td><a  href='vehicle.php?editid=$rs[0]' class='btn btn-info'>Edit</a>
			 |
			
			<a href='viewvehicle.php?delid=$rs[0]' class='btn btn-danger'
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