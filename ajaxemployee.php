<?php
include("dbconnection.php");
$sqlemployee = "SELECT * FROM employee where status='Active' ";
if(isset($_GET['editid']))
{
$sqlemployee = $sqlemployee . " AND branch_id='$rsedit[branch_id]'";
}
else
{
$sqlemployee = $sqlemployee . " AND branch_id='$_GET[branch_id]'";
}
$qsqlemployee=  mysqli_query($con,$sqlemployee);
echo mysqli_error($con);
?>
<select name="employee_id" id="employee_id" class="form-control" >
<option value="">Select Employee</option>
<?php
while($rsemployee = mysqli_fetch_array($qsqlemployee))
{
	if($rsemployee['employee_id'] == $rsedit['employee_id'] )
	{
	echo "<option value='$rsemployee[employee_id]' selected>$rsemployee[employee_name]</option>";
	}
	else
	{
	echo "<option value='$rsemployee[employee_id]'>$rsemployee[employee_name]</option>";
	}
}
?>
</select><span id="erremployee_id" class="errorclass" ></span>