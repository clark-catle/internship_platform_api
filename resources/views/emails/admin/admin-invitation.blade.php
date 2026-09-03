<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin Account Invitation</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding:40px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
          <tr>
            <td style="padding:32px;">

              <h2 style="margin-top:0; color:#111827;">
                Admin Account Invitation
              </h2>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Hello,
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                An administrator has invited you to create an account with
                <strong>administrator access</strong> to the system.
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Click the button below to complete your account creation. Once completed,
                your account will have administrator privileges.
              </p>

              <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                <tr>
                  <td style="border-radius:6px; background-color:#4f46e5;">
                    <a href="{{ $creationUrl }}"
                      target="_blank"
                      style="display:inline-block; padding:12px 24px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">
                      Create Admin Account
                    </a>
                  </td>
                </tr>
              </table>

              <p style="color:#6b7280; font-size:12px; line-height:1.6;">
                This invitation link is unique to your email address and may expire after
                <strong>30 minutes</strong>.
                If you were not expecting this invitation, you can safely ignore this email.
              </p>

              <p style="color:#9ca3af; font-size:12px;">
                Or copy this link into your browser:<br>
                <span style="word-break:break-all;">{{ $creationUrl }}</span>
              </p>

            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>