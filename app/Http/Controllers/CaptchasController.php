<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/17
 * Time: 17:07
 */
namespace App\Http\Controllers;

use App\Requests\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends  Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.str_random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->build();
        $expiredAt = date('Y-m-d H:i:s', time()+600);

       Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], 10);

//        $captchaData = Cache::get($key);
//        var_dump($captchaData);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt,
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}