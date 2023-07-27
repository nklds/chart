<?php

namespace App\Contracts;
interface Renderable
{
    public static function render(string $view, array $params, string $layout): string;
}