<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class SiteController extends Controller
{
    public function index(){
        $response = $this->app->response;
        $response
            ->setData(VIew::render('index.php', ['title' => ' Привет!']))
            ->addHeader(header: "Content-type: text/html", status: 200)
            ->sendResponse();
    }

}