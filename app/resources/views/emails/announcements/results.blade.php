@component('mail::message')
# {{ $creative->account->creativeData->full_name }},

Hoy se publican los resultados de la convocatoria **{{ $announcement->title }}**, a la que estás suscripto.

Podrás ver los mismos, una vez publicados, visitando el siguiente link:

@component('mail::button', ['url' => '/contests/'.$announcement->id])
Ver resultados
@endcomponent

¡Saludos!<br>
El equipo de {{ config('app.name') }}
@endcomponent
