<?php
/**
 * Created by PhpStorm.
 * User: zhangyajie
 * Date: 2019/10/17
 * Time: 14:02
 */
namespace App\Http\Controllers;


use App\Requests\VerificationCodeRequest;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;
use Carbon\Carbon;
class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request , EasySms $easySms)
    {
        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData) {
            return $this->response->error('图片验证码已失效', 422);
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }

        $phone = $captchaData['phone'];

        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
        $code = 1111;

        try {

            $result = $easySms->send($phone, [
                'content'  =>  "【Lbbs社区】您的验证码是{$code}。如非本人操作，请忽略本短信"
            ]);

        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('yunpian')->getMessage();
            return $this->response->errorInternal($message ?: '短信发送异常');
        }

        $key = 'verificationCode_'.str_random(15);

        $expiredAt = date('Y-m-d H:i:s', time()+600);

        Cache::put($key, ['phone'=>$phone, 'code'=>$code], 10);

        Cache::forget($request->captcha_key);

        return $this->response->array([
            'key' => $key,
            'expired_at'=>$expiredAt])
            ->setStatusCode(201);
    }
}