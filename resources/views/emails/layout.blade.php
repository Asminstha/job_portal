<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
               background: #f3f4f6; color: #1f2937; line-height: 1.6; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff;
                   border-radius: 12px; overflow: hidden;
                   box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { background: #2563eb; padding: 32px 40px; text-align: center; }
        .header h1 { color: #fff; font-size: 24px; font-weight: 700; }
        .header p { color: #bfdbfe; font-size: 14px; margin-top: 4px; }
        .body { padding: 40px; }
        .body h2 { font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 12px; }
        .body p { font-size: 15px; color: #374151; margin-bottom: 16px; }
        .info-box { background: #f9fafb; border: 1px solid #e5e7eb;
                    border-radius: 8px; padding: 20px; margin: 20px 0; }
        .info-row { display: flex; justify-content: space-between;
                    padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 13px; color: #6b7280; }
        .info-value { font-size: 13px; font-weight: 600; color: #111827; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 999px;
                 font-size: 12px; font-weight: 600; }
        .badge-green  { background: #dcfce7; color: #166534; }
        .badge-yellow { background: #fef9c3; color: #854d0e; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }
        .badge-purple { background: #ede9fe; color: #5b21b6; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .btn { display: inline-block; padding: 12px 28px; background: #2563eb;
               color: #fff; text-decoration: none; border-radius: 8px;
               font-weight: 600; font-size: 15px; margin: 16px 0; }
        .btn-outline { background: #fff; color: #2563eb;
                       border: 2px solid #2563eb; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb;
                  padding: 24px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; }
        .footer a { color: #6b7280; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Jobs<span style="color:#93c5fd">Nepal</span></h1>
        <p>Nepal's Modern Job Portal</p>
    </div>
    <div class="body">
        @yield('content')
    </div>
    <div class="footer">
        <p>
            &copy; {{ date('Y') }} JobsNepal &nbsp;·&nbsp;
            <a href="{{ config('app.url') }}">Visit our website</a>
        </p>
        <p style="margin-top:8px;">
            You received this email because you have an account on JobsNepal.
        </p>
    </div>
</div>
</body>
</html>
