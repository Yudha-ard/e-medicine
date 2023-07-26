<?php

namespace App\Models;

use App\Models\User;
use App\Models\Apotek;
use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = ['tgl_transaksi','no_transaksi','pembayaran','user_id','apotek_id','total','paid','status'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function apotek()
    {
        return $this->belongsTo(Apotek::class, 'apotek_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'detail_transaksis', 'transaksi_id', 'obat_id')
            ->withPivot('qty', 'total')
            ->withTimestamps();
    }
}
