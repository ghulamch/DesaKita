@extends('emails.layout')

@section('content')
    <h2>Halo, {{ $name }}!</h2>
    <p>Kami menerima permintaan atur ulang kata sandi untuk akun Anda di <strong>{{ $village_name }}</strong>.</p>
    <p>Silakan klik tombol di bawah ini untuk melanjutkan proses perubahan kata sandi Anda. Tautan ini akan kedaluwarsa dalam 60 menit.</p>
    
    <div style="text-align: center;">
        <a href="{{ $url }}" class="button">Atur Ulang Kata Sandi</a>
    </div>

    <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini. Keamanan akun Anda tetap terjaga.</p>

    <div class="divider"></div>
    
    <p style="font-size: 14px; color: #64748b;">Kesulitan klik tombol? Silakan gunakan tautan di bawah ini:</p>
    <p style="font-size: 13px; word-break: break-all;"><a href="{{ $url }}" style="color: #10b981;">{{ $url }}</a></p>
    
    <p>Salam hangat,<br><strong>Admin Desa</strong></p>
@endsection
