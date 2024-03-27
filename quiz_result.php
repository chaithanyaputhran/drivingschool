<?php
include("header.php");
include("sidebar.php");
unset($_SESSION['quiztopicid']);
unset($_SESSION['dttim']);
unset($_SESSION['timeleft']);
if(isset($_GET['dttim']))
{
	$sqlquestionedit = "SELECT * FROM  examination where attend_date='$_GET[dttim]'";
	$qquestionedit = mysqli_query($con,$sqlquestionedit);
	$rsquestionedit = mysqli_fetch_array($qquestionedit);
	$sqlcustomer ="SELECT * FROM customer where customer_id='$rsquestionedit[customer_id]'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	echo mysqli_error($con);
	$rscustomer = mysqli_fetch_array($qsqlcustomer);
}
?>
<style>
.answercomment {
    background-color: rgba(0, 0, 0, 0.2);
    color: white;
    white-space: nowrap;
    position: absolute;
    right: 10px;
    top: 10px;
}
</style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

<br>
       <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Test Result</h3>
        </div>
        <div class="card-body">
	
<div class="row">
	<div class="col-md-12">
<table class="table table-bordered">

	<tr>
		<th style="width: 250px;">Customer Name:</th><td><?php echo $rscustomer['customer_name']; ?></td>
	</tr>	
	<tr>
		<th>Email ID.:</th><td><?php echo $rscustomer['cust_email']; ?></td>
	</tr>
	<tr>
		<th>Mobile No.:</th><td><?php echo $rscustomer['cust_mob']; ?></td>
	</tr>
	<tr>
		<th>Test Date.:</th><td><?php
$gdttim =$_GET['dttim'];
		echo date("d-M-Y h:i A",strtotime($gdttim)); ?></td>
	</tr>
</table>
	</div>
</div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</form>
    </section>
    <!-- /.content -->
	
<?php
//if(isset($_GET['quiztopicid']))
{
?>
	
    <!-- Main content -->
    <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation2()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">View Quiz Question and Answers</h3>
        </div>
        <div class="card-body">
	
<table id="tblquestionviewer"  class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th style="height: 0px;">
			</th>
		</tr>
	</thead>
	<tbody>
<?php
$sqlqz ="SELECT examination.*, questions.qstn as question, questions.opt1 as option1, questions.opt2 as option2, questions.opt3 as option3, questions.opt4 as option4, questions.img, questions.dsptn, examination.selectedanswer FROM `examination` LEFT JOIN questions ON examination.qstn_id=questions.qstn_id WHERE examination.attend_date='$_GET[dttim]' AND examination.customer_id='$rscustomer[customer_id]' ORDER BY examination.examinationid ASC";
$qsqlqz  = mysqli_query($con,$sqlqz);
$qno=1;
while($rsqz = mysqli_fetch_array($qsqlqz))
{
?>
	<tr>
		<td>
		
<input type="hidden" name="edquizid" id="edquizid" value="<?php echo $rsqz['0']; ?>">
		
		<table style='width: 100%;'>
			<tr>
				<td>
				
				<b>Question No. <?php echo $qno; ?>: </b>
				<?php
				$mark=0;
				if($rsqz['correctanswer'] ==  $rsqz['selectedanswer'] )
				{
				echo "<i class='fa fa-check' style='color: green'> Correct Answer</i>";
				$mark= $rsqz['marksperquestion'];
				}
				if($rsqz['correctanswer'] !=  $rsqz['selectedanswer'] )
				{
				echo "<i class='fa fa-times' style='color: red'> Wrong Answer</i>";
				$mark= $rsqz['negativemarks'];
				$mark = $mark <= 0 ? $mark : -$mark ;
				}
				?>
				
				<br>
				<?php echo $rsqz['question']; ?>			
				</td>
			</tr>			

<?php
if(file_exists("imgquestion/".$rsqz['img']))
	{
?>
			<tr>
				<td>
<img src="imgquestion/<?php echo $rsqz['img']; ?>" style='height: 200px;'>
				</td>
			</tr>
<?php
	}
?>			
				
			<tr>
				<td>
					<b>Option 1:</b> <?php echo $rsqz['option1']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Option 2:</b> <?php echo $rsqz['option2']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Option 3:</b> <?php echo $rsqz['option3']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Option 4:</b> <?php echo $rsqz['option4']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Correction Option:</b> <?php echo $rsqz['correctanswer']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Your answer:</b> <?php 
					if($rsqz['selectedanswer'] == "")
					{
					echo "Unanswered";
					}
					else
					{
					echo $rsqz['selectedanswer'];
					}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Marks:</b> <?php echo $mark; ?>
				</td>
			</tr>
		</table>


		</td>
	</tr>
<?php
$qno = $qno +1;
}
?>
	</tbody>
</table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</form>
    </section>
    <!-- /.content -->
<?php
}
?>	



       <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Test Result</h3>
        </div>
        <div class="card-body">

