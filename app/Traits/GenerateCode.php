<?php 

namespace App\Traits;

trait GenerateCode{
    

    public static function Code()
    {
        $myString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string_to_array = str_split($myString);
        $section_1 = $string_to_array[rand(1,24)].$string_to_array[rand(1,24)].$string_to_array[rand(1,24)];
        $section_2 = $string_to_array[rand(1,24)].$string_to_array[rand(1,24)].$string_to_array[rand(1,24)];
        $section_3 = $string_to_array[rand(1,24)].$string_to_array[rand(1,24)].$string_to_array[rand(1,24)];
       return $section_1.'-'.$section_2.'-'.$section_3;

    }

}
