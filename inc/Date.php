<?php


class Date extends DateTime
{
    private $timezone;
    public $now;
    
    public function __construct(DateTimeZone $timezone)
    {
        $this->timezone=$timezone;
        parent::__construct('now', $timezone);
        $this->now=$this->format('Y-m-d H:i:s');
    }

    public function getDateTime($format)
    {
        return $this->format($format);
    }

    public function getDiff($date)
    {
        $ref=new DateTime($date, $this->timezone);
        $interval=$this->diff($ref);

        $diff['years']=$interval->format('%y');
        $diff['months']=$interval->format('%m');
        $diff['days']= $interval->format('%d');
        $diff['hours']=$interval->format('%H');
        $diff['minutes']=$interval->format('%i');
        $diff['seconds']=$interval->format('%s');

        $res=array_filter($diff, function ($v, $k) {
            return ($v!=0);
        }, ARRAY_FILTER_USE_BOTH);


        if (array_key_exists('years', $res)) {
            return $res['years']." years";
        } elseif (array_key_exists('months', $res)) {
            return $res['months']." months";
        } elseif (array_key_exists('days', $res)) {
            return $res['days']." days";
        } elseif (array_key_exists('hours', $res)) {
            return $res['hours']." hours";
        } elseif (array_key_exists('minutes', $res)) {
            return $res['minutes']." minutes";
        } else {
            return $res['seconds']." seconds";
        }
    }
}
