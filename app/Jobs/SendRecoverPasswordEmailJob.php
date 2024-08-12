<?php

namespace App\Jobs;

use App\Events\RecoverPasswordEmailEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRecoverPasswordEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $email, public string $token)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new RecoverPasswordEmailEvent($this->email, $this->token));
    }
}
