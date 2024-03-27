<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM questions where qstn_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Questions record deleted successfully..');</script>";
		echo "<script>window.location='viewquestions.php';</script>";
	}
}
?>

	<!-- Start Blog -->
	<div id="blog" class="blog-box">
		<div class="container">

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="blog-inner">
						<div class="item-meta">
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW QUESTIONS RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Image</th>
			<th>Question & options</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM questions";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		if($rs['img'] == "")
		{
			$imgname="images/default-image.jpg";
		}
		else if(file_exists("imgqsn/".$rs['img']))
		{
			$imgname= "imgqsn/".$rs['img'];
		}
		else
		{
			$imgname="images/default-image.jpg";
		}
		echo "<tr>
		<td style='width: 85px;'><img src='$imgname' style='width: 85px; height: 90px;' ></td>
			<td style='text-align: left;'>
			<b style='color: red;' >Question : $rs[qstn]</b><br>";
			if($rs['ans'] == "Option 1")
			{
			echo "<b style='color: green;'>Option 1: $rs[opt1]</b><br>";
			}
			else
			{
				echo "<b>Option 1:</b> $rs[opt1]<br>";
			}
			if($rs['ans'] == "Option 2")
			{
			echo "<b style='color: green;'>Option 2: $rs[opt2]</b><br>";
			}
			else
			{
				echo "<b>Option 2:</b> $rs[opt2]<br>";
			}
			if($rs['ans'] == "Option 3")
			{
			echo "<b style='color: green;'>Option 3: $rs[opt3]</b><br>";
			}
			else
			{
				echo "<b>Option 3:</b> $rs[opt3]<br>";
			}
			if($rs['ans'] == "Option 4")
			{
			echo "<b style='color: green;'>Option 4: $rs[opt4]</b><br>";
			}
			else
			{
				echo "<b>Option 4:</b> $rs[opt4]<br>";
			}
			echo "</td>
			<td style='width: 70px;'>$rs[status]</td>
			<td style='width: 100px;'><a  href='questions.php?editid=$rs[0]' class='btn btn-info' style='width: 100px;'>Edit</a>
			 <hr>
			<a href='viewquestions.php?delid=$rs[0]' class='btn btn-danger'
			onclick='return confirm2delete()' style='width: 100px;'>Delete</a>
			
			</td>
		</tr>";
	}
	?>

	</tbody>
</TABLE>						
						
						</p> 
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<!-- End Blog -->
	
<?php
include("footer.php");
?>
<script>
function confirm2delete()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return true;	
	}
	else
	{
		return false;
	}
}
</script>