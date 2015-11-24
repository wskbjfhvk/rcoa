<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\utils;

/**
 * Description of DateUtil
 *
 * @author Administrator
 */
class DateUtil {
    /**
     * 
     * @param date $date 指定日期
     * @return array(start=>起始日期,end=>结束日期)
     */
    public static function getWeekSE($date,$offset=0)
    {
        //$date=date('Y-m-d');  //当前日期
        $first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end=date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
        if($offset!=0)
        {
            $off_start = $offset*7;
            $off_end = $offset*7+6;
            $now_start=date('Y-m-d',strtotime("$now_start $off_start days"));  //上周开始日期
            $now_end=date('Y-m-d',strtotime("$now_start $off_end days"));  //上周结束日期
        }
        
        return [
            'start' => $now_start,
            'end' => $now_end,
        ];
    }
}
