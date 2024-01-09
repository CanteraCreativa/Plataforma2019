<tr>
    <td align="center" style="padding: 0 15px;">
        <span style="font-size: 16px;">¡Tu idea “{{ $data['submission']->name }}” fue <strong>aceptada</strong>!</span><br>
        <span style="font-size: 16px;">Ya está siendo analizada por la marca. Te mantendremos al tanto de todo.</span>
    </td>
</tr>

<tr><td height="30"></td></tr>

@if(date('Y-m-d') <= $data['submission']->announcement->end_date)
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">¿Tenés otra idea en tu cabeza? Sumala. Acordate que podés presentar más de una idea por convocatoria.</span>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center">
            <a href="{{ url('/contests/'.$data['submission']->announcement->id) }}" class="button button-primary" target="_blank">Subir otra idea</a>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">Recordá que la convocatoria {{ $data['submission']->announcement->company }} - “{{ $data['submission']->announcement->title }}” cierra el {{ $data['submission']->announcement->getFormatedDate('end_date') }}.</span>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">En el caso de que tu idea resulte seleccionada por la marca, serás contactado por este medio.</span>
        </td>
    </tr>
@else
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">En el caso de que tu idea resulte seleccionada por la marca, serás contactado por este medio.</span>
        </td>
    </tr>
    <tr><td align="center" height="30"></td></tr>
    <tr>
        <td align="center" style="padding: 0 15px;">
            <span style="font-size: 16px;">Esta convocatoria ya cerró el {{ $data['submission']->announcement->getFormatedDate('end_date') }}. Te invitamos a que sigas poniendo a prueba tu creatividad participando en otras convocatorias.</span>
        </td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td align="center">
            <a href="{{ url('/contests/') }}" class="button button-primary" target="_blank">Ver convocatorias</a>
        </td>
    </tr>
@endif
