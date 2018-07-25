<?php

namespace App\Http\Middleware;

use Closure;

class ResponseMessageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->expectsJson()) {

            if (strpos($response->getContent(), 'token_type') !== false && strpos($response->getContent(), 'expires_in') !== false && strpos($response->getContent(), 'access_token') !== false ) {
                $response->setContent(
                    array(
                        "status" => "success",
                        "code" => 0,
                        "message" => "user logged in",
                        "payload" => json_decode($response->getContent())
                    )
                );
            }

            if (($response->getStatusCode() == 401 || $response->getStatusCode() == 403) && strpos($response->getContent(), '{"error":"invalid_credentials","message":"The user credentials were incorrect."}') !== false) {

                $response->setContent(
                    array(
                        "status" => "error",
                        "code" => 0,
                        "message" => "authentication_error",
                        "payload" => json_decode($response->getContent())
                    )
                );

            }

            if ($response->getStatusCode() == 422) {
                return $response()->json([
                    "status" => "error",
                    "code" => 0,
                    "message" => "validation_error",
                    "payload" => json_decode($response->getContent())
                ]);
            }

            $response->setStatusCode(200);

        }

        return $response;
    }
}
