<?php
include("header.php");
if(isset($_POST['submit']))
{
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE payment set dl_id='$_POST[dl_id]',class_id='$_POST[class_id]',payment_date='$_POST[payment_date]',paid_amt='$_POST[paid_amt]',status='$_POST[status]'WHERE payment_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Payment record updated successfully...');</script>";
			echo "<script>window.location='viewpayment.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
		$sql = "INSERT INTO payment(dl_id,class_id,payment_date,paid_amt,status) values('$_POST[dl_id]','$_POST[class_id]','$_POST[payment_date]','$_POST[paid_amt]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('payment record inserted successfully...');</script>";
			echo "<script>window.location='payment.php';</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM payment WHERE payment_id='$_GET[editid]'";
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
		<h3 class="title">payment</h3>
		<p class="description">

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>DL</div>
	<div class="col-md-8">
	<select name="dl_id" id="dl_id" class="form-control">
		
	</select><span id="errdl_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>class</div>
	<div class="col-md-8">
	<select name="class_id" id="class_id" class="form-control">
		
	</select><span id="errclass_id" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>payment Date</div>
	<div class="col-md-8">
	<input type="date" name="payment_date" id="payment_date" class="form-control"value="<?php echo $rsedit['payment_date']; ?>"><span id="errpayment_date" class="errorclass" ></span>
	</div>
</div>
<br>


<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>paid amount</div>
	<div class="col-md-8">
	<input type="text" name="paid_amt" id="paid_amt" class="form-control"value="<?php echo $rsedit['paid_amt']; ?>"><span id="errpaid_amt" class="errorclass" ></span>
	</div>
</div>

<br>



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
	if(document.getElementById("dl_id").value=="")
	{
		document.getElementById("errdl_id").innerHTML=" Kindly select dl id. .";
		i=1;
	}
	if(document.getElementById("class_id").value=="")
	{
		document.getElementById("errclass_id").innerHTML="Class should not be empty..";
		i=1;
	}
	if(document.getElementById("payment_date").value=="")
	{
		document.getElementById("errpayment_date").innerHTML="Payment date should not be empty..";
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