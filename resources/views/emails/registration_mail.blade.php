<table style="width: 600px; font-family: Verdana; background-color: #efefef; -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility;" role="presentation" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td>
            <img src="https://sklopi.live/images/ui/email_header.jpg" alt="sklopi logo header">
        </td>
    </tr>

    <tr>
        <td style="padding-left: 30px; padding-right: 30px;">
            <p style="margin-top: 40px; font-size: 24px;">@lang('emails.registration_mail.hello') <b>{{ $user->username }}</b>,</p>
        </td>
    </tr>

    <tr>
        <td style="padding-left: 30px; padding-right: 30px;">
            <p style="margin-top: 50px; font-size: 16px;">@lang('emails.registration_mail.successful_registration')</p>
        </td>
    </tr>

    <tr>
        <td style="padding-left: 30px; padding-right: 30px;">
            <p style="margin-top: 90px; margin-bottom: 50px; font-size: 14px;">@lang('emails.registration_mail.if_this_wasnt_you') <b>support@sklopi.live</b>.</p>
        </td>
    </tr>

    <tr style="background-color: #1a1a1a; width: 600px; height: 70px;">
        <td>
            <table style="color: #e9e9e9; width: 600px;" role="presentation" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td>
                        <table style="color: #e9e9e9; width: 600px;" role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="text-align: center;">
                                    <a style="color: #e9e9e9; text-decoration: none; font-size: 14px;" href="https://sklopi.live" target="_blank">sklopi.live</a>
                                    &nbsp;|&nbsp;
                                    <a style="color: #e9e9e9; text-decoration: none; font-size: 14px;" href="https://sklopi.live/terms-of-service" target="_blank">@lang('emails.general.terms_of_service')</a>
                                    &nbsp;|&nbsp;
                                    <a style="color: #e9e9e9; text-decoration: none; font-size: 14px;" href="https://sklopi.live/privacy-policy" target="_blank">@lang('emails.general.privacy_policy')</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p style="color: #bbb; text-align: center; display: block; margin-top: 10px; font-size: 12px; font-style: italic;">&copy;{{ date('Y') }} @lang('emails.general.all_rights_reserved')</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>