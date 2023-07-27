<?php

namespace App\Core;

use App\Controllers\SiteController;

class Router
{
    private $app;
    private $routeScore = 0;

    private string $param;
    private array $controllerWithAction = [Controller::class, 'notFound'];

    public function __construct(App $app)
    {
        $this->app = $app;
        $router = $this;
        require_once __DIR__ . '/../urls.php';
        if (!method_exists($this->getControllerName(), $this->getActionName())) {
            $this->controllerWithAction = [Controller::class, 'notFound'];
        }

        $controllerName = $this->getControllerName();
        $controller = new $controllerName($app);
        $actionName = $this->getActionName();
        $this->hasParam()
            ? $controller->$actionName($this->getParam())
            : $controller->$actionName();


    }

    public function hasParam(): bool {
        return isset($this->param);
    }

    public function getParam(){
        return $this->param;
    }

    public function getControllerName()
    {
        return $this->controllerWithAction[0];
    }

    public function getActionName()
    {
        return $this->controllerWithAction[1];
    }

    public function get($pattern, $controllerWithAction): void
    {
        if ($this->app->request->getMethod() === 'GET') {
            $match = preg_match($pattern, $this->app->request->getPathname(), $matches);
            if ($match) {
                if (strlen($matches[0]) > $this->routeScore) {
                    $this->routeScore = strlen($matches[0]);
                    unset($this->param);
                    if (count($matches) >=2) {
                        $this->param = $matches[1];
                    }
                    $this->controllerWithAction = $controllerWithAction;
                }
            }
        }
    }




}