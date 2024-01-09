<?php

namespace App\Notifications;

use App\Enums\SubmissionState;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReviewSubmission extends Notification
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
                'view' => 'emails.submissions.state',
                'data' => [
                    'submission' => $this->submission,
                    'user' => $notifiable,
                    'accepted' => $this->submission->state->is(SubmissionState::Accepted)
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
        $subject = 'Tu idea '.$this->submission->name;
        if($this->submission->state->is(SubmissionState::Accepted)) {
            $subject = 'Tu idea "'.$this->submission->name.'" fue aceptada';
        } else {
            $subject = 'Convocatoria "'.$this->submission->announcement->title.'"';
        }
        return $subject;
    }

    private function buildBodyMessage()
    {
        $body = '<p>Hola ';
        $body .= $this->user->creative_data->first_name ?? $this->user->email;
        $body .= '</p>';

        if($this->submission->state->is(SubmissionState::Accepted)) {

            $body .= '<p>Tu creación <a href="'.url('/profile/'.$this->user->account->creativeData->id).'" target="_blank">'.$this->submission->name.'</a> ha sido aceptada en la convocatoria <a href="'.url('/contests/'.$this->submission->announcement->id).'" target="_blank">'.$this->submission->announcement->title.'</p>';
            $body .= '<p>Te recordamos que, según la normativa de la convocatoria, está terminantemente prohibido: </p>';
            $body .= '<ul>';
            $body .= '<li>Mostrar las creaciones de otros participantes fuera de la convocatoria</li>';
            $body .= '<li>Insinuar que el cliente ha aprobado la creación</li>';
            $body .= '<li>Hacer referencia al cliente cuando uses la creación</li>';
            $body .= '<li>Usar el logotipo o el material del cliente después de la convocatoria</li>';
            $body .= '</ul>';

            $body .= '<p>Informate más detalladamente sobre el uso de tus medios fuera de eÿeka en Conocimientos básicos.</p>';

            $body .= '<p>¡Los ganadores serán anunciados el '.$this->submission->announcement->results_date.', seguí atento ya que recibirás estas importantes novedades en tu buzón de correos! Para poder ser seleccionado como ganador adicional, no comuniques a nadie tu participación den la convocatoria hasta el '.$this->submission->announcement->results_date.'</p>';

        } else {
            $body .= '<p>Por el momento, tu entrada '.$this->submission->name.' no respecta todos los requisitos del brief. Algunas pautas aún no fueron cumplidas, ¡pero estás cerca! A continuación, encontrarás las mejoras necesarias:</p>';
            $body .= '<p><em>'.$this->submission->review_observation.'</em></p>';
            $body .= '<p>Cuando estés listo, volvé a cargar tu entrada revisada desde la <a href="'.url('/contests/'.$this->submission->announcement->id).'" target="_blank">pestaña de carga</a> antes del '.$this->submission->announcement->end_date.'</p>';
            $body .= '<p>¡Nos gusta mucho tu idea y esperamos ver los cambios pronto!</p>';
            $body .= '<p>Leé los lineamientos creativos de eYeka sobre cómo crear una obra ganadora aquí.</p>';
        }

        $body .= '<p>El equipo eÿeka</p>';

        $body .= '<p>Para preguntas generales y soporte, visitá nuestra sección Conocimientos básicos o contactanos a través del correo electrónico: <a href="support-es@eyeka.com" target="_blank">support-es@eyeka.com</a></p>';

        return $body;

    }
}
