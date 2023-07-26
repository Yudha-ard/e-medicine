<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Apotek;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','email', 'password','img_profile','role','address','phone','status','apotek_id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function role(): Attribute {
        return new Attribute(
            get: fn ($value) =>  in_array($value, [0, 1, 2, 3]) ? ["customer", "administrator", "apoteker", "kurir"][$value] : 'anonymous',
        );
    }
    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function transaksisAsApoteker()
    {
        return $this->hasMany(Transaksi::class, 'apoteker');
    }

    public function transaksisAsKurir()
    {
        return $this->hasMany(Transaksi::class, 'kurir');
    }
}
