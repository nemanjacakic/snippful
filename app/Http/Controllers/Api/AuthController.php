<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);


        if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->respondWithItem($user, new UserTransformer);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
        }

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorUnauthorized('invalid_credentials');
            }
        } catch (JWTException $e) {
            return $this->errorInternalError('could_not_create_token');
        }

        return $this->respondWithItem($request->user(), new UserTransformer, [], ['token' => $token]);
    }
}
