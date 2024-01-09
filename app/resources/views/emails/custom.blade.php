@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        <tr>
            <td>
                <table class="inner-body" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td bgcolor="#f95568" height="10"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="inner-body" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td height="15"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <img src="{{ url('/') }}/images/cantera-logo-colors.png" />
                        </td>
                    </tr>
                    <tr>
                        <td height="15"></td>
                    </tr>
                </table>
            </td>
        </tr>
    @endslot

    {{-- Body --}}
    @include($view, $data)

    {{-- Footer --}}
    @slot('subcopy')
        <table class="inner-body" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#F2F2F2" style="background: #F2F2F2;">
            <tr><td height="10"></td></tr>
            <tr>
                <td align="center">
                    <span style="font-size: 16px;">En el caso de que tengas alguna duda, podés <a href="mailto:contacto@canteracreativa.com">escribirnos acá.</a></span>
                </td>
            </tr>
            <tr><td height="20"></td></tr>
            <tr>
                <td align="center">
                    <span style="font-size: 16px;color: #f95568;">El equipo de Cantera Creativa</span>
                </td>
            </tr>
            <tr><td height="20"></td></tr>
            <tr>
                <td align="center">
                    <span style="font-size: 14px;">Este es un mensaje automático de la plataforma de Cantera Creativa.<br>Si recibiste este mensaje por error, por favor desestimalo.</span>
                </td>
            </tr>
            <tr><td height="10"></td></tr>
        </table>
    @endslot


    {{-- Footer --}}
    @slot('footer')
        <table class="inner-body" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#9C9A9B" style="background: #9C9A9B;">
            <tr><td height="10"></td></tr>
            <tr>
                <td width="150">&nbsp;</td>
                <td align="center" width="300">
                    <table align="center" width="300" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#9C9A9B" style="background: #9C9A9B;">
                        <tr>
                            <td align="center" width="25%">
                                <a href="mailto:contacto@canteracreativa.com" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="{{ url('/') }}/images/social-sobre.png" />
                                </a>
                            </td>
                            <td align="center" width="25%">
                                <a href="https://www.instagram.com/canteracreativa/" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="{{ url('/') }}/images/social-ig.png" />
                                </a>
                            </td>
                            <td align="center" width="25%">
                                <a href="https://www.facebook.com/CanteraCreativa/" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="{{ url('/') }}/images/social-fb.png" />
                                </a>
                            </td>
                            <td align="center" width="25%">
                                <a href="https://www.linkedin.com/company/canteracreativa/" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="{{ url('/') }}/images/social-in.png" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="150">&nbsp;</td>
            </tr>
            <tr><td height="10"></td></tr>
        </table>
    @endslot

@endcomponent
