<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\DynamicMailable;
use App\Models\SiteMeta;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function sendPasswordResetNotification($token)
    {
        $subject = SiteMeta::getVal('email_password_reset_subject', 'Instruksi Atur Ulang Kata Sandi');
        $url = route('password.reset', ['token' => $token, 'email' => $this->email]);

        try {
            Mail::to($this->email)->send(new DynamicMailable($subject, 'view:emails.password_reset', [
                'name' => $this->name,
                'email' => $this->email,
                'url' => $url,
                'village_name' => SiteMeta::getVal('village_name', 'Portal Desa')
            ]));
        } catch (\Exception $e) {
            \Log::error("Failed to send password reset email: " . $e->getMessage());
        }
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_APARATUR = 'aparatur';
    const ROLE_WARGA = 'warga';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'password',
        'is_active',
        'activation_token',
    ];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAparatur()
    {
        return $this->role === self::ROLE_APARATUR;
    }

    public function isWarga()
    {
        return $this->role === self::ROLE_WARGA;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
}
