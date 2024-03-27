<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM time_slots where timeslot_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('TimeSlots record deleted successfully..');</script>";
		echo "<script>window.location='viewtimeslot.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW TIMESLOTS RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Employee Name</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT time_slots.*,employee.employee_name, branch.branch_name FROM time_slots LEFT JOIN employee ON time_slots.employee_id=employee.employee_id LEFT JOIN branch ON employee.branch_id=branch.branch_id WHERE time_slots.status!='' ";
	if($_SESSION['employee_type'] == "Employee")
	{	
	$sql = $sql . " AND time_slots.employee_id='$_SESSION[employee_id]' ";
	}
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
		
			<td>$rs[employee_name] <b>($rs[branch_name])</b></td>
			<td>" . date("h:i A",strtotime($rs['start_time'])) . " </td>
			<td> " . date("h:i A",strtotime($rs['end_time']))  . "</td>
			<td>$rs[status]</td>
			<td><a  href='timeslot.php?editid=$rs[0]' class='btn btn-info'>Edit</a>
			 |  
			<a href='viewtimeslot.php?delid=$rs[0]' class='btn btn-danger'
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