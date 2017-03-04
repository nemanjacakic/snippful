<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiController extends Controller
{
    protected $user;

    protected $statusCode = 200;

    public function __construct()
    {
        $this->user = $this->getAuthenticatedUser();
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->errorNotFound('user_not_found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorUnauthorized('token_expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorWrongArgs('token_invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorInternalError('token_absent');
        }

        return $user;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondWith($data, $callback, $includes=[])
    {
        if (!$data) {
            return $this->errorNotFound('Requested response not found.');
        }

        elseif ($data instanceof Collection || $data instanceof LengthAwarePaginator) {
            return $this->respondWithCollection($data, $callback, $includes);
        }

        elseif ($data instanceof Model) {
            return $this->respondWithItem($data, $callback, $includes);
        } else {
            return $this->errorInternalError();
        }
    }

    protected function respondWithItem($item, $callback, $includes=[], $meta = [])
    {
        return fractal()->item($item, $callback)->parseIncludes($includes)->addMeta($meta)->toArray();
    }

    protected function respondWithCollection($collection, $callback, $includes=[], $meta = [])
    {
        return fractal()->collection($collection, $callback)->parseIncludes($includes)->addMeta($meta)->toArray();
    }

    protected function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    public function respondWithError($message)
    {
        return $this->respondWithArray([
            'error' => [
                'http_code' => $this->statusCode,
                'message' => $message,
            ]
        ]);
    }

    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)
                    ->respondWithError($message);
    }

    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)
                    ->respondWithError($message);
    }

    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)
                    ->respondWithError($message);
    }

    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)
                    ->respondWithError($message);
    }

    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)
                    ->respondWithError($message);
    }
}
