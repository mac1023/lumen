<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/17
 * Time: 15:28
 */

namespace App\Requests;

use Dingo\Api\Http\FormRequest as BaseFormRequest;

class FormRequest extends  BaseFormRequest
{
    public function authorize()
    {
        return true;
    }
}