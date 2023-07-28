<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\CSVHelper;
use App\Models\Storage;
use const Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_STRPREFIX;

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
        $initialData = CSVHelper::prepareData($data, 'initial');
        $data = CSVHelper::prepareData($data, $period);
        $data = CSVHelper::linkArrays($initialData, $data, CSVHelper::getCallback($period));

        $response
            ->setData(array_reverse($data))
            ->toJSON()
            ->addHeader(header: "Content-type: application/json", status: 200)
            ->sendResponse();
    }

}