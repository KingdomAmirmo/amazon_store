<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;

class LoginRegisterController extends Controller
{
    public function loginRegisterForm()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();

        //check id is email or not
        if (filter_var($inputs['id'], FILTER_VALIDATE_EMAIL))
        {
            $type = 1; // 1 => email;
            $user = User::where('email', $inputs['id'])->first();
            if (empty($user)){
                $newUser['email'] = $inputs['id'];
            }
        }
        //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}+$/', $inputs['id']))
        {
            $type = 0; // 0 => mobile;

            //all mobile numbers are in on format 9** *** ***
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)){
                $newUser['mobile'] = $inputs['id'];
            }

        }

        else
        {
            $errorText = "شناسه ورودی شما نه شماره موبایل است نه ایمیل";
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => $errorText]);
        }


        if (empty($user))
        {
            $newUser['password'] = '98355154';
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }

        //create otp code
        $otp_code = rand(111111,999999);
        $token = Str::random(60);
        $otp_inputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otp_code,
            'login_id' => $inputs['id'],
            'type' => $type
        ];

        $result = Otp::query()->create($otp_inputs);

        //send sms
        if ($type == 0) {
            //send sms
            $url = 'https://console.melipayamak.com/api/send/simple/5ed2a9598d6241f29b1f1257c6925188';
            $data = array(
                'from' => '50002710071426',
                'to' => $user->mobile,
                'text' => "کد تایید : $otp_code\nبه مجموعه آمازون خوش آمدید ");
            $data_string = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

            // Next line makes the request absolute insecure
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Use it when you have trouble installing local issuer certificate
            // See https://stackoverflow.com/a/31830614/1743997

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $result = curl_exec($ch);
            curl_close($ch);

            // to debug
//             if(curl_errno($ch)){
//                 echo 'Curl error: ' . curl_error($ch);
//             }



// way 2
//            $smsService = new SmsService();
//            $smsService->setFrom(Config::get('sms.otp_from'));
//            $smsService->setTo(['0' . $user->mobile]);
//            $smsService->setText("مجموعه آمازون \n کد تایید شما : otp_code$");
//            $smsService->setIsFlash(true);
//
//            $messageService = new MessageService($smsService);
//
        }
        elseif ($type == 1) {
            //send email
            $emailService = new EmailService();
            $details = [
                'title' => "ایمیل فعال سازی",
                'body' => "کد فعال سازی شما : $otp_code ",
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('no-reply@example.com', 'فروشگاه آمازون');
            $emailService->setSubject("کداحراز هویت");
            $emailService->setTo($inputs['id']);
            $messageService = new MessageService($emailService);
//way2
            $messageService->send();

        }
//way2
//        $messageService->send();


        return redirect()->route('auth.customer.login-confirm-form', $token);

    }


    public function loginConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر می باشد']);
        }
        return view('customer.auth.login-confirm', compact('token', 'otp'));
    }

    public function loginConfirm($token, LoginRegisterRequest $request)
    {
        $inputs = $request->all();
        $otp = Otp::where('token', $token)->where('use', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => "آدرس وارد شده نامعتبر می باشد"]);
        }

        //if otp not match
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('auth.customer.login-confirm-form', $token)->withErrors(['otp' => "کد وارد شده صحیح نمی باشد"]);
        }

        //if everything is ok
        $otp->update(['use' => 1]);
        $user = $otp->user()->first();
        if ($otp->type == 0 && empty($user->mobile_verified_at))
        {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        }
        elseif ($otp->type == 1 && empty($user->email_verified_at))
        {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return redirect()->route('customer.home');

    }

    public function loginResendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر است']);
        }


        $user = $otp->user()->first();
        //create otp code
        $otp_code = rand(111111,999999);
        $token = Str::random(60);
        $otp_inputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otp_code,
            'login_id' => $otp->login_id,
            'type' => $otp->type
        ];

        $result = Otp::query()->create($otp_inputs);

        //send sms
        if ($otp->type == 0) {
            //send sms
            $url = 'https://console.melipayamak.com/api/send/simple/5ed2a9598d6241f29b1f1257c6925188';
            $data = array(
                'from' => '50002710071426',
                'to' => $user->mobile,
                'text' => "کد تایید : $otp_code\nبه مجموعه آمازون خوش آمدید ");
            $data_string = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

            // Next line makes the request absolute insecure
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Use it when you have trouble installing local issuer certificate
            // See https://stackoverflow.com/a/31830614/1743997

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $result = curl_exec($ch);
            curl_close($ch);

            // to debug
//             if(curl_errno($ch)){
//                 echo 'Curl error: ' . curl_error($ch);
//             }



// way 2
//            $smsService = new SmsService();
//            $smsService->setFrom(Config::get('sms.otp_from'));
//            $smsService->setTo(['0' . $user->mobile]);
//            $smsService->setText("مجموعه آمازون \n کد تایید شما : otp_code$");
//            $smsService->setIsFlash(true);
//
//            $messageService = new MessageService($smsService);
//
        }
        elseif ($otp->type == 1) {
            //sen email
            $emailService = new EmailService();
            $details = [
                'title' => "ایمیل فعال سازی",
                'body' => "کد فعال سازی شما : $otp_code ",
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('no-reply@example.com', 'فروشگاه آمازون');
            $emailService->setSubject("کداحراز هویت");
            $emailService->setTo($otp->login_id);
            $messageService = new MessageService($emailService);
//way2
            $messageService->send();

        }
//way2
//        $messageService->send();


        return redirect()->route('auth.customer.login-confirm-form', $token);

    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.home');
    }




}
