<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;

class ChangeRequestExample
{
    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $request->post = array_map("trim", $request->post);

        $response = $next->handle($request);

        return $response;
    }
}