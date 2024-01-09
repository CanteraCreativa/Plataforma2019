{{-- Body --}}
<tr>
    <td>
        <table class="inner-body" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center">
                    <span style="font-size: 28px;">Hola {{ $data['user']->email }},</span>
                </td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td align="center" style="padding: 0 15px;">
                    <span style="font-size: 16px;">Este es un mensaje automático de Cantera Creativa, con la finalidad de validar tu correo electrónico como parte del proceso de creación de cuenta.</span>
                </td>
            </tr>
            <tr><td height="30"></td></tr>
            <tr>
                <td align="center" style="padding: 0 15px;">
                    <span style="font-size: 16px;">Por favor, para continuar hacé click en el botón de acá abajo; serás redirigido en una nueva pestaña hacia tu nuevo Perfil en la plataforma.</span>
                </td>
            </tr>
            <tr><td height="30"></td></tr>
            <tr>
                <td align="center">
                    <a href="{{ $data['url'] }}" class="button button-primary" target="_blank">Validar mi cuenta</a>
                </td>
            </tr>
            <tr><td height="30"></td></tr>
            <tr>
                <td align="center" style="padding: 0 15px;">
                    <span style="font-size: 14px;">Si el botón no funciona, copiá y pegá el siguiente enlace en el campo de direcciones de tu navegador:<br>
                        <a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a>
                    </span>
                </td>
            </tr>
            <tr><td height="10"></td></tr>
        </table>
    </td>
</tr>
