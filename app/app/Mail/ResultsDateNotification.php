<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResultsDateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $creative;
    public $announcement;


    public function __construct(\App\User $creative, \App\Models\Announcement $announcement)
    {
        $this->creative     = $creative;
        $this->announcement = $announcement;
    }


    public function build()
    {
        return $this->markdown('emails.announcements.results')
                    ->subject('Hoy se publican los resultados de una convocatoria en la que estás suscripto!');
    }
}
