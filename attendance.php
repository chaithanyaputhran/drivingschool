<?php
include("header.php");
if(isset($_POST['submit']))
{
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE attendance set employee_id='$_POST[employee_id]',attedance_date='$_POST[attedance_date]',status='$_POST[status]' WHERE attedance_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Attendance record updated successfully...');</script>";
			echo "<script>window.location='viewattendance.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	//UPdate statement ends here
	else
	{
	
	$sql = "INSERT INTO attendance(employee_id,attedance_date,status) values('$_POST[employee_id]','$_POST[attedance_date]','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Attendance record inserted successfully...');</script>";
		echo "<script>window.location='attendance.php';</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM attendance WHERE attedance_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>

	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-12">
					
<div class="item">
	<div class="serviceBox">
		<h2 class="title">Attendance</h2>
		
		<p class="description">

<form method="get" action="" >
	<table class="table  table-striped table-bordered">
		<tr>
		<th style="text-align: left;">Attendance Month: <input type="month" name="month" id="month" class="form-control" value="<?php echo $_GET['month']; ?>"></th>
		<th style="text-align: left;">Branch:
<select name="branch_id" id="branch_id" class="form-control">
	<option value="">Select Branch</option>
	<?php
	$sqlbranch = "SELECT * FROM branch where status='Active'";
	$qsqlbranch=  mysqli_query($con,$sqlbranch);
	while($rsbranch = mysqli_fetch_array($qsqlbranch))
	{
		if($rsbranch['branch_id'] == $_GET['branch_id'])
		{
		echo "<option value='$rsbranch[branch_id]' selected>$rsbranch[branch_name]</option>";
		}
		else
		{
		echo "<option value='$rsbranch[branch_id]'>$rsbranch[branch_name]</option>";
		}
	}
	?>
</select>
		</th>
		<th>&nbsp;<bR><input type="submit" name="btnsearch" value="Select Month" class="btn btn-info" > </th>
	</table>
</form>
<hr>
<div class="row">
	<div class="col-md-12">
<table class="table  table-striped table-bordered">
	<tr>
		<th style='width: 85px;'>Image</th>
		<th style='text-align: left;'>Employee</th>
<?php
?>
		<th>1</th>
<?php
?>
		<th>P</th>
		<th>A</th>
	</tr>
<?php
$sql ="SELECT * FROM employee WHERE status='Active' AND employee_type='Employee'";
$qsql = mysqli_query($con,$sql);
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
?>	
	<tr>
		<td><img src='<?php echo $imgname; ?>' style='width: 85px; height: 90px;' ></td>
		<td style='text-align: left;width: 105px;'>
		<?php echo $rs['employee_name']; ?>
		</td>
		<td>1</td>
		<th>0</th>
		<th>0</th>
	</tr>
<?php
}
?>
</table>
	</div>
</div>
		</p>
		<hr>
		<input type="button" class="btn btn-warning" name="submit"  value="Print" >
	</div>
</div>

				</div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
<?php
include("footer.php");
?>
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("employee_id").value=="")
	{
		document.getElementById("erremployee_id").innerHTML="Employee id should not be empty..";
		i=1;
	}
	if(document.getElementById("attedance_date").value=="")
	{
		document.getElementById("errattedance_date").innerHTML="Attedance date should not be empty..";
		i=1;
	}
	if(document.getElementById("status").value=="")
	{
		document.getElementById("errstatus").innerHTML="Kindly select status.";
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