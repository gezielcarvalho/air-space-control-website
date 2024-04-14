<?php

namespace App\Annotations;

class OpenApiSpec
{
/**
 * @OA\Info(
 *     version="2.0",
 *     title="Air Space Control Website",
 *     description="Air Space Control Website Documentation",
 *     @OA\Contact(name="Geziel Carvalho", email="geziel.natal@gmail.com")
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API local server (check .env file for the APP_URL)"
 * )
 * @OA\Server(
 *     url="http://air-space-control-website.test/",
 *     description="API Staging Server"
 * ) 
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentication endpoints"
 * ) 
 */
    private function getServerUrl(): string
    {
        return config('app.url');
    }
    public function dummy()
    {
        // This is just a dummy method to hold the @OA\Info annotation.
    }
}
