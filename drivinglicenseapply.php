<?php
include("header.php");
if(!isset($_SESSION['customer_id']))
{
	echo "<script>window.location='index.php';</script>";
}
if(isset($_POST['submit']))
{
	$photo_proof = rand(). $_FILES['photo_proof']['name'];
	move_uploaded_file($_FILES['photo_proof']['tmp_name'],"imgdrvlic/".$photo_proof);
	
	$id_proof = rand(). $_FILES['id_proof']['name'];
	move_uploaded_file($_FILES['id_proof']['tmp_name'],"imgdrvlic/".$id_proof);
	
	$address_proof = rand(). $_FILES['address_proof']['name'];
	move_uploaded_file($_FILES['address_proof']['tmp_name'],"imgdrvlic/".$address_proof);
	
	if(isset($_GET['editid']))
	{
		//Update statement starts here
		$sql = "UPDATE driving_class set customer_id='$_POST[customer_id]',branch_id='$_POST[branch_id]',employee_id='$_POST[employee_id]',vehicle_type='$_POST[vehicle_type]',
		package_id='$_POST[package_id]',package_cost='$_POST[package_cost]',start_date='$_POST[start_date]',timeslot_id='$_POST[timeslot_id]',note='$_POST[note]',status='$_POST[status]'WHERE class_id='$_GET[editid]'";		
		$qsql = mysqli_query($con,$sql);
			echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Drivingclass record updated successfully...');</script>";
			echo "<script>window.location='viewdrivingclass.php';</script>";
		}
		//Update statement ends here
	}
	else
	{
		$sqlpackage = "SELECT package.*,branch.branch_name FROM package LEFT JOIN branch on package.branch_id=branch.branch_id WHERE package.package_type='Driving License' AND package.package_id='$_GET[package_id]'";
		$qsqlpackage = mysqli_query($con,$sqlpackage);
		$rspackage = mysqli_fetch_array($qsqlpackage);
		$sql = "INSERT INTO  driving_license(customer_id, reg_date,package_id,branch_id, vehicle_type,package_cost	,photo_proof,id_proof,address_proof,note,status) values('$_SESSION[customer_id]','$_POST[start_date]','$rspackage[package_id]','$_GET[branch_id]','$rspackage[vehicle_type]','$rspackage[package_cost]','$photo_proof','$id_proof','$address_proof','$_POST[note]','Pending')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			$insid = mysqli_insert_id($con);
			echo "<script>alert('Driving License application submission under process...');</script>";
			echo "<script>window.location='drivinglicensepayment.php?insid=$insid';</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM driving_class WHERE package_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	echo mysqli_error($con);
	$rsedit = mysqli_fetch_array($qsqledit);
}
?>

<style>
.serviceBox {
    text-align: left;
}
</style>
	<!-- Start About us -->
	<div id="about" class="about-box" style="background-color: brown; ">
		<div class="about-a1">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="title-box">
							<h2 style="color: white;">Driving License Application Form</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End About us -->
			<div class="row">
				<div class="col-lg-12">
					<div class="">
					
					
<?php
$sqlpackage = "SELECT * FROM `package` where package_type='Driving Class' AND branch_id='$_GET[branch_id]' AND package_id='$_GET[package_id]'";
$qsqlpackage = mysqli_query($con,$sqlpackage);
while($rspackage = mysqli_fetch_array($qsqlpackage))
{
?>
<div class="item">
	<div class="serviceBox">
		<div class="service-icon">
		<?php
		if($rspackage['vehicle_type'] == "Two Wheeler")
		{
		?>
		<i class="fa fa-motorcycle" aria-hidden="true"></i>
		<?php
		}
		if($rspackage['vehicle_type']== "Four Wheeler")
		{
		?>
		<i class="fa fa-car" aria-hidden="true"></i>
		<?php
		}
		if($rspackage['vehicle_type']== "Both")
		{
		?>
		<i class="fa fa-motorcycle" aria-hidden="true"></i><i class="fa fa-car" aria-hidden="true"></i>
		<?php
		}
		?>
		</div>
		<h3 class="title"><?php echo $rspackage['package_title']; ?></h3>
		<p class="description">			
			<b>Vehile Type:</b> <?php echo $rspackage['vehicle_type']; ?> | <b>Total KM:</b> <?php echo $rspackage['total_km']; ?>km<br>
			
			<?php echo $rspackage['note']; ?>
			<hr>
			<b>Cost - ₹<?php echo $rspackage['package_cost']; ?></b>
			
		</p>
	</div>
</div>
<?php
}
?>
					</div>
				</div>
			</div>	

<form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform()" >
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<h3 class="title">Driving License</h3>
		<p class="description">



<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Applying Date</div>
	<div class="col-md-8">
	<input type="date" name="start_date" id="start_date" class="form-control"  value="<?php 
$date = date("Y-m-d");
echo $start_date = date('Y-m-d', strtotime($date . ' +7 day'));
	?>" min="<?php 
$date = date("Y-m-d");
echo $start_date = date('Y-m-d', strtotime($date . ' +7 day'));
	?>" >
	<span id="errstart_date" class="errorclass" ></span>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Photo Proof </div>
	<div class="col-md-8">
<input type="file" name="photo_proof" id="photo_proof" class="form-control" >
	<span id="errphoto_proof" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>ID Proof</div>
	<div class="col-md-8">
<input type="file" name="id_proof" id="id_proof" class="form-control" >
	<span id="errid_proof" class="errorclass" ></span>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Address Proof</div>
	<div class="col-md-8">
<input type="file" name="address_proof" id="address_proof" class="form-control" >
	<span id="erraddress_proof" class="errorclass" ></span>
	</div>
</div>

<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Any Note?</div>
	<div class="col-md-8">
	<textarea name="note" id="note" class="form-control"><?php echo $rsedit['note']; ?></textarea>
	<span id="errnote" class="errorclass" ></span>
	</div>
</div>


		</p>
		<center><input type="submit" class="btn btn-warning" name="submit"  value="Submit" ></center>
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
function loadtimeslots(empid) 
{
    if(empid == "") 
	{
        document.getElementById("divtimeslot").innerHTML = "<select name='timeslot_id' id='timeslot_id' class='form-control' ><option value=''>Select Time slot</option></select>";
        return;
    } 
	else
	{
        if(window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("divtimeslot").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxtimeslot.php?empid="+empid,true);
        xmlhttp.send();
    }
}
</script>
<script>
function validateform()
{
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("start_date").value=="")
	{
		document.getElementById("errstart_date").innerHTML="Start date should not be empty..";
		i=1;
	}
	if(document.getElementById("photo_proof").value=="")
	{
		document.getElementById("errphoto_proof").innerHTML="Kindly upload Photo.";
		i=1;
	}
	if(document.getElementById("id_proof").value=="")
	{
		document.getElementById("errid_proof").innerHTML="Kindly upload ID proof.";
		i=1;
	}
	if(document.getElementById("address_proof").value=="")
	{
		document.getElementById("erraddress_proof").innerHTML="Kindly upload address proof..";
		i=1;
	}  
	if(document.getElementById("note").value=="")
	{
		document.getElementById("errnote").innerHTML="Note should not be empty.";
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