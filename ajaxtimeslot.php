<?php
include("dbconnection.php");
?>
<select name="timeslot_id" id="timeslot_id" class="form-control" onsubmit="return validateform()" >
	<option value="">Select Time slot</option>
	<?php
	$sqltime_slots = "SELECT * FROM time_slots where status='Active' AND employee_id='$_GET[empid]'";
	$qsqltime_slots=  mysqli_query($con,$sqltime_slots);
	while($rstime_slots = mysqli_fetch_array($qsqltime_slots))
	{
		$label= " ";
		$dis = " ";
		$sqldriving_class = "SELECT * FROM driving_class WHERE timeslot_id='$rstime_slots[0]' AND (('$_GET[start_date]' BETWEEN start_date and end_date) OR ('$_GET[end_date]' BETWEEN start_date and end_date)) and status='Active'";
		$qsqldriving_class = mysqli_query($con,$sqldriving_class);
		if(mysqli_num_rows($qsqldriving_class) >= 1)
		{
			$dis = " disabled ";
			$label= " ( Already Booked ) ";
		}
		if($rstime_slots['timeslot_id'] == $rsedit['timeslot_id'] )
		{
			echo "<option value='$rstime_slots[timeslot_id]' selected $dis>" . date("h:i A",strtotime($rstime_slots['start_time'])) . " - " . date("h:i A",strtotime($rstime_slots['end_time'])) . " $label </option>";
		}
		else
		{
			echo "<option value='$rstime_slots[timeslot_id]' $dis >" . date("h:i A",strtotime($rstime_slots['start_time'])) . " - " . date("h:i A",strtotime($rstime_slots['end_time'])) . " $label </option>";
		}
	}
	?>
</select><span id="errdivtimeslot" class="errorclass" ></span>