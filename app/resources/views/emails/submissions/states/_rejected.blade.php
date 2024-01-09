<tr>
    <td align="center" style="padding: 0 15px;">
        <span style="font-size: 16px;">Lamentablemente, tu idea “{!! $data['submission']->name  !!}” ha sido rechazada con el siguiente comentario por parte del equipo de moderadores de Cantera Creativa:</span>
    </td>
</tr>

<tr><td height="30"></td></tr>

<tr>
    <td align="center" style="padding: 0 15px;">
        <span style="font-size: 16px;"><em>{!! $data['submission']->review_observation  !!}</em></span>
    </td>
</tr>

<tr><td height="30"></td></tr>

@if(date('Y-m-d') <= $data['submission']->announcement->end_date)
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">Te invitamos a que revises las pautas de la convocatoria y vuelvas a intentarlo subiendo otra idea. Recordá que tenés hasta el {{ $data['submission']->announcement->getFormatedDate('end_date') }}</span>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center">
            <a href="{{ url('/contests/'.$data['submission']->announcement->id) }}" class="button button-primary" target="_blank">Subir otra idea</a>
        </td>
    </tr>
@else
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">La convocatoria ya cerró el día {{ $data['submission']->announcement->getFormatedDate('end_date') }}. Te invitamos a que sigas poniendo a prueba tu creatividad participando en otras convocatorias.</span>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center">
            <a href="{{ url('/contests/') }}" class="button button-primary" target="_blank">Ver convocatorias</a>
        </td>
    </tr>
@endif
