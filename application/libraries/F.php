<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class F
{
//取一个指定日期，周一的开始时间
    function get_time_range_of_week($day)
    {
        $time = strtotime($day);
        $i_week = date('w', $time);

        if ($i_week == 0) {
            $start = $time - 3600 * 24 * 6;
            $end = $time + 3600 * 24 - 1;
        } else {
            $start = $time - 3600 * 24 * ($i_week - 1);
            $end = $time + 3600 * 24 * (8 - $i_week) - 1;
        }

        return (object)array(
            'start' => $start,
            'end' => $end
        );
    }
}



/* End of file */
