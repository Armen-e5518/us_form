<?php
namespace backend\components;

use Yii;

/**
 * Site controller
 */
class DataChange
{

    public static function ColumnNormal($string)
    {
        $new_name = '';
        if (!empty($string)) {
            $column_array = explode("_", $string);
            if (!empty($column_array)) {
                $count = count($column_array);
                if ($count == 1) {
                    $new_name = ucfirst($column_array[0]);
                } elseif ($count > 2) {
                    foreach ($column_array as $kay => $val) {
                        if ($kay != 0 && $kay != $count - 1) {
                            $new_name .= ucfirst($val) . ' ';
                        }
                    }
                } else {
                    foreach ($column_array as $kay => $val) {
                        if ($kay != 0) {
                            $new_name .= ucfirst($val) . ' ';
                        }
                    }
                }
            } else {
                return ucfirst($string);
            }
        }
        return $new_name;
    }

    public static function ColumnsNameByNormal($array)
    {
        if (!empty($array)) {
            foreach ($array as $kay => $value) {
                $array[$kay] = self::ColumnNormal($value);
            }
        }
        return $array;
    }
}
