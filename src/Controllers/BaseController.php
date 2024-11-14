<?php

namespace App\Controllers;

use App\Core\View;

class BaseController
{
    protected function render($view, $data = [])
    {
        View::render($view, $data);
    }

    protected function jsonResponse($data, $status = 'success', $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(['status' => $status] + $data);
        exit;
    }

    protected function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
