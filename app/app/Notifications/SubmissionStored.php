<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubmissionStored extends Notification
{
    use Queueable;
    public $submission;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($submission, $user)
    {
        //
        $this->submission = $submission;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->markdown('emails.custom', [
                'view' => 'emails.submissions.submission',
                'data' => [
                    'submission' => $this->submission,
                    'user' => $notifiable,
                ]
            ]);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    private function getSubject()
    {
        return 'Tu idea "'.$this->submission->name.'"" ha sido cargada con éxito';
    }

    private function buildBodyMessage()
    {
        $body = '<p>Hola ';
        $body .= $this->user->creative_data->first_name ?? $this->user->email;
        $body .= '</p>';

        $body .= '<p>Tu creación <a href="'.url('/profile/'.$this->user->account->creativeData->id).'" target="_blank">'.$this->submission->name.'</a> ha sido cargada con éxito en <a href="'.url('/contests/'.$this->submission->announcement->id).'" target="_blank">'.$this->submission->announcement->title.'</p>';

        $body .= '<p>Nuestros moderadores lo revisarán antes de ser aceptado en la convocatoria, dentro de las próximas 72 horas. Se te notificará através de un email cuando esté hecho</p>';

        $body .= '<p>Si no tienes novedades de nosotros, siempre puedes contactar al servicio de soporte técnico Conocimientos básicos.</p>';

        $body .= '<p>El equipo eÿeka</p>';

        $body .= '<p>Para preguntas generales y soporte, visitá nuestra sección Conocimientos básicos o contactanos a través del correo electrónico: <a href="support-es@eyeka.com" target="_blank">support-es@eyeka.com</a></p>';

        return $body;

    }
}
