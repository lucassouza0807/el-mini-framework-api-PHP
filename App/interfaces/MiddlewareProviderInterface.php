<?php 

namespace App\Interfaces;

interface MiddlewareProviderInterface {
    public function getMiddleware($middleware);
}