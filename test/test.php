<?php
// $timezone=new DateTimeZone("Asia/Dhaka");
// $now=new DateTime("now", $timezone);
// $ref= new DateTime("2019-04-06 04:05:15", $timezone);
// $interval=$now->diff($ref);

// $years=$interval->format('%y');
// $months=$interval->format('%m');
// $days= $interval->format('%d');
// $hours=$interval->format('%H');
// $minutes=$interval->format('%i');
// $seconds=$interval->format('%s');

// echo "Interval is: $years years, $months months, $days days, $hours hours $minutes minutes and $seconds seconds!";

// echo date("Y-m-d H:i:s");

// echo $now->format('M');

class Date extends DateTime
{
    private $timezone;
    public $now;
    
    public function __construct(DateTimeZone $timezone)
    {
        $this->timezone=$timezone;
        parent::__construct('now',$timezone);
        $this->now=$this->format('Y-m-d H:i:s');
    }

    public function getDateTime($format)
    {
        return $this->format($format);
    }

    public function getDiff($date) : array
    {
        $ref=new DateTime($date, $this->timezone);
        $interval=$this->diff($ref);

        $diff['years']=$interval->format('%y');
        $diff['months']=$interval->format('%m');
        $diff['days']= $interval->format('%d');
        $diff['hours']=$interval->format('%H');
        $diff['minutes']=$interval->format('%i');
        $diff['seconds']=$interval->format('%s');

        return $diff;
    }
}


$date=new Date(new DateTimeZone('Asia/Dhaka'));
$diff=$date->getDiff('2019-04-28 20:35:46');

$res=array_filter($diff, function($v,$k)
{
	return ($v!=0);
},ARRAY_FILTER_USE_BOTH);

var_dump($res);
