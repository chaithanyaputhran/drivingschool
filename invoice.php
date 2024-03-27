<?php
include("header.php");
if(isset($_POST['submit']))
{
	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE invoice set class_id='$_POST[class_id]',dl_id='$_POST[dl_id]',invoice_date='$_POST[invoice_date]',customer_id='$_POST[customer_id]',package_cost='$_POST[package_cost]',status='$_POST[status]'WHERE invoice_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('invoice record updated successfully...');</script>";
			echo "<script>window.location='viewinvoice.php';</script>";
		}
	}
	//UPdate statement ends here
	else
	{
		$sql = "INSERT INTO invoice(class_id,dl_id,invoice_date,customer_id,package_cost,status) values('$_POST[class_id]','$_POST[dl_id]','$_POST[invoice_date]','$_POST[customer_id]','$_POST[package_cost]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Invoice record inserted successfully...');</script>";
			echo "<script>window.location='invoice.php';</script>";
		}
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM invoice WHERE invoice_id='$_GET[editid]'";
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
		<h3 class="title">Invoice</h3>
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
	<div class="col-md-4" style="padding-top: 7px;"	>Invoice Date</div>
	<div class="col-md-8">
	<input type="date" name="invoice_date" id="invoice_date" class="form-control"value="<?php echo $rsedit['invoice_date']; ?>"><span id="errinvoice_date" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Customer </div>
	<div class="col-md-8">
	<select name="customer_id" id="customer_id" class="form-control">
	<option value="">Select customer</option>
	<?php
	$sqlcustomer = "SELECT * FROM customer where status='Active'";
	$qsqlcustomer=  mysqli_query($con,$sqlcustomer);
	while($rscustomer= mysqli_fetch_array($qsqlcustomer))
	{
		if($rscustomer['customer_id'] == $rsedit['customer_id'])
		{
		echo "<option value='$rscustomer[customer_id]' selected>$rscustomer[customer_name]</option>";
		}
		else
		{
		echo "<option value='$rscustomer[customer_id]'>$rscustomer[customer_name]</option>";
		}
	}
	?>
	</select><span id="errcustomer_id" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Package Cost</div>
	<div class="col-md-8">

<input type="text" name="package_cost" id="package_cost" class="form-control"value="<?php echo $rsedit['package_cost']; ?>"><span id="errpackage_cost" class="errorclass" ></span>
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
		document.getElementById("errdl_id").innerHTML="dl id should not be empty..";
		i=1;
	}
	if(document.getElementById("class_id").value=="")
	{
		document.getElementById("errclass_id").innerHTML="class id should not be empty..";
		i=1;
	}
	
	if(document.getElementById("invoice_date").value=="")
	{
		document.getElementById("errinvoice_date").innerHTML="invoice date should not be empty..";
		i=1;
	}
	if(document.getElementById("customer_id").value=="")
	{
		document.getElementById("errcustomer_id").innerHTML="customer id should not be empty..";
		i=1;
	}
	if(document.getElementById("package_cost").value=="")
	{
		document.getElementById("errpackage_cost").innerHTML="Package cost should not be empty..";
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