<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Internship Posting Removed</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding:40px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
          <tr>
            <td style="padding:32px;">

              <h2 style="margin-top:0; color:#111827;">
                Internship Posting Removed
              </h2>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                Hi {{ $userName }},
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                This is to inform you that your internship posting
                <strong>{{ $internshipTitle }}</strong>
                has been removed by an administrator.
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                As a result of the removal, all applications submitted for this internship have been <strong>rejected</strong> and will no longer proceed through the application process.
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                The internship posting is no longer available on the platform and cannot receive or process additional applications.
              </p>

              <p style="color:#374151; font-size:14px; line-height:1.6;">
                <strong>Reason for removal:</strong><br>
                {{ $reason }}
              </p>

              <p style="color:#6b7280; font-size:12px; line-height:1.6;">
                If you believe this action was made in error or require further clarification, please contact the platform administrator.
              </p>

              <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                <tr>
                  <td style="border-radius:6px; background-color:#4f46e5;">
                    <a href="{{ $internshipUrl }}"
                      target="_blank"
                      style="display:inline-block; padding:12px 24px; font-size:14px; color:#ffffff; text-decoration:none; font-weight:bold;">
                      View Profile
                    </a>
                  </td>
                </tr>
              </table>

              <p style="color:#9ca3af; font-size:12px;">
                If the button does not work, copy this link into your browser:<br>
                <span style="word-break:break-all;">{{ $internshipUrl }}</span>
              </p>

            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>