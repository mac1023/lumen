<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/17
 * Time: 15:26
 */
namespace App\Requests;


class AuthorizationRequest extends FormRequest
{


    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

}