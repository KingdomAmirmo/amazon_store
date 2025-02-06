<?php

namespace App\Jobs;

use App\Http\Services\Message\SMS\SmsService;
use App\Models\Notify\SMS;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sms;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNotNull('mobile')->get();
        foreach ($users as $user)
        {
            //send sms
            $url = 'https://console.melipayamak.com/api/send/simple/5ed2a9598d6241f29b1f1257c6925188';
            $data = array(
                'from' => '50002710071426',
                'to' => $user->mobile,
                'text' => $this->sms->body
            );
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

        }

    }
}
