<?php
include("header.php");
if(!isset($_SESSION['employee_id']))
{
	echo "<script>window.location='index.php';</script>";
}
?>

	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="title-box">
						<h2>DASHBOARD</h2>						
					</div>
				</div>
			</div>
			<div class="row">
		
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/attendance.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Attendance Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM attendance";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

			
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/branch.png"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Branch Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM branch";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/customer.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Customer Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM customer";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>
	

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/drivingclass.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Class Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM driving_class";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>


<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/drivinglicense.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving License Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM driving_license";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>
				
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/employee.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving employee Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM employee";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/examination.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Examination Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM examination";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>


<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/invoice.png"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Invoice Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM payment";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/packages.png"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Package Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM package";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/payment.png"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Payment Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM payment";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/questions.png"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Questions Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM questions";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/salary.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Salary Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM salary";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/timeschedule.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Time Schedule Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM time_slots";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>


<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/timeslots.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving TimeSlot Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM time_slots";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="blog-inner">
		<div class="blog-img">
			<img class="img-fluid" src="images/vehicle.jpg"  style="width: 350px; height: 250px;"/>
		</div>
		<div class="item-meta">
			<a href="#"><i class="fa fa-comments-o"></i> Driving Vehicle Records </a><br>
			<span class="dti" style="width: 100px;">
			<?php
			$sql = "SELECT * FROM vehicle";
			$qsql = mysqli_query($con,$sql);
			echo mysqli_num_rows($qsql);
			?>
			</span>
		</div>
	</div>
</div>
		</div>
		</div>
	</div>
	<!-- End Blog -->
	



<?php
include("footer.php");
?>