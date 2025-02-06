<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Notify\Email;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNotNull('email')->get();
        foreach ($users as $user)
        {
            $emailService = new EmailService();
            $details = [
                'title' => $this->email->subject,
                'body' => $this->email->body,

            ];
            $files = $this->email->files;
            $filePaths = [];
            foreach ($files as $file) {
                array_push($filePaths, $file->file_path);
            }
            $emailService->setDetails($details);
            $emailService->setFrom('no-reply@example.com', 'فروشگاه آمازون');
            $emailService->setSubject($this->email->subject);
            $emailService->setTo($user->email);
            $emailService->setEmailFiles($filePaths);
            $messageService = new MessageService($emailService);
            $messageService->send();
        }
    }
}
