<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM attendance where attedance_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Attendance record deleted successfully..');</script>";
		echo "<script>window.location='viewattendance.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW ATTENDANCE RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Employee</th>
			<th>Customer</th>
			<th>Attendance date</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM attendance";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
		
			<td>$rs[employee_id]</td>
			<td>$rs[cust_id]</td>
			<td>$rs[attedance_date]</td>
			<td>$rs[status]</td>
			<td> <a  href='attendance.php?editid=$rs[0]' class='btn btn-info'>Edit</a>
			|  
			<a href='viewattendance.php?delid=$rs[0]' class='btn btn-danger'
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