<?php

namespace App\Controllers;

use App\Core\View;

class BaseController
{
    protected $testing = false;

    public function __construct($testing = false)
    {
        $this->testing = $testing;
    }

    protected function render($view, $data = [])
    {
        View::render($view, $data);
    }

    protected function jsonResponse($content, $status = 'success', $statusCode = 200)
    {
        if (!$this->testing) {
            header('Content-Type: application/json');
            http_response_code($statusCode);
        }

        $response = ['status' => $status];

        if (isset($content['message'])) {
            $response['message'] = $content['message'];
        } elseif (is_array($content)) {
            $response['data'] = $content;
        }

        echo json_encode($response);
    }


    protected function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
