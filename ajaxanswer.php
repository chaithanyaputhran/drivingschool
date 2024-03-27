<?php
session_start();
include("dbconnection.php");
$sqlupd  = "UPDATE examination SET selectedanswer='$_GET[answer]' WHERE examinationid='$_GET[quiz_resultid]'";
$qsqlupd = mysqli_query($con,$sqlupd);
echo mysqli_error($con);
?>
<?php
$sqlqz ="SELECT * FROM examination WHERE attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer != ''";
$qsqlqz  = mysqli_query($con,$sqlqz);
?>
<input type="hidden" name="answereedq" id="answereedq" value="<?php echo mysqli_num_rows($qsqlqz); ?>" >
<?php
$sqlqz ="SELECT * FROM examination WHERE  attend_date='$_SESSION[dttim]' AND customer_id='$_SESSION[customer_id]' and selectedanswer=''";
$qsqlqz  = mysqli_query($con,$sqlqz);
?>
<input type="hidden" name="unanswereedq" id="unanswereedq" value="<?php echo mysqli_num_rows($qsqlqz); ?>" >