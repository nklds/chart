<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\CSVHelper;
use App\Models\Storage;

class ApiController extends Controller
{
    public function index(): void
    {
        $response = $this->app->response;
        $response
            ->setData([
                'Initial' => '/api/initial',
                'Sort by days' => '/api/day',
                'Sort by week' => '/api/week',
                'Sort by month' => '/api/month',
                'Sort by year' => '/api/year',
            ])
            ->toJSON()
            ->addHeader(header: "Content-type: application/json", status: 200)
            ->sendResponse();
    }

    public function chart($period): void
    {
        $response = $this->app->response;
        $data = Storage::getCSVData('data/data.csv');
        $callbacks = [
            'initial' => fn($i) => CSVHelper::getInitialFromStr($i),
            'day' => fn($i) => CSVHelper::getDayFromStr($i),
            'week' => fn($i) => CSVHelper::getWeekFromStr($i),
            'month' => fn($i) => CSVHelper::getMonthFromStr($i),
            'year' => fn($i) => CSVHelper::getYearFromStr($i),

        ];

        $initialData = CSVHelper::diffDataBy($data,
            $callbacks['initial']
        );

        foreach ($initialData as $key => $value) {
            $initialData[$key] = CSVHelper::average($value);
        }


        if ($period != 'initial') {
            $data = CSVHelper::diffDataBy($data,
                $callbacks[$period]
            );
            foreach ($data as $key => $value) {
                $data[$key] = CSVHelper::average($value);
            }

            $data = CSVHelper::linkArrays($initialData,
                $data,
                $callbacks[$period]
            );
        } else $data = $initialData;
        $response
            ->setData(array_reverse($data))
            ->toJSON()
            ->addHeader(header: "Content-type: application/json", status: 200)
            ->sendResponse();
    }

}