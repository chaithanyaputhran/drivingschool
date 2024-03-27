<?php
include("header.php");
if(isset($_POST['submit']))
{
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE examination set cust_id='$_POST[cust_id]',exam_date='$_POST[exam_date]',qstn_id='$_POST[qstn_id]',ans='$_POST[ans]'WHERE exam_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Examination record updated successfully...');</script>";
			echo "<script>window.location='viewexamination.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	//UPdate statement ends here
	else
	{
	$sql = "INSERT INTO examination(cust_id,exam_date,qstn_id,ans) values('$_POST[cust_id]','$_POST[exam_date]','$_POST[qstn_id]','$_POST[ans]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('examination record inserted successfully...');</script>";
		echo "<script>window.location='examination.php';</script>";
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
	$sqledit = "SELECT * FROM examination WHERE exam_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Examination</h3>
		<p class="description">


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer </div>
	<div class="col-md-8">
	<select name="cust_id" id="cust_id" class="form-control">
	<option value="">Select Employee</option>
	<?php
	$sqlemployee = "SELECT * FROM employee where status='Active'";
	$qsqlemployee=  mysqli_query($con,$sqlemployee);
	while($rsemployee = mysqli_fetch_array($qsqlemployee))
	{
		if($rsemployee['employee_id'] == $rsedit['employee_id'])
		{
		echo "<option value='$rsemployee[employee_id]' selected>$rsemployee[employee_name]</option>";
		}
		else
		{
		echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name]</option>";
		}
	}
	?>
	</select><span id="errcust_id" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Exam Date</div>
	<div class="col-md-8">
	<input type="date" name="exam_date" id="exam_date" class="form-control"value="<?php echo $rsedit['exam_date']; ?>"><span id="errexam_date" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>question id </div>
	<div class="col-md-8">
	<select name="qstn_id" id="qstn_id" class="form-control">
	<option value="">Select Employee</option>
	<?php
	$sqlemployee = "SELECT * FROM employee where status='Active'";
	$qsqlemployee=  mysqli_query($con,$sqlemployee);
	while($rsemployee = mysqli_fetch_array($qsqlemployee))
	{
		if($rsemployee['employee_id'] == $rsedit['employee_id'])
		{
		echo "<option value='$rsemployee[employee_id]' selected>$rsemployee[employee_name]</option>";
		}
		else
		{
		echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name]</option>";
		}
	}
	?>
	</select><span id="errqstn_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Answer</div>
	<div class="col-md-8">

<input type="text" name="ans" id="ans" class="form-control"value="<?php echo $rsedit['ans']; ?>">
<span id="errans" class="errorclass" ></span>
	</div>
</div>

<br>
</p>
		<input type="submit" class="btn btn-warning" name="submit"  value="Submit" >
	</div>
</div>

				</div>
				<div class="col-lg-2"></div>
			</div>			
		</div>
	</div>
	<!-- End Services -->
</form>
<?php
include("footer.php");
?>
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("cust_id").value=="")
	{
		document.getElementById("errcust_id").innerHTML="Kindly select customer ";
		i=1;
	}
	if(document.getElementById("exam_date").value=="")
	{
		document.getElementById("errexam_date").innerHTML="Exam date should not be empty..";
		i=1;
	}
	if(document.getElementById("qstn_id").value=="")
	{
		document.getElementById("errqstn_id").innerHTML="Question should not be empty..";
		i=1;
	}
	if(document.getElementById("ans").value=="")
	{
		document.getElementById("errans").innerHTML="Answer should not be empty..";
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