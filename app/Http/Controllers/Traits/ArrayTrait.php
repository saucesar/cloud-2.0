<?php

namespace App\Http\Controllers\Traits;

trait ArrayTrait {
    public static function getEnvVariables($keys, $values)
    {
        return ArrayTrait::extractArray($keys, $values, '=', true);
    }

    public static function extractArray($keys, $values, $separator = '=', $upper = false)
    {
        $array = [];

        for($i = 0; $i < count($keys); $i++){
            if(isset($keys[$i]) && $values[$i]){
                $val = ($upper ? strtoupper($keys[$i]) : $keys[$i]).$separator.$values[$i];
                $array[] = $val;
            }
        }

        return $array;
    }

    public static function extractLabels($request)
    {
        $labelKeys = $request->LabelKeys;
        $labelValues = $request->LabelValues;
        
        $labels = [];

        for($i = 0; $i < count($labelKeys); $i++){
            if(isset($labelKeys[$i]) && isset($labelValues[$i])){
                $labels[$labelKeys[$i]] = $labelValues[$i];
            }
        }
        
        return $labels;
    }

    public static function extractArrayKey($keys, $values)
    {
        $array = [];

        for($i = 0; $i < count($keys); $i++){
            if(isset($keys[$i]) && isset($values[$i])){
                $array[$keys[$i]] = $values[$i];
            }
        }
        
        return $array;
    }

    public static function removeNull($array, $index = 0)
    {
        unset($array[$index]);
        return $array;
    }
}