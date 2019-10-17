<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/16
 * Time: 23:02
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;

class UsersController extends  Controller
{
    public function index()
    {
       return User::all();
    }

    public function show($id)
    {


        var_dump(config('easysms'));

//        $user =  User::find($id);
//        return $this->response->item($user, new UserTransformer());
    }

}