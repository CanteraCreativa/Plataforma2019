<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
//    use Queueable;

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $prefix = request()->root() . '/verify/creative?verificationURL=';
        $temporarySignedURL = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        );

        \Log::info($temporarySignedURL);

        return $temporarySignedURL;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('¡Te damos la bienvenida a Cantera Creativa!')
            ->markdown('emails.custom', [
                'view' => 'emails.auth.verify_email',
                'data' => [
                    'url' => $this->verificationUrl($notifiable),
                    'user' => $notifiable,
                ]
            ]);
    }
}
