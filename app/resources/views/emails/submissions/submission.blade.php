{{-- Body --}}
<tr>
    <td>
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center">
                    <span style="font-size: 28px;">Hola {{ $data['user']->account->creativeData->first_name }},</span>
                </td>
            </tr>
            <tr><td height="20"></td></tr>
            <tr>
                <td align="center" style="padding: 0 15px;">
                    <span style="font-size: 16px;">Tu idea “{{ $data['submission']->name }}” fue <strong>cargada</strong> con éxito.</span>
                </td>
            </tr>
            <tr><td height="20"></td></tr>
            <tr>
                <td align="center" style="padding: 0 15px;">
                    <span style="font-size: 16px;">Dentro de las <strong>próximas 48hs</strong> recibirás un correo con las novedades del <strong>estado de la presentación</strong> de esta idea. </span>
                </td>
            </tr>
            <tr><td height="20"></td></tr>
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
                    <span style="font-size: 16px;">Recordá que la convocatoria {{ $data['submission']->announcement->company }} - “{{ $data['submission']->announcement->title }}” cierra el {{ $data['submission']->announcement->end_date }}.</span>
                </td>
            </tr>
            <tr><td height="30"></td></tr>
        </table>
    </td>
</tr>
