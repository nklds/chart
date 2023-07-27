<?php

namespace App\Core;

use App\Contracts\Renderable;

/**
 *  var $params: array<string=>string>
 */
class Controller
{
    public App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function notFound(): void
    {
        $response = $this->app->response;
        $response
            ->setData(View::render('notFound.php', ['title' => ' 404!']))
            ->addHeader(header: "Content-type: text/html", status: 404)
            ->sendResponse();
    }
}