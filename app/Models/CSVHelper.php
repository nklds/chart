<?php

namespace App\Models;


class CSVHelper
{
    public static function getInitialFromStr($str): string|bool
    {
        preg_match('/\d\d\.\d\d\.\d\d\d\d .*/', $str, $matches);
        return count($matches)
            ? $matches[0]
            : false;
    }

    public static function getDayFromStr($str): string|bool
    {
        preg_match('/\d\d\.\d\d\.\d\d\d\d/', $str, $matches);
        return count($matches)
            ? $matches[0]
            : false;
    }

    public static function getMonthFromStr($str): string|bool
    {
        preg_match('/\d\d\.\d\d\d\d/', $str, $matches);
        return count($matches)
            ? $matches[0]
            : false;
    }

    public static function getYearFromStr($str): string|bool
    {
        preg_match('/\d\d\d\d/', $str, $matches);
        return count($matches)
            ? $matches[0]
            : false;
    }

    public static function getWeekFromStr($str): string|bool
    {
        if (!($date = self::getDayFromStr($str))) return false;
        $date = new \DateTime($date);
        return $date->format("W");
    }

    public static function diffDataByDay($arrays): array
    {
        $newArr = [];
        foreach ($arrays as $array) {
            if ($dateAndTemp = self::getDateAndTempFromArray($array, fn($i) => self::getWeekFromStr($i))) {
                [$date, $temp] = $dateAndTemp;
                $newArr[$date][] = $temp;
            }
        }
        return $newArr;
    }

    public static function diffDataBy($arrays, callable $cb): array
    {
        $newArr = [];
        foreach ($arrays as $array) {
            if ($dateAndTemp = self::getDateAndTempFromArray($array, $cb)) {
                [$date, $temp] = $dateAndTemp;
                $newArr[$date][] = $temp;
            }
        }
        return $newArr;
    }


    public static function getDateAndTempFromArray($array, callable $callback): array|false
    {
        if ($date = $callback($array[0])) {
            $temp = (int)$array[1];
            return [$date, $temp];
        }
        return false;
    }

    public static function average(array $array): float
    {
        return (float)array_sum($array) / count($array);
    }
    public static function getCallback($period): \Closure
    {
        $callbacks = [
            'initial' => fn($i) => CSVHelper::getInitialFromStr($i),
            'day' => fn($i) => CSVHelper::getDayFromStr($i),
            'week' => fn($i) => CSVHelper::getWeekFromStr($i),
            'month' => fn($i) => CSVHelper::getMonthFromStr($i),
            'year' => fn($i) => CSVHelper::getYearFromStr($i),

        ];
        return $callbacks[$period];
    }
    public static function prepareData($data, $period): array
    {
        $newData = CSVHelper::diffDataBy($data,
            self::getCallback($period)
        );

        foreach ($newData as $key => $value) {
            $newData[$key] = CSVHelper::average($value);
        }
        return $newData;
    }

    public static function linkArrays(array $initial, array $linked, callable $cb): array
    {
        $linkedArray = [];
        foreach ($initial as $date => $temp) {
            $linkedArray[] = [$cb($date), $temp, $linked[$cb($date)]];
        }
        return $linkedArray;
    }
}