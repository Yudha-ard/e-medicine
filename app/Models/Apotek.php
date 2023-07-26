<?php

namespace App\Models;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apotek extends Model
{
    use HasFactory;

    protected $table = 'apotek';
    protected $fillable = ['name','address','phone','status'];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'apotek_id');
    }
}
