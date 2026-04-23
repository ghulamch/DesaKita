<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notifikasi Portal Desa' }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; line-height: 1.6; color: #334155; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: #10b981; padding: 40px 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { color: #d1fae5; margin: 5px 0 0; font-size: 14px; }
        .content { padding: 40px; }
        .content h2 { color: #1e293b; margin-top: 0; font-size: 20px; font-weight: 700; }
        .content p { margin-bottom: 20px; }
        .footer { background: #f1f5f9; padding: 20px; text-align: center; color: #64748b; font-size: 12px; }
        .button { display: inline-block; padding: 14px 30px; background-color: #10b981; color: #ffffff !important; text-decoration: none; border-radius: 12px; font-weight: 700; margin: 20px 0; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); }
        .button:hover { background-color: #059669; transform: translateY(-2px); }
        .divider { height: 1px; background: #e2e8f0; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $village_name ?? 'Portal Desa' }}</h1>
            <p>Layanan Digital Mandiri Warga</p>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Kantor Desa. Seluruh hak cipta dilindungi.<br>
            Jl. Raya Utama Kantor Desa.
        </div>
    </div>
</body>
</html>
