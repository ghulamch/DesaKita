@extends('emails.layout')

@section('content')
    <h2>Halo, {{ $name }}!</h2>
    <p>Selamat! Akun Anda di <strong>{{ $village_name }}</strong> kini telah resmi diaktifkan oleh Admin.</p>
    <p>Anda sekarang dapat masuk ke fitur Layanan Mandiri Warga menggunakan email dan password yang telah Anda daftarkan sebelumnya.</p>
    
    <div style="text-align: center;">
        <a href="{{ $url }}" class="button">Masuk ke Portal Desa</a>
    </div>

    <div class="divider"></div>
    
    <p style="font-size: 14px; color: #64748b;">Jika tombol di atas tidak berfungsi, silakan salin dan tempel tautan berikut di browser Anda:</p>
    <p style="font-size: 13px; word-break: break-all;"><a href="{{ $url }}" style="color: #10b981;">{{ $url }}</a></p>
    
    <p>Salam hangat,<br><strong>Admin Desa</strong></p>
@endsection
