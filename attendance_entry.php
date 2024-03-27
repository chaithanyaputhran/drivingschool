<?php
include("header.php");
if(isset($_GET['entrydatetime']))
{
	$_GET['entrydatetime'] = $_GET['entrydatetime'];
}
else
{
	$_GET['entrydatetime'] = date("Y-m-d");
}
if(isset($_POST['submit']))
{
	{
		$sql ="DELETE  FROM attendance where attedance_date='$_GET[entrydatetime] 00:00:00'";
		$qsql = mysqli_query($con,$sql);
		$arremployee_id = $_POST['arremployee_id'];
		$attendancestatus = $_POST['attendancestatus'];
		for($id=0; $id<count($arremployee_id);$id++)
		{
			$employee_id = $arremployee_id[$id];
			$sql ="INSERT INTO attendance(employee_id,attedance_date,status) VALUES('$arremployee_id[$id]','$_GET[entrydatetime] 00:00:00','$attendancestatus[$employee_id]')";
			$qsql = mysqli_query($con,$sql);
			if(mysqli_affected_rows($con) == 1)
			{
			}
			else
			{
				echo mysqli_error($con);
			}
		}
			echo "<script>alert('Attendance entry done successfully..');</script>";
	}
}
?>

	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-12">
					
<div class="item">
	<div class="serviceBox">
		<h2 class="title">ATTENDANCE ENTRY</h2>
		
		<p class="description">

<form method="get" action="" >
	<table class="table  table-striped table-bordered">
		<tr>
		<th style="text-align: left;">Select date:
		</th>
		<th style="text-align: left;"> <input type="date" name="entrydatetime" id="entrydatetime" class="form-control" value="<?php 
	if(isset($_GET['datesubmit']))
	{
		echo $_GET['entrydatetime'];
	}
	else
	{
		$_GET['entrydatetime'] = date("Y-m-d");
		echo date("Y-m-d"); 
	}
	?>"  max="<?php echo date("Y-m-d"); ?>" ></th>
		<th style="text-align: left;">
		</th>
		<th><input type="submit" name="datesubmit" id="datesubmit" class="btn btn-danger" value="Select Date"></th>
	</table>
</form>
<hr>
<div class="row">
	<div class="col-md-12">
	<hr>
	<form method="post" action="" enctype="multipart/form-data">
<table class="table table-striped table-bordered" > 
	<thead>
		<tr>
			<th>Image</th>
			<th style='text-align: left;'>Employee name</th>
			<th style='text-align: left;'>Branch</th>
			<th style='text-align: left;'>Contact detail</th>
			<th>Present</th>
			<th>Absent</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql ="SELECT employee.*,branch.branch_name FROM employee LEFT JOIN branch on employee.branch_id=branch.branch_id WHERE employee.status='Active' AND employee.employee_type='Employee'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	$ids=0;
	while($rs = mysqli_fetch_array($qsql))
	{
		//##
		$sqledit = "SELECT * FROM attendance WHERE employee_id='$rs[employee_id]' AND attedance_date='$_GET[entrydatetime]'";
		$qsqledit = mysqli_query($con,$sqledit);
		echo mysqli_error($con);
		if(mysqli_num_rows($qsqledit) == 1)
		{
			$rsedit = mysqli_fetch_array($qsqledit);
			$attstatus = $rsedit["status"];
		}
		else
		{
			$attstatus = "Default";
		}
		//##
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
			<td style='text-align: left;'><input type='hidden' name='arremployee_id[]' id='arremployee_id[]' value='$rs[0]'>" . ucfirst($rs['employee_name']) . "<br>
			<b>Login ID. -</b> $rs[login_id]</td>
			<td style='text-align: left;'>
			$rs[branch_name]
			</td>
			<td style='text-align: left;'>
			<b>Email -</b> $rs[email_id] <br>
			<b>Ph. No. -</b> $rs[contact_no]</td>
			<td>
			<input type='radio' name='attendancestatus[$rs[0]]' id='attendancestatus[$rs[0]]' value='Present' ";			
			if($attstatus == "Present")
			{
				echo " checked ";
			}
			else if($attstatus == "Absent")
			{
				echo " checked ";
			}
			else
			{
				echo " checked ";
			}
			echo " ></td><td>
			<input type='radio' name='attendancestatus[$rs[0]]' id='attendancestatus[$rs[0]]' value='Absent' ";
			if($attstatus == "Absent")
			{
				echo " checked ";
			}
			echo "	>  
			</td>
		</tr>";
		$ids = $ids +1;
	}
	?>
	</tbody>
</table>
<hr>
<input type="submit" name="submit" value="Submit Attendance Entry Report" class="btn btn-primary" style="font-size: 25px;" >
			</form>
	</div>
</div>
		</p>
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
<style>
input[type=radio] {
    border: 0px;
    width: 100%;
    height: 2em;
}
</style><script>
function validateform()
{	
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	
	var i = 0;

	
	if(document.getElementById("customer_name").value=="")
	{
		document.getElementById("errcustomer_name").innerHTML="Customer name should not be empty..";
		i=1;
	}
	if(document.getElementById("customer_address").value=="")
	{
		document.getElementById("errcustomer_address").innerHTML="Customer address should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_email").value=="")
	{
		document.getElementById("errcust_email").innerHTML="Customer email should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_mob").value=="")
	{
		document.getElementById("errcust_mob").innerHTML="Customer mobile number should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_password").value=="")
	{
		document.getElementById("errcust_password").innerHTML="Customer password should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_cpassword").value == "")
	{
		document.getElementById("errcust_cpassword").innerHTML=" Confrim password should not be empty..";
		i=1;
	}
	if(document.getElementById("cust_cpassword").value != document.getElementById("cust_password").value)
	{
		document.getElementById("errcust_cpassword").innerHTML="Password and Confrim password not matching..";
		i=1;
	}
	if(document.getElementById("profile_img").value=="")
	{
		document.getElementById("errprofile_img").innerHTML="Kindly upload profile image.";
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