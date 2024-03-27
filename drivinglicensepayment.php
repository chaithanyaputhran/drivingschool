<?php
include("header.php");
if(isset($_POST['submit']))
{
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE payment set dl_id='$_POST[dl_id]',class_id='$_POST[class_id]',payment_date='$_POST[payment_date]',paid_amt='$_POST[paid_amt]',status='$_POST[status]' WHERE payment_id='$_GET[editid]'";
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
		$dt = date("Y-m-d");
		$arr = serialize(array('$_POST[card_type]','$_POST[card_holder]','$_POST[card_number]','$_POST[cvv_number]'));
		$sql = "INSERT INTO payment(dl_id,class_id,payment_date,paid_amt,payment_detail,status) values('$_GET[insid]','0','$dt','$_POST[advpay_amt]','$arr','Active')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			$inspmtid= mysqli_insert_id($con);

			//Update driving class starts here			
			$sqlupd ="UPDATE driving_license SET status='Active' WHERE dl_id='$_GET[insid]'";
			$qsqlupd = mysqli_query($con,$sqlupd);
			//Update driving class ends here

		$sqlcustomer ="SELECT * FROM customer where customer_id='$_SESSION[customer_id]'";
		$qsqlcustomer = mysqli_query($con,$sqlcustomer);
		echo mysqli_error($con);
		$rscustomer = mysqli_fetch_array($qsqlcustomer);
		
		$sqlpayment = "SELECT * FROM payment WHERE status='Active' AND  payment_id='$inspmtid'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		
		$sqldriving_class = "SELECT driving_license.*,customer.customer_name,branch.branch_name,package.vehicle_type FROM driving_license LEFT JOIN customer on driving_license.customer_id = customer.customer_id LEFT JOIN branch ON branch.branch_id = driving_license.branch_id LEFT JOIN package ON package.package_id=driving_license.package_id WHERE driving_license.dl_id='$rspayment[dl_id]'";
		$qsqldriving_class = mysqli_query($con,$sqldriving_class);
		echo mysqli_error($con);
		$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
		
		//driving LICENSE package starts here
		$sqlpackage = "SELECT package.*,branch.* FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_id='$rsdriving_class[package_id]'";
		$qsqlpackage = mysqli_query($con,$sqlpackage);
		$rspackage = mysqli_fetch_array($qsqlpackage);
		//driving LICENSE package ends here
		
		//PHP Mailer Starts here
		$subject = "Driving License Application - 24X7 Driving School";
		$message = "Hello $rscustomer[customer_name],<br>Thanks for applying for Driving License.. The Application details are here..<br> <br>
			<table   style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<td colspan='2'  style='border: 1px solid black; border-collapse: collapse;'>
				<center>$rspackage[branch_name] <br>
				$rspackage[branch_address]<br>
				Ph. No. $rspackage[contact_no]
				</center>
			</td>
		</tr>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<td style='width: 50%;text-align: left; border: 1px solid black; border-collapse: collapse;'>
			<b>- Customer -</b><br>";

		$sqlcustomer ="SELECT * FROM customer where customer_id='$rsdriving_class[customer_id]'";
		$qsqlcustomer = mysqli_query($con,$sqlcustomer);
		$rscustomer = mysqli_fetch_array($qsqlcustomer);
		
		$message = $message .  $rscustomer['customer_name'] . "<br>";
		$message = $message .  $rscustomer['customer_address'] . "<br>";
		$message = $message .  $rscustomer['cust_email'] . "<br>";
		$message = $message .  "<b>Ph No.</b> " .$rscustomer['cust_mob'] . "<br>";
		$message = $message .  "</td>
				<td style='width: 50%;text-align: right;border: 1px solid black; border-collapse: collapse'>
					<b>Bill Date:</b>" .  date("d-M-Y",strtotime($rspayment['payment_date'])) . "<br><b>Bill No.</b> $rspayment[payment_id] </td>
			</tr>
		</table>
		<hr>
		<table  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
			<tr style='background-color: #f8f9fa;border: 1px solid black; border-collapse: collapse;'>
				<th style='text-align: left; border: 1px solid black; border-collapse: collapse;'>Transaction details</th>
				<th style='text-align: right; width: 250px;border: 1px solid black; border-collapse: collapse;'>Cost</th>
			</tr>
			<tr style='border: 1px solid black; border-collapse: collapse;'>
				<td style='text-align: left;border: 1px solid black; border-collapse: collapse;'><b>Vehicle Type : </b>" . $rspackage['vehicle_type'] . "<br>"."<b>Package Title : </b>" . $rspackage['package_title'] . "<br></td>
				<td style='text-align: right; border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</td>
			</tr>
			<tr style='border: 1px solid black; border-collapse: collapse;'>
				<th style='text-align: right;border: 1px solid black; border-collapse: collapse;'>Total Paid Amount -</th>
				<th style='text-align: right;border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</th>
			</tr>
		</table>";
		include("phpmailer.php");
		sendmail($rscustomer['cust_email'], $rscustomer['customer_name'] , $subject, $message,'');
		//PHP Mailer Ends here
			echo "<script>alert('Driving License Payment done successfully...');</script>";
			echo "<script>window.location='drivinglicensereceipt.php?insid=$inspmtid';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM payment WHERE payment_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
if(isset($_GET['insid']))
{
	$sqldriving_class = "SELECT * FROM driving_license WHERE dl_id='$_GET[insid]'";
	$qsqldriving_class = mysqli_query($con,$sqldriving_class);
	$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
}
?>
<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Make payment</h3><hr>
		<p class="description">

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Total amount</div>
	<div class="col-md-8">
	<input type="text" name="totpay_amt" id="totpay_amt" class="form-control" value="<?php echo $rsdriving_class['package_cost']; ?>" readonly>
	</div>
</div>

<input type="hidden" name="advpay_amt" min="1" id="advpay_amt" class="form-control" value="<?php echo $rsdriving_class['package_cost']; ?>"  >
<input type="hidden" name="balpay_amt" id="balpay_amt" class="form-control" value="<?php echo $rsdriving_class['package_cost']; ?>"  readonly>


<hr>



<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Card Type </div>
	<div class="col-md-8">
	<select name="card_type" id="card_type" class="form-control">
	<option value="">Select card type</option>
			<?php
			$arr = array("VISA","Master Card","Rupay","American Express");
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
	</select>
	<span id="errcard_type" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Card Holder</div>
	<div class="col-md-8">
	<input type="text" name="card_holder" id="card_holder" class="form-control"value="<?php echo $rsedit['card_holder']; ?>">
	<span id="errcard_holder" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Card Number</div>
	<div class="col-md-8">
	<input type="number" name="card_number" id="card_number" class="form-control"value="<?php echo $rsedit['card_number']; ?>">
	<span id="errcard_number" class="errorclass" ></span>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>CVV Number</div>
	<div class="col-md-8">
	<input type="number" name="cvv_number" id="cvv_number" class="form-control"value="<?php echo $rsedit['cvv_number']; ?>">
	<span id="errcvv_number" class="errorclass" ></span>
	</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Expiry date </div>
	<div class="col-md-8">
	<input type="month" name="expiry_date" id="expiry_date" class="form-control" value="<?php echo $rsedit['expiry_date']; ?>" min="<?php echo date("Y-m"); ?>">
	<span id="errexpiry_date" class="errorclass" ></span>
	</div>
</div>
<br>
		<center><input type="submit" class="btn btn-warning" name="submit"  value="Make Payment" ></center>
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
function calculatebalanceamt(totpay_amt,advpay_amt,balpay_amt)
{
	document.getElementById("balpay_amt").value= parseFloat(document.getElementById("totpay_amt").value) - parseFloat(document.getElementById("advpay_amt").value);
}
</script>
<script>
function validateform()
{
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	var i  = 0;
	if(document.getElementById("card_type").value=="")
	{
		document.getElementById("errcard_type").innerHTML="Kindly select Card Type..";
		i=1;
	}

	if(document.getElementById("card_holder").value=="")
	{
		document.getElementById("errcard_holder").innerHTML="Card Holder should not be empty..";
		i=1;
	}
	if(document.getElementById("card_number").value=="")
	{
		document.getElementById("errcard_number").innerHTML="Card number should not be empty.";
		i=1;
	}
	if(document.getElementById("cvv_number").value=="")
	{
		document.getElementById("errcvv_number").innerHTML="CVV Number should not be empty..";
		i=1;
	}
	if(document.getElementById("expiry_date").value=="")
	{
		document.getElementById("errexpiry_date").innerHTML="Expiry Date should not be empty.";
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