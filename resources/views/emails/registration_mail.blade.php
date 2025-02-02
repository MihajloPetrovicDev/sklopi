<table style="width: 600px">
    <tr>
        <td>
            <img src="/images/ui/email_header.jpg"></img>
        </td>
    </tr>

    <tr>
        <td>
            <p>@lang('emails.registration_mail.hello') {{ $user->username }},</p>
        </td>
    </tr>

    <tr>
        <td>
            <p>@lang('emails.registration_mail.successful_registration')</p>
        </td>
    </tr>

    <tr>
        <td>
            <p>@lang('emails.registration_mail.if_this_wasnt_you')</p>
        </td>
    </tr>

    <tr>
        <td>
            <p>www.sklopi.live</p>
        </td>

        <td>
            <p>@lang('emails.general.footer_text')</p>
        </td>
    </tr>
</table>