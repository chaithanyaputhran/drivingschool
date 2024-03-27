<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM employee where employee_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Employee record deleted successfully..');</script>";
		echo "<script>window.location='viewemployee.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW EMPLOYEE  RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Profile Image</th>
			<th>Employee Name</th>
			<th>Branch</th>
			<th>Login ID</th>
			<th>Gender</th>
			<th>Contact Detail</th>
			<th>certificate</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT employee.*,branch.branch_name from employee LEFT JOIN branch ON employee.branch_id=branch.branch_id ORDER BY employee.employee_id";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		if($rs['profile_img'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgemployee/".$rs['profile_img']))
		{
			$imgname= "imgemployee/".$rs['profile_img'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		echo "<tr>
			<td><img src='$imgname' style='width: 85px; height: 90px;' ></td>
			<td>$rs[employee_name]<br>(<B>$rs[employee_type]</b>)</td>
			<td>$rs[branch_name]</td>
			<td>$rs[login_id]</td>
			<td>$rs[gender]</td>
			<td style='text-align: left;'>$rs[address]<br><b>Ph. No.-</b>$rs[contact_no]<br>
			EMail - $rs[email_id]</td>
			<td>";
			
		if(file_exists("imgemployee/".$rs['certificate']))
		{
			echo "<a href='imgemployee/$rs[certificate]'  class='btn btn-primary' download ><i class='fa fa-download' aria-hidden='true'></i></a>";
		}
			
		echo "</td>
			<td>$rs[status]</td>
			<td>
			<a  href='employee.php?editid=$rs[0]' class='btn btn-info' style='width: 100%;'>Edit</a>		
			<a href='viewemployee.php?delid=$rs[0]' class='btn btn-danger'
			onclick='return confirm2delete()' style='width: 100%;'>Delete</a>
			
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