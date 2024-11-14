<?php

namespace App\Controllers;

use App\Core\View;

class BaseController
{
    protected function render($view, $data = [])
    {
        View::render($view, $data);
    }
}
