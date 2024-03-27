<?php
include("header.php");
include("sidebar.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

<br>
<?php
{
?>
	
    <!-- Main content -->
    <section class="content">
<form method="post" action="" onsubmit="return confirmvalidation2()" enctype="multipart/form-data">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Quiz Panel </h3>
        </div>
        <div class="card-body">
		
<table id="tblquestionviewer"  class="table table-striped table-bordered" >
	<thead>
		<tr>
		
			<th></th>
			<th>
			<centeR>
			Number of Questions : 
			<?php
			$sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]'";
			$qsqlqz  = mysqli_query($con,$sqlqz);
			echo mysqli_num_rows($qsqlqz);
			?>
			| 
			Answered Questions : 
			<span id="idansweredquestions"><?php
			$sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer != ''";
			$qsqlqz  = mysqli_query($con,$sqlqz);
			echo mysqli_num_rows($qsqlqz);
			?></span>
			|
			Unanswered Questions : 
			<span id="idunansweredquestions"><?php
			$sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer = ''";
			$qsqlqz  = mysqli_query($con,$sqlqz);
			echo mysqli_num_rows($qsqlqz);
			?></span>
			|
			Times Remaining : 
			<span id="time" style='color:red;'><img src='images/loading.gif' style="width:50px;height:50px;"></span>
			</center>
			</th>
		</tr>
	</thead>
	<tbody>
<?php
$qno=1;
$sqlqz ="SELECT examination.*, questions.qstn as question, questions.opt1 as option1, questions.opt2 as option2, questions.opt3 as option3, questions.opt4 as option4, questions.img, questions.dsptn, examination.selectedanswer FROM `examination` LEFT JOIN questions ON examination.qstn_id=questions.qstn_id WHERE examination.attend_date='$_SESSION[dttim]' AND examination.customer_id='$_SESSION[customer_id]' ORDER BY examination.examinationid ASC";
$qsqlqz  = mysqli_query($con,$sqlqz);
echo mysqli_error($con);
while($rsqz = mysqli_fetch_array($qsqlqz))
{
?>
	<tr>
		<td><?php echo $qno; ?></td>
		<td>
		
<input type="hidden" name="edquizid" id="edquizid" value="<?php echo $rsqz['0']; ?>">
		
		<table style='width: 100%;'>
			<tr>
				<td>
				
				<b>Question No.  <?php echo $qno; ?> :- </b><br><b style="color: blue;"><?php echo $rsqz['question']; ?></b>		
				<br>
				<?php echo $rsqz['dsptn']; ?>
				</td>
			</tr>			

<?php
if(file_exists("imgqsn/".$rsqz['img']))
	{
?>
			<tr>
				<td>
<img src="imgqsn/<?php echo $rsqz['img']; ?>" style='height: 200px;'>
				</td>
			</tr>
<?php
	}
?>			
				
			<tr>
				<td>
					<b style='color: red;' for="option<?php echo $rsqz['0']; ?>4">Option A:</b><input type="radio" name="option<?php echo $rsqz['0']; ?>" id="option<?php echo $rsqz['0']; ?>1" value="Option 1" style="display: inline-block; border: 1px solid #000;border-radius: 50%;margin: 0 0.5em;width: 30px;height: 15px;" 
					<?php
					if($rsqz['selectedanswer'] == "Option 1")
					{
						echo " checked ";
					}
					?>
					onclick="updanswer('<?php echo $rsqz['0']; ?>',this.value)" onchange="updanswer('<?php echo $rsqz['0']; ?>',this.value)" >
					 <label for="option<?php echo $rsqz['0']; ?>1"><?php echo $rsqz['option1']; ?></label>
				</td>
			</tr>
			<tr>
				<td>
					<b style='color: red;' for="option<?php echo $rsqz['0']; ?>4">Option B:</b><input type="radio" name="option<?php echo $rsqz['0']; ?>" 
					<?php
					if($rsqz['selectedanswer'] == "Option 2")
					{
						echo " checked ";
					}
					?>
					id="option<?php echo $rsqz['0']; ?>2" value="Option 2" style="display: inline-block; border: 1px solid #000;border-radius: 50%;margin: 0 0.5em;width: 30px;height: 15px;" onclick="updanswer('<?php echo $rsqz['0']; ?>',this.value)" onchange="updanswer('<?php echo $rsqz['0']; ?>',this.value)" >
					 <label for="option<?php echo $rsqz['0']; ?>2"><?php echo $rsqz['option2']; ?></label>
				</td>
			</tr>
			<tr>
				<td>
					<b style='color: red;' for="option<?php echo $rsqz['0']; ?>4">Option C:</b><input type="radio" name="option<?php echo $rsqz['0']; ?>" 
					<?php
					if($rsqz['selectedanswer'] == "Option 3")
					{
						echo " checked ";
					}
					?>
					id="option<?php echo $rsqz['0']; ?>3" value="Option 3" style="display: inline-block; border: 1px solid #000;border-radius: 50%;margin: 0 0.5em;width: 30px;height: 15px;" onclick="updanswer('<?php echo $rsqz['0']; ?>',this.value)" onchange="updanswer('<?php echo $rsqz['0']; ?>',this.value)" >
					 <label for="option<?php echo $rsqz['0']; ?>3"><?php echo $rsqz['option3']; ?></label>
				</td>
			</tr>
			<tr>
				<td>
					<b style='color: red;' for="option<?php echo $rsqz['0']; ?>4">Option D:</b><input type="radio" name="option<?php echo $rsqz['0']; ?>" 
					<?php
					if($rsqz['selectedanswer'] == "Option 4")
					{
						echo " checked ";
					}
					?>
					id="option<?php echo $rsqz['0']; ?>4" value="Option 4" style="display: inline-block; border: 1px solid #000;border-radius: 50%;margin: 0 0.5em;width: 30px;height: 15px;" onclick="updanswer('<?php echo $rsqz['0']; ?>',this.value)" onchange="updanswer('<?php echo $rsqz['0']; ?>',this.value)" >
					 <label for="option<?php echo $rsqz['0']; ?>4"><?php echo $rsqz['option4']; ?></label>
				</td>
			</tr>
		</table>


		</td>
	</tr>
<?php
$qno =$qno + 1;
}
?>
	</tbody>
</table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
	
	    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-body">
<center><input type="button" name="submit" id="submit" value="Click Here to End" class="btn btn-info" onclick="confirmtocomplete('0','<?php echo $_SESSION['studentid']; ?>')" ></center>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</form>
    </section>
<?php
}
?>	
  </div>
  <!-- /.content-wrapper -->
