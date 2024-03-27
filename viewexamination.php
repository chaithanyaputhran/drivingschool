<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM examination where exam_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Examination record deleted successfully..');</script>";
		echo "<script>window.location='viewexamination.php';</script>";
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
							<a href="#"><i class="fa fa-eye"></i> <b>VIEW EXAMINATON RECORDS</b> <i class="fa fa-eye"></i></a>
						</div>
						<p>
						
<TABLE id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Customer ID</th>
			<th>Exam Date</th>
			<th>Question ID</th>
			<th>Answer</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM examination";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
		
			<td>$rs[cust_id]</td>
			<td>$rs[exam_date]</td>
			<td>$rs[qstn_id]</td>
			<td>$rs[ans]</td>
			<td>
				<a  href='examination.php?editid=$rs[0]' class='btn btn-info'>Edit</a>	
				|  
			<a href='viewexamination.php?delid=$rs[0]' class='btn btn-danger'
			onclick='return confirm2delete()'>Delete</a>
			
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