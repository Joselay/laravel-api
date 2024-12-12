<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: '1.0.0', title: 'API Documentation', description: 'API Documentation'),
    OA\Server(url: 'http://localhost:8000/api/v1', description: 'Local server'),
    OA\SecurityScheme(
        securityScheme: 'bearerAuth',
        type: "http",
        name: "Authorization",
        in: "header",
        scheme: "bearer",
    ),
]
abstract class Controller
{
    //
}
