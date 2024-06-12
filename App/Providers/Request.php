<?php

namespace App\Providers;

class Request
{
    public static function input(string $input): string
    {
        $requestBody = (array) json_decode(file_get_contents('php://input'));

        $input = strip_tags(filter_var($requestBody[$input], FILTER_UNSAFE_RAW));

        return $input;

    }

    public static function rawInput(string $input): string
    {
        $requestBody = (array) json_decode(file_get_contents('php://input'));

        return $requestBody[$input];
    }

    public static function get($input): string|null
    {
        if (!isset($_GET[$input])) {
            return null;
        }

        return $_GET[$input];

    }

    public static function post($input): string|null
    {
        if (!isset($_POST[$input])) {
            return null;
        }

        $input = strip_tags(filter_var($_POST[$input], FILTER_UNSAFE_RAW));

        return $input;
    }

    public function rawPost($input): string|null
    {
        if (!isset($_POST[$input])) {
            return null;
        }

        $input = strip_tags(filter_var($_POST[$input], FILTER_UNSAFE_RAW));

        return $input;
    }

    public static function getHeader(string $header): string|null
    {
        $headers = [];

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            }
        }

        if (!isset($headers[$header])) {
            return null;
        }

        return $headers[$header];
    }

    public static function getHeaders(): array
    {
        $headers = [];

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            }
        }

        return $headers;
    }
}