<div class="row">
	<div class="col-md-12">
<table class="table table-bordered">

	<tr>
		<th style="width: 250px;">Total Questions:</th><td><?php echo mysqli_num_rows($qsqlqz); ?></td>
	</tr>
	<tr>
		<th>Answered Questions:</th><td><?php 
$sqlqz ="SELECT * FROM examination WHERE attend_date='$_GET[dttim]' AND customer_id='$rscustomer[customer_id]' and selectedanswer != ''";
$qsqlqz  = mysqli_query($con,$sqlqz);
echo mysqli_num_rows($qsqlqz);
		?></td>
	</tr>
	<tr>
		<th>UnAnswered Questions:</th><td><?php 
$sqlqz ="SELECT * FROM examination WHERE attend_date='$_GET[dttim]' AND customer_id='$rscustomer[customer_id]' and selectedanswer = ''";
$qsqlqz  = mysqli_query($con,$sqlqz);
echo mysqli_num_rows($qsqlqz);
		?></td>
	</tr>
	<tr>
		<th>Correct Answers:</th><td><?php 
$sqlqz ="SELECT * FROM examination WHERE attend_date='$_GET[dttim]' AND customer_id='$rscustomer[customer_id]' and selectedanswer = correctanswer ";
$qsqlqz  = mysqli_query($con,$sqlqz);
echo $correctanswer= mysqli_num_rows($qsqlqz);
		?></td>
	</tr>
	<tr>
		<th>Wrong Answers:</th><td><?php 
$sqlqz ="SELECT * FROM examination WHERE attend_date='$_GET[dttim]' AND customer_id='$rscustomer[customer_id]' and selectedanswer != correctanswer ";
$qsqlqz  = mysqli_query($con,$sqlqz);
echo $wronganswer =  mysqli_num_rows($qsqlqz);
		?></td>
	</tr>
	<tr>
		<th>Total Marks:</th><th><?php 
$sqlquiz_result ="SELECT * FROM examination WHERE attend_date='$_GET[dttim]' AND customer_id='$rscustomer[customer_id]'";
$qsqlquiz_result  = mysqli_query($con,$sqlquiz_result);
$rsquiz_result = mysqli_fetch_array($qsqlquiz_result);
		echo ($correctanswer * $rsquiz_result['marksperquestion'] );
		?></th>
	</tr>
</table>
	</div>
</div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


       <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-body">
<center><input type="button" name="button" class="btn btn-info" value="Print" onclick="window.print()" ></center>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>

  </div>
  <!-- /.content-wrapper -->
<?php
include("footer.php");
?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script src="dist/js/pages/dashboard3.js"></script>

<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#tblquestionviewer').DataTable({
	"pageLength": 1000,
	"bPaginate": false,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": false,
	"sortb" : x,
});
} );
</script>

</body>
</html>