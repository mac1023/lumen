<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/16
 * Time: 23:02
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Requests\UserRequest;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
class UsersController extends  Controller
{
    public function index()
    {
       return User::all();
    }

//    public function show($id)
//    {
//
//        var_dump(config('easysms'));
//
////        $user =  User::find($id);
////        return $this->response->item($user, new UserTransformer());
//    }

    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        if(!$verifyData){
            return $this->response->error('code invailed', 422);
        }

        if(!hash_equals((string)$verifyData['code'], (string)$request->verification_code)){
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => Crypt::encrypt($request->password),
        ]);

        Cache::forget($request->verification_key);

        return $this->response->created();
    }

}