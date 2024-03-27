<?php
include("header.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['insid']))
	{
		$insid = $_GET['insid'];
	}
	if(isset($_GET['class_id']))
	{
		$insid = $_GET['class_id'];
	}
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE payment set dl_id='$_POST[dl_id]',class_id='$insid',payment_date='$_POST[payment_date]',paid_amt='$_POST[paid_amt]',status='$_POST[status]' WHERE payment_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Payment record updated successfully...');</script>";
			echo "<script>window.location='viewpayment.php';</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
	//Update statement ends here
	else
	{
		$dt = date("Y-m-d");
		if(isset($_SESSION['employee_id']))
		{
			$arr = serialize(array('Offline Payment',$_POST['payment_detail'],$_POST['payment_type']));
		}
		if(isset($_SESSION['customer_id']))
		{
			$arr = serialize(array('Online Payment',$_POST['card_type'],$_POST['card_holder'],$_POST['card_number'],$_POST['cvv_number']));
		}
		$sql = "INSERT INTO payment(dl_id,class_id,payment_date,paid_amt,payment_detail,status) values('0','$insid','$dt','$_POST[advpay_amt]','$arr','Active')";
		$qsql = mysqli_query($con,$sql);
		if(mysqli_affected_rows($con) == 1)
		{
			$inspmtid= mysqli_insert_id($con);
	$sqledit = "SELECT * FROM driving_class WHERE class_id='$insid'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
	$dcstatus = $rsedit['status'];
			//Update driving class starts here			
			$sqlupd ="UPDATE driving_class SET status='Active' WHERE class_id='$_GET[insid]'";
			$qsqlupd = mysqli_query($con,$sqlupd);
			//Update driving class ends here
	if($dcstatus == "Pending")
	{
		
		$sqldriving_class = "SELECT * FROM driving_class WHERE class_id='$_GET[insid]'";
		$qsqldriving_class = mysqli_query($con,$sqldriving_class);
		$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
		
		$sqlcustomer ="SELECT * FROM customer where customer_id='$rsdriving_class[customer_id]'";
		$qsqlcustomer = mysqli_query($con,$sqlcustomer);
		echo mysqli_error($con);
		$rscustomer = mysqli_fetch_array($qsqlcustomer);
		
		$sqlbranch = "SELECT * FROM branch where branch_id='$rsdriving_class[branch_id]'";
		$qsqlbranch =  mysqli_query($con,$sqlbranch);
		$rsbranch = mysqli_fetch_array($qsqlbranch);
		
		$sqlpackage = "SELECT * FROM package where package_id='$rsdriving_class[package_id]'";
		$qsqlpackage =  mysqli_query($con,$sqlpackage);
		$rspackage = mysqli_fetch_array($qsqlpackage);
		
		$sqltime_slots = "SELECT * FROM time_slots where timeslot_id='$rsdriving_class[timeslot_id]'";
		$qsqltime_slots=  mysqli_query($con,$sqltime_slots);
		$rstime_slots = mysqli_fetch_array($qsqltime_slots);
		$bal = $rspackage['package_cost'] - $_POST['advpay_amt'];
		
		$sqlpayment = "SELECT * FROM payment WHERE payment_id='$inspmtid'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$paymenttype= unserialize($rspayment['payment_detail']);
		
		//PHP Mailer Starts here
		$subject = "Driving school Application - 24X7 Driving School";
		$message = "Hello $rscustomer[customer_name],<br>Thanks for applying for Driving School.. The Application details are here..<br> <br>
<table style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Branch</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>
	$rsbranch[branch_name],<br>
	$rsbranch[branch_address],<br>
	Ph. No. $rsbranch[contact_no]
	</td> 
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Package Detail</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>
	<b>Vehicle Type :</b> $rspackage[vehicle_type]<br>
	<b>Package Title :</b> $rspackage[package_title]<br>
	<b>Total KM :</b> $rspackage[total_km]<br>
	<b>No. of Days. :</b> $rspackage[no_of_days]<br>
	</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Start Date</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>" .  date("d-M-Y",strtotime($rsdriving_class['start_date'])) . "<br>
	</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>End Date</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>" .  date("d-M-Y",strtotime($rsdriving_class['end_date'])) . "<br>
	</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Total Cost</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>$rspackage[package_cost]<br>
	</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Advance Payment</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>$_POST[advpay_amt]</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Balance Amount</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>$bal</td>
  </tr>
</table>";
		$message = $message . "
		<br><br><hr>
		<h4>Payment Receipt</h4>
		<br>
	<table  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<td style='border: 1px solid black; border-collapse: collapse;'>
				<b>Bill Date:</b> " . date("d-M-Y",strtotime($rspayment['payment_date'])) . "
				<br><b>Bill no.</b> " . $rspayment['payment_id'] . "
			</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>
				<br><b>Payment Type. - </b> " . $paymenttype[0] . "
				<br><b>Total Amount. </b> Rs." . $rsdriving_class['package_cost']. "</td></tr></table>	<hr>";
$message = $message. "
	<table  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Transaction details</th>
			<th style='border: 1px solid black; border-collapse: collapse;width: 250px;'>Cost</th>
		</tr>
		<tr>
			<td  style='border: 1px solid black; border-collapse: collapse;'>";
$message = $message. "<b>Vehicle Type : </b>";
if($rspackage['vehicle_type'] =="Both")
{
	$message = $message. " Two Wheeler & Four Wheeler";
}
else
{
	$message = $message. " ". $rspackage['vehicle_type'];
}
$message = $message . "<br>";
$message = $message . "<b>Package Title : </b>" . $rspackage['package_title'] . "<br>";
$message = $message . "<b>Total KM : </b>" . $rspackage['total_km'] . "kms<br>";
$message = $message . "<b>Trainer :</b> " . ucfirst($rsdriving_class['employee_name']) . "<br>";

$message = $message .  "<b>Time Slot :</b> ";
//Time Slot starts here
$sqltime_slots = "SELECT * FROM time_slots WHERE employee_id='$rsdriving_class[employee_id]'";
$qsqltime_slots = mysqli_query($con,$sqltime_slots);
$rstime_slots = mysqli_fetch_array($qsqltime_slots);
echo date("h:i A",strtotime($rstime_slots['start_time'])) . " - " . date("h:i A",strtotime($rstime_slots['end_time']));
//Time Slot ends here
$message = $message . "</td>
			<td  style='border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</td>
		</tr>
		<tr>
			<th  style='border: 1px solid black; border-collapse: collapse;'>Total Paid Amount -</th>
			<th  style='border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</th>
		</tr>
	</table>
	<table style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr>
			<th  style='border: 1px solid black; border-collapse: collapse;'><b>Payment Detail :- </b>
			<br><b>Payment Type - </b> $paymenttype[0]
			<br><b>Payment Detail - </b> $paymenttype[1]
			</th>
		</tr>
	</table>";
		include("phpmailer.php");
		sendmail($rscustomer['cust_email'], $rscustomer['customer_name'] , $subject, $message,'');
		//PHP Mailer Ends here
	}
	if($dcstatus == "Active")
	{
		
//###############################################################################################
$sqlpayment = "SELECT * FROM payment WHERE payment_id='$inspmtid'";
$qsqlpayment = mysqli_query($con,$sqlpayment);
$rspayment = mysqli_fetch_array($qsqlpayment);
$paymenttype= unserialize($rspayment['payment_detail']);
$sqlpaymentsum = "SELECT SUM(paid_amt) FROM payment WHERE class_id='$rspayment[class_id]'";
$qsqlpaymentsum = mysqli_query($con,$sqlpaymentsum);
$rspaymentsum = mysqli_fetch_array($qsqlpaymentsum);
$sqldriving_class = "SELECT driving_class.*,customer.customer_name,customer.customer_id,branch.branch_name,employee.employee_name,package.vehicle_type, time_slots.start_time FROM driving_class LEFT JOIN customer on driving_class.customer_id=customer.customer_id LEFT JOIN branch ON branch.branch_id=driving_class.branch_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id LEFT JOIN package ON package.package_id=driving_class.package_id LEFT JOIN time_slots ON time_slots.timeslot_id=driving_class.timeslot_id WHERE driving_class.class_id='$rspayment[class_id]'";
$qsqldriving_class = mysqli_query($con,$sqldriving_class);
echo mysqli_error($con);
$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
//driving class package starts here
$sqlpackage = "SELECT package.*,branch.* FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_id='$rsdriving_class[package_id]'";
$qsqlpackage = mysqli_query($con,$sqlpackage);
$rspackage = mysqli_fetch_array($qsqlpackage);
//driving class package ends here		
//###############################################################################################
		//##################
		$sqlcustomer ="SELECT * FROM customer where customer_id='$rsdriving_class[customer_id]'";
		$qsqlcustomer = mysqli_query($con,$sqlcustomer);
		echo mysqli_error($con);
		$rscustomer = mysqli_fetch_array($qsqlcustomer);
		//##################
		$sqlbranch = "SELECT * FROM branch where branch_id='$rsdriving_class[branch_id]'";
		$qsqlbranch =  mysqli_query($con,$sqlbranch);
		$rsbranch = mysqli_fetch_array($qsqlbranch);
		//##################
		$sqltime_slots = "SELECT * FROM time_slots where timeslot_id='$rsdriving_class[timeslot_id]'";
		$qsqltime_slots=  mysqli_query($con,$sqltime_slots);
		$rstime_slots = mysqli_fetch_array($qsqltime_slots);
		$bal = $rspackage['package_cost'] - $rspaymentsum[0];	
		//##################
		//PHP Mailer Starts here
		$subject = "Driving school Application - 24X7 Driving School";
		$message = "Hello $rscustomer[customer_name],<br>Thanks for the Payment.. Here is the detail..<br> <br>
		<table style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		  <tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Branch</th>
			<td style='border: 1px solid black; border-collapse: collapse;'>
			$rsbranch[branch_name],<br>
			$rsbranch[branch_address],<br>
			Ph. No. $rsbranch[contact_no]
			</td> 
		  </tr>
		  <tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Package Detail</th>
			<td style='border: 1px solid black; border-collapse: collapse;'>
			<b>Vehicle Type :</b> $rspackage[vehicle_type]<br>
			<b>Package Title :</b> $rspackage[package_title]<br>
			<b>Total KM :</b> $rspackage[total_km]<br>
			<b>No. of Days. :</b> $rspackage[no_of_days]<br>
			</td>
		  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>Start Date</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>" .  date("d-M-Y",strtotime($rsdriving_class['start_date'])) . "<br>
	</td>
  </tr>
  <tr style='border: 1px solid black; border-collapse: collapse;'>
    <th style='border: 1px solid black; border-collapse: collapse;'>End Date</th>
    <td style='border: 1px solid black; border-collapse: collapse;'>" .  date("d-M-Y",strtotime($rsdriving_class['end_date'])) . "<br>
	</td>
  </tr>
		  <tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Total Cost</th>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rspackage[package_cost]<br>
			</td>
		  </tr>
		  <tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Total Paid Amount</th>
			<td style='border: 1px solid black; border-collapse: collapse;'>$rspaymentsum[0]</td>
		  </tr>
		  <tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Balance Amount</th>
			<td style='border: 1px solid black; border-collapse: collapse;'>$bal</td>
		  </tr>
		</table>";
		$message = $message . "
		<br><br><hr>
		<h4>Payment Receipt</h4>
		<br>
	<table  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<td style='border: 1px solid black; border-collapse: collapse;'>
				<b>Bill Date:</b> " . date("d-M-Y",strtotime($rspayment['payment_date'])) . "
				<br><b>Bill no.</b> " . $rspayment['payment_id'] . "
			</td>
			<td style='border: 1px solid black; border-collapse: collapse;'>
				<br><b>Payment Type. - </b> " . $paymenttype[0] . "
				<br><b>Total Amount. </b> Rs." . $rsdriving_class['package_cost']. "</td></tr></table>	<hr>";
$message = $message. "
	<table  style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr style='border: 1px solid black; border-collapse: collapse;'>
			<th style='border: 1px solid black; border-collapse: collapse;'>Transaction details</th>
			<th style='border: 1px solid black; border-collapse: collapse;width: 250px;'>Cost</th>
		</tr>
		<tr>
			<td  style='border: 1px solid black; border-collapse: collapse;'>";
$message = $message. "<b>Vehicle Type : </b>";
if($rspackage['vehicle_type'] =="Both")
{
	$message = $message. " Two Wheeler & Four Wheeler";
}
else
{
	$message = $message. " ". $rspackage['vehicle_type'];
}
$message = $message . "<br>";
$message = $message . "<b>Package Title : </b>" . $rspackage['package_title'] . "<br>";
$message = $message . "<b>Total KM : </b>" . $rspackage['total_km'] . "kms<br>";
$message = $message . "<b>Trainer :</b> " . ucfirst($rsdriving_class['employee_name']) . "<br>";

$message = $message .  "<b>Time Slot :</b> ";
//Time Slot starts here
$sqltime_slots = "SELECT * FROM time_slots WHERE employee_id='$rsdriving_class[employee_id]'";
$qsqltime_slots = mysqli_query($con,$sqltime_slots);
$rstime_slots = mysqli_fetch_array($qsqltime_slots);
echo date("h:i A",strtotime($rstime_slots['start_time'])) . " - " . date("h:i A",strtotime($rstime_slots['end_time']));
//Time Slot ends here
$message = $message . "</td>
			<td  style='border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</td>
		</tr>
		<tr>
			<th  style='border: 1px solid black; border-collapse: collapse;'>Total Paid Amount -</th>
			<th  style='border: 1px solid black; border-collapse: collapse;'>Rs. $rspayment[paid_amt]</th>
		</tr>
	</table>
	<table style='border: 1px solid black; border-collapse: collapse;width: 100%;'>
		<tr>
			<th  style='border: 1px solid black; border-collapse: collapse;'><b>Payment Detail :- </b>
			<br><b>Payment Type - </b> $paymenttype[0]
			<br><b>Payment Detail - </b> $paymenttype[1]
			</th>
		</tr>
	</table>";
		include("phpmailer.php");
		sendmail($rscustomer['cust_email'], $rscustomer['customer_name'] , $subject, $message,'');
		//PHP Mailer Ends here
	}
			echo "<script>alert('Driving class Payment done successfully...');</script>";
			echo "<script>window.location='drivingclassreceipt.php?insid=$inspmtid';</script>";
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
	$sqledit = "SELECT * FROM payment WHERE payment_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>
<?php
if(isset($_GET['insid']))
{
	$sqldriving_class = "SELECT * FROM driving_class WHERE class_id='$_GET[insid]'";
	$qsqldriving_class = mysqli_query($con,$sqldriving_class);
	$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
}
?>
<?php
if(isset($_GET['class_id']))
{
	$sqldriving_class = "SELECT * FROM driving_class WHERE class_id='$_GET[class_id]'";
	$qsqldriving_class = mysqli_query($con,$sqldriving_class);
	$rsdriving_class = mysqli_fetch_array($qsqldriving_class);
}
?>
<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform()" >
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
	<span id="errtotpay_amt" class="errorclass" ></span>
	</div>
</div>
<?php
	$sql = "SELECT payment.*,driving_class.*,employee.*,branch.branch_name FROM payment LEFT JOIN driving_class ON payment.class_id=driving_class.class_id LEFT JOIN  driving_license ON driving_license.dl_id=payment.dl_id LEFT JOIN employee ON employee.employee_id=driving_class.employee_id  LEFT JOIN branch ON branch.branch_id=driving_class.branch_id where payment.status='Active' ";
	if(isset($_GET['class_id']))
	{
		$sql  = $sql . " AND payment.class_id='$_GET[class_id]'";
	}
	if(isset($_GET['insid']))
	{
		$sql  = $sql . " AND payment.class_id='$_GET[insid]'";
	}
	if(isset($_SESSION['customer_id']))
	{
		if($_GET['bookingfor'] == "Driving License")
		{
		$sql = $sql . " and driving_license.customer_id='$_SESSION[customer_id]'";
		}
		if($_GET['bookingfor'] == "Driving Class")
		{
		$sql = $sql . " and driving_class.customer_id='$_SESSION[customer_id]'";
		}
	}
	//echo $sql;
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) >= 1)
	{
		if(isset($_GET['class_id']))
		{
			$sqlpayment = "SELECT SUM(paid_amt) as paid_amt FROM payment WHERE class_id='$_GET[class_id]'";
			$qsqlpayment = mysqli_query($con,$sqlpayment);
			$rspayment = mysqli_fetch_array($qsqlpayment);
			$balamt = $rs['package_cost'] - $rspayment['paid_amt'];
		}
?>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Paid Amount</div>
	<div class="col-md-8">
	<input type="number" name="paidamt" id="paidamt" class="form-control" readonly value="<?php echo $rspayment['paid_amt']; ?>" >
	<span id="errpaidamt" class="errorclass" ></span>
	</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Remaining Balance</div>
	<div class="col-md-8">
	<input type="number" name="remainingbalance" id="remainingbalance" class="form-control" readonly value="<?php echo $rembalamt = $rsdriving_class['package_cost'] - $rspayment['paid_amt']; ?>" >
	<span id="errremainingbalance" class="errorclass" ></span>
	</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Payable Amount</div>
	<div class="col-md-8">
	<input type="number" name="advpay_amt" id="advpay_amt" class="form-control" onchange="calculatebalanceamt(remainingbalance.value,advpay_amt.value,balpay_amt.value)" onkeyup="calculatebalanceamt(remainingbalance.value,advpay_amt.value,balpay_amt.value)"  >
	<span id="erradvpay_amt" class="errorclass" ></span>
	</div>
</div>
<?php
	}
	else
	{
?>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Payable Amount</div>
	<div class="col-md-8">
	<input type="number" name="advpay_amt" id="advpay_amt" class="form-control" onchange="calculatebalanceamt(totpay_amt.value,advpay_amt.value,balpay_amt.value)" onkeyup="calculatebalanceamt(totpay_amt.value,advpay_amt.value,balpay_amt.value)"  >
	<span id="erradvpay_amt" class="errorclass" ></span>
	</div>
</div>
<?php
	}
?>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Balance amount</div>
	<div class="col-md-8">
	<input type="text" name="balpay_amt" id="balpay_amt" class="form-control" value="<?php 
	if(mysqli_num_rows($qsql) >= 1)
	{
	echo $rembalamt;
	}
	else
	{
	echo $rsdriving_class['package_cost'];
	}
	?>"  readonly>
	<span id="errbalpay_amt" class="errorclass" ></span>
	</div>
</div>

<?php
if(isset($_SESSION['employee_id']))
{
?>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Payment Type </div>
	<div class="col-md-8">
	<select name="payment_type" id="payment_type" class="form-control">
		<option value="">Select card type</option>
		<?php
		$arr = array("Cash Payment","Online payment","Card Payment");
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
	<span id="errpayment_type" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Payment detail </div>
	<div class="col-md-8">
	<textarea class="form-control" name="payment_detail" id="payment_detail"></textarea>
	<span id="errpayment_detail" class="errorclass" ></span>
	</div>
</div>
<hr>
<?php
}
else
{
?>
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
<?php
}
?>
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
	document.getElementById("balpay_amt").value= parseFloat(totpay_amt) - parseFloat(advpay_amt);
}
</script>
<?php
if(isset($_SESSION['employee_id']))
{
?>
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("advpay_amt").value=="")
	{
		document.getElementById("erradvpay_amt").innerHTML="Advance Payment Amount Should not be empty..";
		i=1;
	}
	if(document.getElementById("payment_type").value=="")
	{
		document.getElementById("errpayment_type").innerHTML="Payment type should not be empty.";
		i=1;
	}
	
	if(document.getElementById("payment_detail").value=="")
	{
		document.getElementById("errpayment_detail").innerHTML="Payment detail  should not be empty.";
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
<?php
}
else
{
?>
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	/*
	if(document.getElementById("remainingbalance").value=="")
	{
		document.getElementById("errremainingbalance").innerHTML="Remaining balance should not be empty.";
		i=1;
	}
	*/
	if(document.getElementById("advpay_amt").value=="")
	{
		document.getElementById("erradvpay_amt").innerHTML="Advance Payment Amount Should not be empty..";
		i=1;
	}
		
	/*
	if(document.getElementById("balpay_amt").value=="")
	{
		document.getElementById("errbalpay_amt").innerHTML="Balance Payment Amount should not be empty.";
		i=1;
	}
	if(document.getElementById("payment_type").value=="")
	{
		document.getElementById("errpayment_type").innerHTML="Payment type should not be empty.";
		i=1;
	}
	
	if(document.getElementById("payment_detail").value=="")
	{
		document.getElementById("errpayment_detail").innerHTML="Payment detail  should not be empty.";
		i=1;
	}
	*/
	if(document.getElementById("card_type").value=="")
	{
		document.getElementById("errcard_type").innerHTML="Card Type should not be empty.";
		i=1;
	}
	                       	
	if(document.getElementById("card_holder").value=="")
	{
		document.getElementById("errcard_holder").innerHTML="Kindly enter Card Holder.";
		i=1;
	}
	if(document.getElementById("card_number").value=="")
	{
		document.getElementById("errcard_number").innerHTML="Card number should not be empty..";
		i=1;
	}
	if(document.getElementById("cvv_number").value=="")
	{
		document.getElementById("errcvv_number").innerHTML="CVV number should not be empty.";
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
<?php
}
?>