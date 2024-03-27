<?php
$ddate = date('Y-m-d');
$date = new DateTime($ddate);
$week = $date->format("W");
$week=$week;
$year=date('Y');
function getStartAndEndDate($week, $year) {
  $dateTime = new DateTime();
  $dateTime->setISODate($year, $week);
  $result['start_date'] = $dateTime->format('d-M-Y');
  $dateTime->modify('+6 days');
  $result['end_date'] = $dateTime->format('d-M-Y');
  return $result;
}
$dates=getStartAndEndDate($week,$year);

echo "Start date - " . $dates['start_date'] . "<br>";
echo "End date - " . $dates['end_date'];
?>