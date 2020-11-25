<?php

namespace App\Library;

use Carbon\Carbon;

class CarbonDate
{
    /**
     * 获取上周时间
     *
     * @param  string  $week      星期几
     * @return josn
     */ 
    public static function getLastWeek($week)
    {
        //monday tuesday wednesday thursday friday saturday sunday
        $date = new Carbon("last {$week}"); 
        return $date->toArray();
    }

}