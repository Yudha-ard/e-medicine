<?php

namespace App\Models;

use App\Models\Apotek;
use App\Models\KategoriObat;
use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $fillable = ['name','stock','harga','diskon','img_obat','kategori_id','apotek_id','status','deskripsi'];
    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function apotek()
    {
        return $this->belongsTo(Apotek::class, 'apotek_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'obat_id');
    }
}
