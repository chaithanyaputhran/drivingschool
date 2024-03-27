<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM package where package_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Package record deleted successfully..');</script>";
		echo "<script>window.location='viewdrivingclasspackage.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW PACKAGE RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Branch</th>
			<th>Vehicle Type</th>
			<th>Package Title</th>
			<th>Package Cost</th>
			<th>Total KM</th>
			<th>No. of Days</th>
			<th>Status</th>
<?php
if($_SESSION['employee_type'] == "Admin")
{
?>	
			<th>Action</th>
<?php
}
?>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT package.*,branch.branch_name FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_type='Driving Class'";
	if($_SESSION['employee_type'] == "Employee")
	{
		$sql = $sql . " AND package.branch_id='$rsemployee[branch_id]'";
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
			<td>$rs[branch_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>$rs[package_title]</td>
			<td>₹$rs[package_cost]</td>
			<td>$rs[total_km] kms</td>
			<td>$rs[no_of_days]</td>
			<td>$rs[status]</td>";
	if($_SESSION['employee_type'] == "Admin")
	{
			echo "<td>
			<a  href='drivingclasspackage.php?editid=$rs[0]' class='btn btn-info'>Edit</a>
			<a href='viewdrivingclasspackage.php?delid=$rs[0]' class='btn btn-danger'
			onclick='return confirm2delete()'>Delete</a>
			</td>";
	}
		echo "</tr>";
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