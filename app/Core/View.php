<?php

namespace App\Core;

use App\Contracts\Renderable;

class View implements Renderable
{
    public static function render(string $view, array $params = [], $layout = 'mainLayout.php'): string
    {
        extract($params);
        ob_start();
        require __DIR__ . "/../Views/$view";
        $content = ob_get_clean();
        ob_start();
        require __DIR__ . "/../Views/$layout";
        return ob_get_clean();
    }
}