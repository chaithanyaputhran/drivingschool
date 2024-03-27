<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM salary where sal_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Salaly record deleted successfully..');</script>";
		echo "<script>window.location='viewsalary.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW  SALARY RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Employee</th>
			<th>Branch</th>
			<th>Salary date</th>
			<th>Basic Salary </th>
			<th>Deduction</th>
			<th>Bonus</th>
			<th>Total Salary</th>
			<th>Receipt</th>
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
	$sql = "SELECT salary.*,employee.employee_name,employee.login_id, employee.gender, employee.address, employee.contact_no, branch.branch_name FROM salary LEFT JOIN employee ON salary.emp_id=employee.employee_id LEFT JOIN branch ON branch.branch_id=employee.branch_id";
	if($_SESSION['employee_type'] == "Employee")
	{
		$sql = $sql . " WHERE employee.employee_id='$_SESSION[employee_id]'";
	}
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
			<td>
			$rs[employee_name]<br>
			($rs[login_id])
			</td>
			<td>" . $rs['branch_name'] . "</td>
			<td>" . date("d-M-Y",strtotime($rs['sal_date'])) . "</td>
			<td>Rs. $rs[basic_sal]</td>
			<td>Rs. $rs[deduction]</td>
			<td>Rs. $rs[bonus]</td>
			<td>Rs. ";
			echo ($rs['basic_sal'] + $rs['bonus']) - $rs['deduction'];
		echo "</td>
			<td><a  href='salaryreceipt.php?receiptid=$rs[0]' class='btn btn-info' style='width: 75px;' target='_blank'>Print</a>
			</td>";
	if($_SESSION['employee_type'] == "Admin")
	{			
		echo "	<td><a  href='salary.php?editid=$rs[0]' class='btn btn-info' style='width: 75px;'>Edit</a>
			 <br>
			<a href='viewsalary.php?delid=$rs[0]' class='btn btn-danger' onclick='return confirm2delete()' style='width: 75px;'>Delete</a>
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