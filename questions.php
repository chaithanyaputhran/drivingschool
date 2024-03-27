<?php
include("header.php");
if(isset($_POST['submit']))
{
	$img = rand(). $_FILES['img']['name'];
	move_uploaded_file($_FILES['img']['tmp_name'],"imgqsn/".$img);	
	//Update statement starts here
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE questions set qstn='$_POST[qstn]',opt1='$_POST[opt1]',opt2='$_POST[opt2]',opt3='$_POST[opt3]',opt4='$_POST[opt4]',ans='$_POST[ans]'";
		if($_FILES['img']['name'] != "")
		{
		$sql = $sql . ",img='$img'";
		}
		$sql = $sql . ",dsptn='$_POST[dsptn]',status='$_POST[status]'WHERE qstn_id='$_GET[editid]'";
	
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('questions record updated successfully...');</script>";
			echo "<script>window.location='viewquestions.php';</script>";
		}
	}
	//Update statement ends here
	else
	{
		$sql = "INSERT INTO questions(qstn,opt1,opt2,opt3,opt4,ans,img,dsptn,status) values('$_POST[qstn]','$_POST[opt1]','$_POST[opt2]','$_POST[opt3]','$_POST[opt4]',
		'$_POST[ans]','$img','$_POST[dsptn]','$_POST[status]')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script>alert('Questions record inserted successfully...');</script>";
			echo "<script>window.location='questions.php';</script>";
		}
	}
}
?>
<?php
if(isset($_GET['editid']))
{
	$sqledit = "SELECT * FROM questions WHERE qstn_id='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
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
		<h3 class="title">Questions</h3>
		<p class="description">

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Questions </div>
<div class="col-md-8">
<textarea name="qstn" id="qstn" class="form-control" ><?php echo $rsedit['qstn']; ?></textarea>
<span id="errqstn" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Option 1 </div>
<div class="col-md-8">
<input type="text" name="opt1" id="opt1" class="form-control"value="<?php echo $rsedit['opt1']; ?>">
<span id="erropt1" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Option 2 </div>
<div class="col-md-8">
<input type="text" name="opt2" id="opt2" class="form-control"value="<?php echo $rsedit['opt2']; ?>">
<span id="erropt2" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Option 3 </div>
<div class="col-md-8">
<input type="text" name="opt3" id="opt3" class="form-control"value="<?php echo $rsedit['opt3']; ?>">
<span id="erropt3" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Option 4 </div>
<div class="col-md-8">
<input type="text" name="opt4" id="opt4" class="form-control" value="<?php echo $rsedit['opt4']; ?>">
<span id="erropt4" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Answer </div>
<div class="col-md-8">
	<select name="ans" id="ans"  class="form-control">
		<option value="">Select Answer</option>
		<?php
		$arr = array("Option 1","Option 2","Option 3","Option 4");
		foreach($arr as $val)
		{
			
			if($val == $rsedit['ans'])
			{
			echo "<option value='$val' selected>$val</option>";
			}
			else
			{
			echo "<option value='$val'>$val</option>";
			}
		}
		?>
	</select><span id="errans" class="errorclass" ></span>
</div>
</div>
<br>

<div class="row">
<div class="col-md-4" style="padding-top: 7px;"	>Image </div>
<div class="col-md-8">
<input type="file" name="img" id="img" class="form-control">
<span id="errimg" class="errorclass" ></span>
</div>
</div>
<br>
<div class="row">
	<div class="col-md-4" style="padding-top: 7px;"	>Description</div>
	<div class="col-md-8">
	<textarea name="img" id="dsptn" class="form-control"><?php echo $rsedit['dsptn']; ?></textarea>
	<span id="errdsptn" class="errorclass" ></span>
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
	if(document.getElementById("qstn").value=="")
	{
		document.getElementById("errqstn").innerHTML="Quetion should not be empty..";
		i=1;
	}
	if(document.getElementById("opt1").value=="")
	{
		document.getElementById("erropt1").innerHTML="Option should not be empty..";
		i=1;
	}
	if(document.getElementById("opt2").value=="")
	{
		document.getElementById("erropt2").innerHTML="Option should not be empty..";
		i=1;
	}
	if(document.getElementById("opt3").value=="")
	{
		document.getElementById("erropt3").innerHTML="Option should not be empty..";
		i=1;
	}
	if(document.getElementById("opt4").value=="")
	{
		document.getElementById("erropt4").innerHTML="Option should not be empty..";
		i=1;
	}
	if(document.getElementById("ans").value=="")
	{
		document.getElementById("errans").innerHTML="Kindly select Answer . .";
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
