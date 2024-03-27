<?php
error_reporting(0);
$nodays =$_GET['no_of_days']-1;
?>
<input type='date' name='end_date' id='end_date' class='form-control' value='<?php echo date('Y-m-d', strtotime($_GET['dt'] . " +$nodays day"));?>' readonly ><span id='errend_date' class='errorclass' ></span>