<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/16
 * Time: 23:02
 */

namespace App\Http\Controllers;

class UsersController extends  Controller
{
    public function showProfile()
    {
        echo 222;

        return redirect()->route('show', ['id'=>1]);
    }

    public function show($id)
    {
        echo 'i am show! id='.$id;
    }

}