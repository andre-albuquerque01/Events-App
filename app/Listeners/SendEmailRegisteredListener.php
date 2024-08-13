<?php

namespace App\Listeners;

use App\Events\VerifyEmailEvent;
use App\Mail\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class SendEmailRegisteredListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VerifyEmailEvent $event): void
    {
        Mail::to($event->email)->send(new VerifyEmail([
            'toEmail' => $event->email,
            'subject' => 'Verificar e-mail',
            'message' =>  Crypt::encryptString($event->email)
        ]));
    }
}