<?php
include("footer.php");
?>
<div id="idansstatus"><?php $sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer != ''"; $qsqlqz  = mysqli_query($con,$sqlqz); echo mysqli_error($con);?><input type="hidden" name="answereedq" id="answereedq" value="<?php echo mysqli_num_rows($qsqlqz); ?>" ><?php $sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer = ''";
$qsqlqz  = mysqli_query($con,$sqlqz); ?><input type="hidden" name="unanswereedq" id="unanswereedq" value="<?php echo mysqli_num_rows($qsqlqz); ?>" ></div>
<script>
    $('#tblquestionviewer').DataTable({
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
	],
    "aaSorting": [[0, 'asc']],
	"pageLength": 1,
	"bPaginate": true,
    "bLengthChange": false,
    "bFilter": false,
    "bInfo": false,
    "bAutoWidth": false,
});
</script>
<script>
function updanswer(quiz_resultid,answer)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("idansstatus").innerHTML = this.responseText;
			document.getElementById("idansweredquestions").innerHTML = document.getElementById("answereedq").value;
			document.getElementById("idunansweredquestions").innerHTML = document.getElementById("unanswereedq").value;
		}
	};
	xmlhttp.open("GET", "ajaxanswer.php?quiz_resultid=" + quiz_resultid + "&answer=" + answer, true);
	xmlhttp.send();
}
</script>
<script>
function startTimer(duration, display) 
{
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;
		//$_SESSION["timeleft"]
		//alert(timer);
		
		//Ajax Timer starts
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET","ajaxtimer.php?timer="+timer,true);
        xmlhttp.send();
		//Ajax Timer ends	
        if (--timer < 0) {
            timer = duration;
			window.location='quiz_result.php?dttim=<?php echo $_SESSION["dttim"];?>&customer_id=<?php echo $_SESSION["customer_id"]; ?>';
        }
    }, 1000);
}
</script>
<script>
window.onload = function () {
    var fiveMinutes = '<?php echo $_SESSION["timeleft"]; ?>',
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};
</script>
<script>
function confirmtocomplete(quiztopicid,studentid) 
{
	if(document.getElementById("unanswereedq").value == 0)
	{
		if(confirm("Are you sure?") == true)
		{
			window.location='quiz_result.php?dttim=<?php echo $_SESSION["dttim"];?>&customer_id=<?php echo $_SESSION["customer_id"]; ?>';
		}
	}
	if(document.getElementById("unanswereedq").value != 0)
	{
		if(confirm("All Questions not answered yet.. Are you sure want to close Quiz panel?") == true)
		{
			window.location='quiz_result.php?dttim=<?php echo $_SESSION["dttim"];?>&customer_id=<?php echo $_SESSION["customer_id"]; ?>';
		}
	}
}
</script>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->