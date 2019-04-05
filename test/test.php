<?php
$timezone=new DateTimeZone("Asia/Dhaka");
$now=new DateTime("now", $timezone);
$ref= new DateTime("2019-04-06 04:05:15", $timezone);
$interval=$now->diff($ref);

$years=$interval->format('%y');
$months=$interval->format('%m');
$days= $interval->format('%d');
$hours=$interval->format('%H');
$minutes=$interval->format('%i');
$seconds=$interval->format('%s');

echo "Interval is: $years years, $months months, $days days, $hours hours $minutes minutes and $seconds seconds!";
