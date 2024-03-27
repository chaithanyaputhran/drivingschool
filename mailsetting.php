<?php
include("header.php");
if(isset($_POST["submit"]))
{
	//Insert Statement starts here
	$smtp['mailsender'] 	= $_POST["mailsender"];
	$smtp['smtpserver'] 	= $_POST["smtpserver"];
	$smtp['smtpport']  		= $_POST["smtpport"];
	$smtp['loginid']  		= $_POST["loginid"];
	$smtp['password']  		= $_POST["password"];
	$smtp['smtpdetails'] 	= serialize($smtp);
	//email_template
	$email_template['companyname'] =	$_POST["companyname"];
	$email_template['contactno']  =	$_POST["contactno"];
	$email_template['companyaddress'] = 	$_POST["companyaddress"];
	$email_template['facebook'] = 	$_POST["facebook"];
	$email_template['twitter'] = 	$_POST["twitter"];
	$email_template['youtube'] = 	$_POST["youtube"];
	$email_template['linkedin'] = 	$_POST["linkedin"];
	$email_template['email_temp_det'] = serialize($email_template);	
	$sqldel ="DELETE from mail_setting where settingtype='SMTP'";
	$qsqldel = mysqli_query($con,$sqldel);
	$sql = "INSERT INTO mail_setting (settingtype,settingdetails,status,email_template) VALUES('SMTP','$smtp[smtpdetails]','Active','$email_template[email_temp_det]')";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		//$subject = "Mail from " . $email_template['companyname'] . " Mail Configuration..";
		//$message = "Hello,<br>This mail sent from Mail settings to confirm mail sender working or not..";
		//include("phpmailer.php");
		//sendmail($smtp['loginid'], $smtp['mailsender'] , $subject, $message);
		echo "<script>alert('SMTP Setting Record updated successfully..');</script>";
		echo "<script>window.location='mailsetting.php';</script>";
	}
	else
	{
		$errmsg = str_replace("'","",mysqli_error($con));
		echo "<script>alert('$errmsg');</script>";
	}
	//Insert Statement ends here
}
?>
<?php
$sqledit = "SELECT * FROM mail_setting where settingtype='SMTP'";
$qsqledit = mysqli_query($con,$sqledit);
echo mysqli_error($con);
$rsedit = mysqli_fetch_array($qsqledit);
$smtpdetails = unserialize($rsedit['settingdetails']);
$email_template_det = unserialize($rsedit['email_template']);
?>
		<section class="ftco-section bg-light" style="padding-top: 15px;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 ftco-animate">

            <div class="job-post-item bg-white p-4 d-block align-items-center">
<div class="mb-4 mb-md-1 mr-12">
	<div class="job-post-item-header d-flex align-items-center">
	  <h2 class="mr-3 text-black h3">Mail Settings</h2>
	  <div class="page-title-subheading">Add/Edit SMTP Setting details..
</div>
	</div>


<div class="tab-content">
<div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
	<div class="main-card mb-3 card">
		<div class="card-body">
<form method="post"  onsubmit="return validatesubmit()"  action="">   
<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Mail Sender</label>
				<input name="mailsender" id="mailsender" type="text" class="form-control" value="<?php echo $smtpdetails['mailsender']; ?>" >
				<span id="errmailsender" class="errorclass" ></span>
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">SMTP Server</label>
				<input name="smtpserver" id="smtpserver" type="text" class="form-control" value="<?php echo $smtpdetails['smtpserver']; ?>" >
				<span id="errsmtpserver" class="errorclass" ></span>
			</div>
		</div> 
</div>
<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Login ID</label>
				<input name="loginid" id="loginid" type="text" class="form-control" value="<?php echo $smtpdetails['loginid']; ?>" >
				<span id="errloginid" class="errorclass" ></span>
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">SMTP Port</label>
				<input name="smtpport" id="smtpport" type="text" class="form-control" value="<?php echo $smtpdetails['smtpport']; ?>" >
				<span id="errsmtpport" class="errorclass" ></span>
			</div>
		</div>
