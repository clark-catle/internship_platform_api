<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Application Moved to Decision Stage</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding:40px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
          <tr>
            <td style="padding:32px;">

              <h2 style="margin-top:0; color:#111827;">
                Your application has moved to the decision stage
              </h2>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Hi {{ $userName }},
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Your application for the internship position
                <strong>{{ $internshipTitle }}</strong>
                at <strong>{{ $companyName }}</strong>
                has successfully progressed past the interview stage.
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Your application is now in the <strong>decision stage</strong>, where the company will make a final decision regarding your application.
              </p>

              <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                <tr>
                  <td style="border-radius:6px; background-color:#4f46e5;">
                    <a href="{{ $applicationUrl }}" target="_blank" style="display:inline-block; padding:12px 24px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">
                      View Application
                    </a>
                  </td>
                </tr>
              </table>

              <p style="color:#6b7280; font-size:12px; line-height:1.6;">
                We'll notify you once the company has made a final decision on your application.
              </p>

              <p style="color:#9ca3af; font-size:12px;">
                Or copy this link into your browser:<br>
                <span style="word-break:break-all;">{{ $applicationUrl }}</span>
              </p>

            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>