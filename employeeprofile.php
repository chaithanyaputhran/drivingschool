<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	$empcertificate = rand(). $_FILES['certificate']['name'];
	move_uploaded_file($_FILES['certificate']['tmp_name'],"imgemployee/".$empcertificate);
	
	$profile_img = rand(). $_FILES['profile_img']['name'];
	move_uploaded_file($_FILES['profile_img']['tmp_name'],"imgemployee/".$profile_img);
	
 	
	//Update statement starts here
	if(isset($_SESSION['employee_id']))
	{
		$sql = "UPDATE employee set employee_name='$_POST[employee_name]',gender='$_POST[gender]',employee_type='$_POST[employee_type]',login_id='$_POST[login_id]',email_id='$_POST[email_id]',profile='$_POST[profile]',address='$_POST[address]',contact_no='$_POST[contact_no]'";
		if($_FILES['certificate']['name'] != "")
		{
		$sql = $sql . ",certificate='$empcertificate'";
		}
		if($_FILES['profile_img']['name'] != "")
		{
		$sql = $sql . ",profile_img='$profile_img'";
		}
		$sql = $sql . ",branch_id='$_POST[branch_id]' WHERE employee_id='$_SESSION[employee_id]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Employee profile record updated successfully...');</script>";
			echo "<script>window.location='employeeprofile.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
	 	$sql = "INSERT INTO employee(employee_name,employee_type,login_id,password,email_id,profile,address,contact_no,certificate,profile_img,status,branch_id) values('$_POST[employee_name]','$_POST[employee_type]','$_POST[login_id]'
	 ,'$_POST[password]','$_POST[email_id]','$_POST[profile]','$_POST[address]','$_POST[contact_no]','$empcertificate','$profile_img','$_POST[status]','$_POST[branch_id]')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Employee record inserted successfully...');</script>";
			echo "<script>window.location='employee.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
?>
<?php
if(isset($_SESSION['employee_id']))
{
	$sqledit = "SELECT * FROM employee WHERE employee_id='$_SESSION[employee_id]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Employee Profile</h3>
		<p class="description">

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Employee Name </div>
<div class="col-md-8">
<input type="text" name="employee_name" id="employee_name" class="form-control"value="<?php echo $rsedit['employee_name']; ?>"><span id="erremployee_name" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Branch </div>
	<div class="col-md-8">
	<select name="branch_id" id="branch_id" class="form-control">
	<?php
	$sqlbranch = "SELECT * FROM branch where status='Active'";
	$qsqlbranch=  mysqli_query($con,$sqlbranch);
	while($rsbranch = mysqli_fetch_array($qsqlbranch))
	{
		if($rsbranch['branch_id'] == $rsedit['branch_id'] )
		{
		echo "<option value='$rsbranch[branch_id]' selected>$rsbranch[branch_name]</option>";
		}
	}
	?>
	</select><span id="errbranch_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Employee Type </div>
<div class="col-md-8">
<select name="employee_type" id="employee_type" class="form-control">
	<?php
	$arr = array("Admin","Employee");
	foreach($arr as $val)
	{
		if($val == $rsedit['employee_type'])
		{
		echo "<option value='$val' selected>$val</option>";
		}
	}
	?>
</select><span id="erremployee_type" class="errorclass" ></span>
</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Login ID </div>
	<div class="col-md-8">
<input type="text" name="login_id" id="login_id" class="form-control" value="<?php echo $rsedit['login_id']; ?>"><span id="errlogin_id" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Employee Email </div>
<div class="col-md-8">
<input type="text" name="email_id" id="email_id" class="form-control"value="<?php echo $rsedit['email_id']; ?>"><span id="erremail_id" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Gender</div>
	<div class="col-md-8">
		<select name="gender" id="gender" class="form-control" >
			<option value="">Select gender</option>
			<?php
			$arr = array("Male","Female");
			foreach($arr as $val)
			{
				if($val == $rsedit['gender'])
				{
				echo "<option value='$val' selected>$val</option>";
				}
				else
				{
				echo "<option value='$val'>$val</option>";
				}
			}
			?>
		</select>
		<span id="errgender" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Profile </div>
	<div class="col-md-8">
	<textarea name="profile" id="profile" class="form-control"><?php echo $rsedit['profile']; ?></textarea><span id="errprofile" class="errorclass" ></span>
</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	> Employee Address</div>
	<div class="col-md-8">
	<textarea name="address" id="address" class="form-control"><?php echo $rsedit['address']; ?></textarea><span id="erraddress" class="errorclass" ></span>
</div>
</div>

<br>
<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	> Contact Number </div>
<div class="col-md-8">
<input type="text" name="contact_no" id="contact_no" class="form-control"value="<?php echo $rsedit['contact_no']; ?>"><span id="errcontact_no" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Certificate  </div>
<div class="col-md-8" style="text-align: left;">
<input type="file" name="certificate" id="certificate" class="form-control" >
<?php
if(isset($_SESSION['employee_id']))
{
	if(file_exists("imgemployee/".$rsedit['certificate']))
	{
		echo "<a href='imgemployee/$rsedit[certificate]'  class='btn btn-primary' download >Download</a>";
	}
}
?><span id="errcertificate" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Profile Image  </div>
<div class="col-md-8" style="text-align: left;">
<input type="file" name="profile_img" id="profile_img" class="form-control" accept="image/*">
<?php
if(isset($_SESSION['employee_id']))
{
	if($rsedit['profile_img'] == "")
	{
		$imgname="images/default-image.jpg";
	}
	else if(file_exists("imgemployee/".$rsedit['profile_img']))
	{
		$imgname= "imgemployee/".$rsedit['profile_img'];
	}
	else
	{
		$imgname="images/default-image.jpg";
	}
	echo "<img src='$imgname' style='width: 125px; height: 150px;' >";
}
?>
</div>
</div>
<br>


		</p>
		<input type="submit" class="btn btn-warning" name="submit"  value="Update Profile" >
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
	if(document.getElementById("employee_name").value=="")
	{
		document.getElementById("erremployee_name").innerHTML="Employee Name should not be empty..";
		i=1;
	}
	if(document.getElementById("employee_type").value=="")
	{
		document.getElementById("erremployee_type").innerHTML="Kindly select Employee Type.";
		i=1;
	}
	if(document.getElementById("login_id").value=="")
	{
		document.getElementById("errlogin_id").innerHTML="Kindly Enter Login ID..";
		i=1;
	}
	if(document.getElementById("email_id").value=="")
	{
		document.getElementById("erremail_id").innerHTML="Confirm Password should not be empty.";
		i=1;
	}
	if(document.getElementById("contact_no").value=="")
	{
		document.getElementById("errcontact_no").innerHTML="Contact Number should not be empty.";
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