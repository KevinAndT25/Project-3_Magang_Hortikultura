<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'no_hp',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relasi ke permohonan
     */
    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah pemohon
     */
    public function isPemohon()
    {
        return $this->role === 'pemohon';
    }

    /**
     * Ambil role dalam format yang lebih readable
     */
    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'pemohon' => 'Pemohon',
            default => 'User'
        };
    }

    /**
     * Ambil inisial nama untuk avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper($word[0]);
            }
        }
        return strlen($initials) > 2 ? substr($initials, 0, 2) : $initials;
    }

    /**
     * Ambil warna avatar berdasarkan nama
     */
    public function getAvatarColorAttribute()
    {
        $colors = ['#1a6e4a', '#27ae60', '#2ecc71', '#3498db', '#9b59b6', '#e67e22', '#e74c3c'];
        $index = abs(crc32($this->name)) % count($colors);
        return $colors[$index];
    }
}