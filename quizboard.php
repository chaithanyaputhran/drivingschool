<?php
include("header.php");
unset($_SESSION['quiztopicid']);
unset($_SESSION['dttim']);
if(isset($_POST['submit']))
{
	$_SESSION['quiztopicid'] = rand();
	$_SESSION['dttim'] = $dttim;
	$sqlqz ="SELECT * FROM questions WHERE status='Active' ORDER BY RAND() LIMIT 25";
	$qsqlqz  = mysqli_query($con,$sqlqz);
	while($rsqz = mysqli_fetch_array($qsqlqz))
	{
		$sql ="INSERT INTO examination(customer_id, attend_date, qstn_id, correctanswer, selectedanswer, marksperquestion, negativemarks) values('$_SESSION[customer_id]','$_SESSION[dttim]','$rsqz[qstn_id]','$rsqz[ans]','','1','1')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
	}
	$_SESSION["timeleft"]=25 * 60;
	echo "<script>window.location='quizpanel.php';</script>";
}
if(isset($_GET['quiztopicid']))
{
	$sqledit = "SELECT * FROM quiztopic where quiztopicid='$_GET[quiztopicid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
	//######		
	$sqlstudent = "SELECT * FROM student WHERE studentid='$rsedit[studentid]'";
	$qsqlstudent = mysqli_query($con,$sqlstudent);
	$rsstudent = mysqli_fetch_array($qsqlstudent);
	//######
	//######		
	$sqladmin = "SELECT * FROM admin WHERE adminid='$rsedit[adminid]'";
	$qsqladmin = mysqli_query($con,$sqladmin);
	$rsadmin = mysqli_fetch_array($qsqladmin);
	//######
}
if(isset($_GET['quizid']))
{
	$sqlquestionedit = "SELECT * FROM  quiz where quizid='$_GET[quizid]'";
	$qquestionedit = mysqli_query($con,$sqlquestionedit);
	$rsquestionedit = mysqli_fetch_array($qquestionedit);
}
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
$_SESSION["timeleft"] = "1800";
?>
<style>
.serviceBox {
    text-align: left;
}
</style>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform()">
	<!-- Start Services -->
	<div id="services" class="services-box">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					
<div class="item">
	<div class="serviceBox">
		<p class="description">

<form method="post" action="" onsubmit="return confirmvalidation()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Practice Test</h3>
        </div>
        <div class="card-body">
		
<?php
//if(isset($_GET['quiztopicid']))
{
?>

<div class="row">
	<div class="col-md-12">
<table class="table table-bordered">
	<tr>
		<td colspan="2"><b>Test Detail:</b><br>
		- The test contains 25 questions and there is 30 minutes time limit.. .<br>- The test is not official, it's just a nice way to see how much you know, or don't know, about Traffic Signs and Rules and regulations.<br>- At the end of the Quiz, your total score will be displayed. Maximum score is 25 points.
		</td>
	</tr>
	<tr>
		<th>Points per Question:</th><td>1</td>
	</tr>
	<tr>
		<th>Negative points per question:</th><td>1</td>
	</tr>
	<tr>
		<th>Time Duration:</th><td>30 Minutes</td>
	</tr>
</table>
	</div>
</div>
<?php
}
?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

<div class="row">
		<div class="col-md-12">
<center><input class="btn btn-warning"  type="submit" name="submit" id="submit" value="Click here to Start.."></center>
		</div>
</div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
</form>

		</p>
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