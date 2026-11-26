<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // PENTING: Beritahu Laravel nama tabel yang sebenarnya
    protected $table = 'buku_digital';

    protected $fillable = [
        'judul', 'kode_url', 'penulis', 'kategori', 'lokasi_sampul',
        'lokasi_pratinjau', 'lokasi_berkas', 'jumlah_halaman', 'terjual',
        'harga', 'sudah_diterbitkan', 'is_bundle'
    ];

    // Scope untuk buku yang aktif (sudah diterbitkan & bukan bundle)
    public function scopeRegular($query)
    {
        return $query->where('sudah_diterbitkan', true)->where('is_bundle', false);
    }

    // Scope untuk buku bundle
    public function scopeBundle($query)
    {
        return $query->where('is_bundle', true);
    }
}
