<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/17
 * Time: 17:51
 */
namespace App\Http\Controllers;

use App\Requests\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;


        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }
}