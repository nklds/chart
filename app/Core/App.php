<?php

namespace App\Core;

use App\Models\Storage;

class App
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;

    public array $config;

    public Storage $storage;

    public function run(): void
    {
        $this->config = Storage::getINIData('config.ini');
        $this->request = new Request($this);
        $this->response = new Response($this);
        $this->router = new Router($this);
    }
}