@extends('emails.layout')

@section('content')
    <h2>Halo, {{ $name }}!</h2>
    <p>Terima kasih telah mendaftar di <strong>{{ $village_name }}</strong>.</p>
    <p>Akun Anda hampir siap. Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda secara mandiri:</p>
    
    <div style="text-align: center;">
        <a href="{{ $url }}" class="button">Aktifkan Akun Saya</a>
    </div>

    <p>Setelah diaktifkan, Anda dapat langsung masuk dan menikmati layanan digital kami.</p>

    <div class="divider"></div>
    
    <p style="font-size: 14px; color: #64748b;">Kesulitan klik tombol? Silakan gunakan tautan di bawah ini:</p>
    <p style="font-size: 13px; word-break: break-all;"><a href="{{ $url }}" style="color: #10b981;">{{ $url }}</a></p>
    
    <p>Salam hangat,<br><strong>Admin Desa</strong></p>
@endsection
