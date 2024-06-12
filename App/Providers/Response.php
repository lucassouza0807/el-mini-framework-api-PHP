<?php

namespace App\Providers;

class Response
{
    public static function json(array $data = [], int $status = 200)
    {
        header('Content-Type: application/json; charset=utf-8');

        http_response_code($status);

        echo json_encode($data);
    }
}