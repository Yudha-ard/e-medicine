<?php

namespace App\Models;

use App\Models\Transaksi;
use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $fillable = ['transaksi_id','obat_id','qty','total'];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
