<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barangkeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function PeminjamanKeranjang()
    {
        return $this->hasMany(PeminjamanKeranjang::class);
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class);
    }

    public function pengembalianKeranjang()
    {
        return $this->hasMany(PengembalianKeranjang::class);
    }

    public function barcodekeranjang()
    {
        return $this->hasMany(BarcodeKeranjang::class);
    }
}