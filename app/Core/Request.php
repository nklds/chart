<?php

namespace App\Core;


class Request
{

    private string $hostname;
    private array $params = [];
    private string $pathname;
    private string $query;

    private string $method;


    public function getHostname()
    {
        return $this->hostname;
    }

    public function getPathname()
    {
        return $this->pathname;
    }
    public function getMethod()
    {
        return $this->method;
    }


    public function hasParam($param): bool
    {
        return isset($this->getParams()[$param]);
    }

    public function getParam($param): string
    {
        return $this->getParams()[$param] ?? '';
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(): void
    {
        $params = explode('&', $this->query);
        foreach ($params as $param) {
            if ($key = explode('=', $param)[0]) {
                $this->params[$key] = explode('=', $param)[1] ?? '';
            }
        }

    }

    public function __construct(App $app)
    {
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->pathname = preg_split('/\?/', $_SERVER['REQUEST_URI'])[0];
        $this->query = preg_split('/\?/', $_SERVER['REQUEST_URI'])[1] ?? "";
        $this->setParams();
    }

}