<?php

namespace App\Models;

use App\Core\App;

class Storage
{
    public App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public static function getCSVData($path): array
    {
        $res = [];
        if (($handle = fopen(__DIR__ . '/../' . $path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
                $res[] = $data;
            }
            fclose($handle);
        }
        return $res;
    }

    public static function getINIData($path): array
    {
        return parse_ini_file(__DIR__ . '/../' . $path) ?? [];
    }
}