<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE salary set emp_id='$_POST[emp_id]',sal_date='$_POST[sal_date]',basic_sal='$_POST[basic_sal]',deduction='$_POST[deduction]',bonus='$_POST[bonus]' WHERE sal_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Salary record updated successfully...');</script>";
			echo "<script>window.location='viewsalary.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
		$sql = "INSERT INTO salary(emp_id,sal_date,basic_sal,deduction,bonus,status) values('$_POST[emp_id]','$_POST[sal_date]','$_POST[basic_sal]','$_POST[deduction]','$_POST[bonus]','Active')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('salary record inserted successfully...');</script>";
			$insid = mysqli_insert_id($con);
			echo "<script>window.location='salaryreceipt.php?receiptid=$insid';</script>";
		}
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM salary WHERE sal_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
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
		<h3 class="title">Salary</h3>
		<p class="description">

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Employee</div>
	<div class="col-md-8">
	<select name="emp_id" id="emp_id" class="form-control">
		<option value="">Select Employee</option>
		<?php
	$sqlemployee = "SELECT employee.*,branch.branch_name FROM employee LEFT JOIN branch ON employee.branch_id=branch.branch_id where employee.status='Active' AND employee.employee_type='Employee'";
	$qsqlemployee=  mysqli_query($con,$sqlemployee);
	while($rsemployee = mysqli_fetch_array($qsqlemployee))
	{
		if($rsemployee['employee_id'] == $rsedit['emp_id'] )
		{
		echo "<option value='$rsemployee[employee_id]' selected>$rsemployee[employee_name][ $rsemployee[login_id] ] ($rsemployee[branch_name])</option>";
		}
		else
		{
		echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name] ($rsemployee[login_id]) - ($rsemployee[branch_name])</option>";
		}
	}
	?>
	</select><span id="erremp_id" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Salary Date</div>
	<div class="col-md-8">
	<input type="date" name="sal_date" id="sal_date" class="form-control"value="<?php echo $rsedit['sal_date']; ?>"><span id="errsal_date" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Basic Salary</div>
	<div class="col-md-8">
	<input type="text" name="basic_sal" id="basic_sal" class="form-control"value="<?php echo $rsedit['basic_sal']; ?>"><span id="errbasic_sal" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Deduction</div>
	<div class="col-md-8">
	<input type="text" name="deduction" id="deduction" class="form-control"value="<?php echo $rsedit['deduction']; ?>"><span id="errdeduction" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Bonus</div>
	<div class="col-md-8">
	<input type="text" name="bonus" id="bonus" class="form-control"value="<?php echo $rsedit['bonus']; ?>">
	<span id="errbonus" class="errorclass" ></span>
	</div>
</div>

<br>
<?php
/*
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Status</div>
	<div class="col-md-8">
		<select name="status" id="status" class="form-control" >
			<option value="">Select Status</option>
			<?php
			$arr = array("Active","Inactive");
			foreach($arr as $val)
			{
				
				if($val == $rsedit['status'])
				{
				echo "<option value='$val' selected>$val</option>";
				}
				else
				{
				echo "<option value='$val'>$val</option>";
				}
			}
			?>
		</select><span id="errstatus" class="errorclass" ></span>
	</div>
</div>
*/
?>
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
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("emp_id").value=="")
	{
		document.getElementById("erremp_id").innerHTML="Employee id should not be empty..";
		i=1;
	}
	if(document.getElementById("sal_date").value=="")
	{
		document.getElementById("errsal_date").innerHTML="Salary date  should not be empty..";
		i=1;
	}
	if(document.getElementById("basic_sal").value=="")
	{
		document.getElementById("errbasic_sal").innerHTML="Basic salary should not be empty..";
		i=1;
	}
	if(document.getElementById("deduction").value=="")
	{
		document.getElementById("errdeduction").innerHTML="Deduction  should not be empty..";
		i=1;
	}
	if(document.getElementById("bonus").value=="")
	{
		document.getElementById("errbonus").innerHTML="Bonus  should not be empty..";
		i=1;
	}
	
	/*
	if(document.getElementById("status").value=="")
	{
		document.getElementById("errstatus").innerHTML="Kindly select status.";
		i=1;
	}
	*/
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
