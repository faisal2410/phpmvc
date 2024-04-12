<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;

class ChangeResponseExample
{
    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $response = $next->handle($request);

        $response->setBody($response->getBody() . " hello from the middleware");

        return $response;
    }
}