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

            @if($accepted)
                @include('emails.submissions.states._accepted', $data)
            @else
                @include('emails.submissions.states._rejected', $data)
            @endif

            <tr><td height="30"></td></tr>
        </table>
    </td>
</tr>
