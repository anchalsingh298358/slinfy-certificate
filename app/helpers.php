<?php
use App\Country;
use App\ScheduleDetail;
use App\OrderDetail;
use App\Cart;

// for random generator text
if (!function_exists('generate_random_number')) {
    function generate_random_number($digits = 8) {
        srand((double) microtime() * 10000000);
        $input = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $random_generator = "";
        for ($i = 1; $i <= $digits; $i++) {
            if (rand(1, 2) == 1) {
                $rand_index = array_rand($input);
                $random_generator .=$input[$rand_index];
            } else {
                $random_generator .=rand(1, 9);
            }
        }
        return $random_generator;
    }
}

//Check schedule time slot
if (!function_exists('countOverlapTimeSlot')) {
    function countOverlapTimeSlot($whereData = '', $start_time, $end_time)
    {
        $checkTimeSlot = ScheduleDetail::where($whereData)->where(function ($query) use ($start_time, $end_time) {
            $query->where(function ($q) use ($start_time, $end_time) {
                $q->where('start_time', '>', $start_time)
                    ->where('start_time', '<', $start_time);
            })->orWhere(function ($q) use ($start_time, $end_time) {
                $q->where('end_time', '>', $start_time)
                    ->where('end_time', '<', $start_time);
            })->orWhere(function ($q) use ($start_time, $end_time) {
                $q->where('start_time', '>', $end_time)
                    ->where('start_time', '<', $end_time);
            })->orWhere(function ($q) use ($start_time, $end_time) {
                $q->where('end_time', '>', $end_time)
                    ->where('end_time', '<', $end_time);
            })->orWhere(function ($q) use ($start_time, $end_time) {
                $q->where('start_time', '<', $start_time)
                    ->where('end_time', '>', $start_time);
            })->orWhere(function ($q) use ($start_time, $end_time) {
                $q->where('start_time', '<', $end_time)
                    ->where('end_time', '>', $end_time);
            });
        })->count();
        return $checkTimeSlot;
    }
}

//All Months
if (!function_exists('all_months')) {
    function all_months() {
        return array(
            "0" => array("id" => "01", "name" => "January"),
            "1" => array("id" => "02", "name" => "February"),
            "2" => array("id" => "03", "name" => "March"),
            "3" => array("id" => "04", "name" => "April"),
            "4" => array("id" => "05", "name" => "May"),
            "5" => array("id" => "06", "name" => "June"),
            "6" => array("id" => "07", "name" => "July"),
            "7" => array("id" => "08", "name" => "August"),
            "8" => array("id" => "09", "name" => "September"),
            "9" => array("id" => "10", "name" => "October"),
            "10" => array("id" => "11", "name" => "November"),
            "11" => array("id" => "12", "name" => "December")
        );
    }
}

//Get Years
if (!function_exists('get_years')) {
    function get_years()
    {
        $current_year = 2019 + 3;
        $max_year = $current_year - 2;

        for ($i = $current_year; $i >= $max_year; $i--) {
            $year_array[$i] = $i;
        }
        return $year_array;
    }
}


if(!function_exists('getGender'))
{
    function getGender($genderType)
    {
        switch ($genderType) {
            case 1:
                return "Male";
            break;

            case 2:
                return "Female";
            break;

            case 3:
                return "Other";
            break;
            
            default:
                # code...
                break;
        }

    }
}
