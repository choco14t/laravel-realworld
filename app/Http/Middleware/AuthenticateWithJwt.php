<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthenticateWithJwt extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param bool $optional
     * @return mixed
     * @throws JWTException
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     */
    public function handle($request, Closure $next, $optional = null)
    {
        $this->auth->setRequest($request);

        try {
            if (!$user = $this->auth->parseToken('token')->authenticate()) {
                return $this->respondError('JWT error: User not found');
            }
        } catch (TokenExpiredException $e) {
            return $this->respondError('JWT error: Token has expired');
        } catch (TokenInvalidException $e) {
            return $this->respondError('JWT error: Token is invalid');
        } catch (JWTException $e) {
            if ($optional === null) {
                return $this->respondError('JWT error: Token is absent');
            }
        }

        return $next($request);
    }

    /**
     * Respond with json error message.
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message)
    {
        return response()->json([
            'errors' => [
                'message' => $message,
                'status_code' => 401
            ]
        ], 401);
    }
}