</div>
<div class="form-row">
	<div class="col-md-6">
		<div class="position-relative form-group">
			<label for="exampleCity" class="">Password</label>
			<input name="password" id="password" type="password" class="form-control" value="<?php echo $smtpdetails['password']; ?>" >
				<span id="errpassword" class="errorclass" ></span>
		</div>
	</div>
	<div class="col-md-6">
		<div class="position-relative form-group">
			<label for="exampleCity" class="">Confirm Password</label>
			<input name="cpassword" id="cpassword" type="password" class="form-control" value="<?php echo $smtpdetails['password']; ?>" >
				<span id="errcpassword" class="errorclass" ></span>
		</div>
	</div>
</div>
<div class="col-md-12"><hr></div>
<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Company name</label>
				<input name="companyname" id="companyname" type="text" class="form-control" value="<?php echo $email_template_det['companyname']; ?>" >
				<span id="errcompanyname" class="errorclass" ></span>
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Contact No.</label>
				<input name="contactno" id="contactno" type="text" class="form-control"  value="<?php echo $email_template_det['contactno']; ?>" >
				<span id="errcontactno" class="errorclass" ></span>
			</div>
		</div>
</div>
<div class="col-md-12">
</div>
<div class="form-row">
		<div class="col-md-12">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Address</label>
				<textarea name="companyaddress" id="companyaddress" class="form-control" ><?php echo $email_template_det['companyaddress']; ?></textarea>
				<span id="errcompanyaddress" class="errorclass" ></span>
			</div>
		</div>
	</div>
<div class="col-md-12">
</div>
<hr>
<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Facebook URL</label>
				<input name="facebook" id="facebook" type="text" class="form-control"  value="<?php echo $email_template_det['facebook']; ?>" >
				<span id="errfacebook" class="errorclass" ></span>
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Twitter URL</label>
				<input name="twitter" id="twitter" type="text" class="form-control"  value="<?php echo $email_template_det['twitter']; ?>" >
				<span id="errtwitter" class="errorclass" ></span>
			</div>
		</div>
</div>
<div class="col-md-12">
</div>
<div class="form-row">
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Youtube URL</label>
				<input name="youtube" id="youtube" type="text" class="form-control"  value="<?php echo $email_template_det['youtube']; ?>" >
				<span id="erryoutube" class="errorclass" ></span>
			</div>
		</div>
		<div class="col-md-6">
			<div class="position-relative form-group">
				<label for="exampleCity" class="">Linked In URL</label>
				<input name="linkedin" id="linkedin" type="text" class="form-control"  value="<?php echo $email_template_det['linkedin']; ?>" >
				<span id="errlinkedin" class="errorclass" ></span>
			</div>
		</div>
</div>
<div class="col-md-12"><hr>
</div>
<center><button class="mt-2 btn btn-primary" name="submit" type="submit">Update Settings</button></center>
</form>

            </div>
          </div><!-- end -->
			</div>
			</div>
		</section>
<?php
include("footer.php");
?>
<script>
function validatesubmit()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("mailsender").value=="")
	{
		document.getElementById("errmailsender").innerHTML="Mail Sender should not be empty..";
		i=1;
	}
	if(document.getElementById("smtpserver").value=="")
	{
		document.getElementById("errsmtpserver").innerHTML="SMTP server details should not be empty..";
		i=1;
	}
	if(document.getElementById("loginid").value=="")
	{
		document.getElementById("errloginid").innerHTML="Login ID should not be empty..";
		i=1;
	}
	if(document.getElementById("smtpport").value == "")
	{
		document.getElementById("errcust_cpassword").innerHTML="SMTP Port should not be empty..";
		i=1;
	}
	if(document.getElementById("password").value != document.getElementById("cpassword").value)
	{
		document.getElementById("errcpassword").innerHTML="Password and Confrim password not matching..";
		i=1;
	}
	if(document.getElementById("password").value=="")
	{
		document.getElementById("errpassword").innerHTML="Password should not be empty...";
		i=1;
	}
	if(document.getElementById("cpassword").value=="")
	{
		document.getElementById("errcpassword").innerHTML="Password should not be empty...";
		i=1;
	}
	//#######
	if(document.getElementById("companyname").value=="")
	{
		document.getElementById("errcompanyname").innerHTML="Company name should not be empty..";
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