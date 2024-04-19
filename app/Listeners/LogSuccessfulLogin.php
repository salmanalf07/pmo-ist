<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        Activity::create([
            'log_name' => 'Login',
            'description' => 'User logged in',
            'subject_id' => auth()->id(), // ID pengguna yang login
            'properties' => ['login_ip' => request()->ip()], // Informasi tambahan
        ]);
    }
}
