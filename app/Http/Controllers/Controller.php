<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Jihene-Line API",
 *     description="Documentation API pour Jihene-Line",
 *     @OA\Contact(
 *         email="yssfmrbt@gmail.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api/v1",
 *     description="Serveur API"
 * )
 *
 * @OA\PathItem(
 *     path="/api/v1"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;
}
