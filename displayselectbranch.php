<?php
include("header.php");
if($_GET['bookingfor'] == "Driving License")
{
	# object oriented
	$from = new DateTime($rscustomer['dob']);
	$to   = new DateTime('today');
	$age = $from->diff($to)->y;
	if($age < 18)
	{
		echo "<script>alert('You cannot apply for driving license..  Driving licence can be made from the age of 18.');</script>";
		echo "<script>window.location='customeraccount.php';</script>";
	}
}
?>

	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">
<?php
if(isset($_GET['branch_id']))
{
?>
<?php
$sqlbranch = "SELECT * FROM branch where branch_id='$_GET[branch_id]'";
$qsqlbranch = mysqli_query($con,$sqlbranch);
$rsbranch = mysqli_fetch_array($qsqlbranch);
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="blog-inner">
			<div class="item-meta">
				<a href="#"><i class="fa fa-address-card"></i> <b><?php echo $rsbranch['branch_name']; ?></b> </a>
			</div>
			<b><?php echo $rsbranch['branch_address']; ?></b><br>
			<b>Contact No. <?php echo $rsbranch['contact_no']; ?></b>
		</div>
	</div>
</div>
<?php
}
else
{
?>
			<div class="row">
				<div class="col-lg-12">
					<div class="title-box">
						<h2>Select Branch</h2>
					</div>
				</div>
			</div>
			<div class="row">
	<?php
	$sqlbranch = "SELECT * FROM branch where status='Active'";
	$qsqlbranch = mysqli_query($con,$sqlbranch);
	while($rsbranch = mysqli_fetch_array($qsqlbranch))
	{
	?>
	<div class="col-lg-4 col-md-6 col-sm-12">
		<div class="blog-inner">
			<div class="item-meta">
				<a href="#"><i class="fa fa-address-card"></i> <b><?php echo $rsbranch['branch_name']; ?></b> </a>
			</div>
			<b><?php echo $rsbranch['branch_address']; ?></b><br>
			<b>Contact No. <?php echo $rsbranch['contact_no']; ?></b><br>
<?php
	if($_GET['bookingfor'] == "Driving Class")
	{
?>
			<a class="new-btn-d br-2" href="displayclasspackage.php?branch_id=<?php echo $rsbranch['branch_id']; ?>">Select Branch <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
<?php
	}
	if($_GET['bookingfor'] == "Driving License")
	{
?>	
			<a class="new-btn-d br-2" href="displaylicensepackage.php?branch_id=<?php echo $rsbranch['branch_id']; ?>">Select Branch <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
<?php
	}
?>		
		</div>
	</div>
	<?php
	}
	?>
			</div>
<?php
}
?>
		</div>
	</div>
	<!-- End Blog -->
	
	<hr>

<?php
include("footer.php");
?>