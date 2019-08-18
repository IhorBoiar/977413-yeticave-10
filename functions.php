<?php 
    function formatPrice($price) 
    {
        $price = ceil($price);
        if ($price >= 1000) {
            $price = number_format($price, 0, ',', ' ');
        }

        $price = $price . "<b class='rub'>p</b>";
        
        return $price;
    }
    
    function get_dt_range($format) 
    {
        $time_now = strtotime("2019-10-10 14:31");
        $time_last = strtotime($format);    
        
        $diff_time = $time_last - $time_now;
        $a = floor($diff_time / 3600);
        $b = floor($diff_time % 3600 / 60);

        $hours = str_pad($a, 2, "0", STR_PAD_LEFT);
        $mins = str_pad($b, 2, "0", STR_PAD_LEFT);

        $array = [$hours, $mins];
        return $array;
    }