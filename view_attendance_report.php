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
	if(mysqli_affected_rows($con) == 1)
	{
			echo "<script>alert('Vehicle record deleted successfully..');</script>";
		echo "<script>window.location='viewvehicle.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>Attendance Report</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
<form method="get" action="">	
<table class="table  table-striped table-bordered">
	<tr>
	<th style="text-align: left;">Select Month:
	</th>
	<th style="text-align: left;"><input type="month" name="entrymonth" id="entrymonth" class="form-control" value="<?php 
	if(isset($_GET['datesubmit']))
	{
		echo $entrymonth = $_GET['entrymonth'];
	}
	else
	{
		echo $entrymonth = date("Y-m"); 
	}
	?>" ></th>
	<th style="text-align: left;">
	</th>
	<th><input type="submit" name="datesubmit" id="datesubmit" class="btn btn-danger" value="Load Report"></th>
</table>
</form>
<hr>
	<form method="post" action="" enctype="multipart/form-data">
<table id="attendancedatatable" class="table table-striped table-bordered stripe row-border order-colum" > 
	<thead>
		<tr>
			<th>Image</th>
			<th>Employee</th>
			<th>Branch</th>
<?php
for($i=1; $i<=date("t", strtotime($a_date));$i++)
{
echo "<th>$i</th>";
}
?>
			<th>Total Present</th>
			<th>Total Absent</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql ="select  attendance.*,employee.employee_name,employee.profile_img,employee.login_id,employee.branch_id from attendance LEFT JOIN employee ON employee.employee_id=attendance.employee_id ";
	$sql = $sql . "	where employee.status='Active'";
	if($_SESSION['employee_type'] == "Employee")
	{
		$sql = $sql . " AND employee.employee_id='$_SESSION[employee_id]' GROUP BY employee_id";
	}	
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	$ids=0;
	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlbranch = "SELECT * FROM branch WHERE branch_id='$rs[branch_id]'";
		$qsqlbranch = mysqli_query($con,$sqlbranch);
		$rsbranch = mysqli_fetch_array($qsqlbranch);
		$sqledit = "SELECT * FROM attendance WHERE attedance_id='$rs[attedance_id]' AND attedance_date='$_GET[entrydatetime]'";
		$qsqledit = mysqli_query($con,$sqledit);
		if(mysqli_num_rows($qsqledit) == 1)
		{
			$rsedit = mysqli_fetch_array($qsqledit);
			$attstatus = $rsedit["status"];
		}
		else
		{
			$attstatus = "Default";
		}
		//employee.employee_name,employee.profile_img,employee.login_id
		if($rs['profile_img'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgemployee/".$rs['profile_img']))
		{
			$imgname = "imgemployee/".$rs['profile_img'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		echo "<tr>
			<td><img style='width: 70px; height:75px;' src='$imgname'></td>
			<td style='text-align: left;'><input type='hidden' name='employee_id[]' id='employee_id[]' value='$rs[0]'>" . ucfirst($rs['employee_name']) . "<br>
			<b>Login ID -</b> $rs[login_id]</td>
			<td>$rsbranch[branch_name]</td>";
$totalpresent = 0;
$totalabsent = 0;
for($i=1; $i<=date("t", strtotime($a_date));$i++)
{
	$sqledit = "SELECT * FROM attendance WHERE employee_id='$rs[employee_id]' AND attedance_date='$entrymonth-$i 00:00:00'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
	
	if($rsedit['status'] == "Present")
	{
	echo "<td><centeR><b style='color: green;'>P</b></centeR></td>";
	$totalpresent = $totalpresent +1 ;
	}
	else if($rsedit['status'] == "Absent")
	{
	echo "<td><centeR><b style='color: red;'>A</b></centeR></td>";
	$totalabsent = $totalabsent +1;
	}
	else
	{
	echo "<td></td>";
	}
}
			echo "<th><center>$totalpresent</center></th>
			<th><center>$totalabsent</center></th>
		</tr>";
		$ids = $ids +1;
	}
	?>
	</tbody>
</table>
<hr>
<center><a type="button" name="submit"  class="btn btn-primary" style="font-size: 25px;" href="printmiddaymeal_attendance.php?entrymonth=<?php echo $entrymonth; ?>" target="_blank" >Print Report</a></center>
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
$(document).ready( function () {
    $('#attendancedatatable').DataTable({
        scrollY:        "450px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 2,
            rightColumns: 2
        }
    } );
} );
</script>