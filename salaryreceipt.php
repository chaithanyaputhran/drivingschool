<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
$sqledit = "SELECT salary.*,employee.employee_name, employee.gender, employee.address, employee.contact_no, branch.branch_name FROM salary LEFT JOIN employee ON salary.emp_id=employee.employee_id LEFT JOIN branch ON branch.branch_id=employee.branch_id WHERE salary.sal_id='$_GET[receiptid]'";
$qsqledit = mysqli_query($con,$sqledit);
$rssalary = mysqli_fetch_array($qsqledit);
?>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
<div class="item">
	<div class="serviceBox" id="divprint">
		<img src="images/logo.png"><br>
		Abby Complex, 1st Floor, Kulshekar,<br>
Mangalore, Karnataka 575005
		<h3 class="title">Salary Receipt</h3>
		<p class="description">

<div class="row">
	<div class="col-md-12">
	<hr>
<table style="width: 100%;" class="table table-bordered">
	<tr>
		<td style='text-align: left;width: 50%;'>
<?php
echo "<b>". $rssalary['employee_name'] ."</b><br>";
echo $rssalary['address'] ."<br>";
echo "Ph. No. ". $rssalary['contact_no'] ."<br>";
?>		
		</td>
		<td style='text-align: right;width: 50%;'>
<?php
echo "<b>"."Receipt No. " . $rssalary['0']."</b>" ."<br>";
echo "<b>Branch - </b>" . $rssalary['branch_name'] ."<br>";
echo "<b>Salary Date</b> -  ". $rssalary['sal_date'] ."<br>";
?>
		</td>
	</tr>
</table>	
<table style="width: 100%;" class="table table-bordered">
	<tr>
		<th style='text-align: left;width: 50%;' colspan="2"><center>Earnings</center></th>
		<th style='text-align: left;width: 50%;' colspan="2"><center>Deductions</center></th>
	</tr>	
	<tr>
		<th style='text-align: left;width: 30%;'>Basic Salary</th>
		<td style='text-align: right;width: 20%;'>Rs. <?php echo $rssalary['basic_sal']; ?></td>
		<th style='text-align: left;width: 30%;'>Deductions</th>
		<td style='text-align: right;width: 20%;'>Rs. <?php echo $rssalary['deduction']; ?></td>
	</tr>
	<tr>
		<th style='text-align: left;width: 30%;'>Bonus</th>
		<td style='text-align: right;width: 20%;'>Rs. <?php echo $rssalary['bonus']; ?></td>
		<th style='text-align: left;width: 30%;'></th>
		<td style='text-align: left;width: 20%;'></td>
	</tr>
	<tr>
		<th style='text-align: center;width: 30%;'  colspan="4">Net Salary - <?php echo ($rssalary['basic_sal'] + $rssalary['bonus']) - $rssalary['deduction']; ?></th>
	</tr>
</table>	
	</div>
</div>

		</p>
	</div>
	<hr>
		<center><input type="button" class="btn btn-warning" name="submit"  value="Print Salary Receipt" onclick="printreceipt('divprint')" ></center>
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
function printreceipt(divName)
{
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
