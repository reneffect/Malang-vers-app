<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $table = 'buku_digital';

    protected $fillable = [
        'judul',
        'kode_url',
        'penulis',
        'kategori',
        'lokasi_sampul',
        'lokasi_pratinjau',
        'lokasi_berkas',
        'jumlah_halaman',
        'terjual',
        'harga',
        'sudah_diterbitkan',
        'is_bundle',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'terjual' => 'integer',
        'jumlah_halaman' => 'integer',
        'is_bundle' => 'boolean',
        'sudah_diterbitkan' => 'boolean',
    ];

    public function scopeRegular($query)
    {
        return $query->where('is_bundle', false)->where('sudah_diterbitkan', true);
    }

    public function scopeBundle($query)
    {
        return $query->where('is_bundle', true)->where('sudah_diterbitkan', true);
    }

    public function scopeActive($query)
    {
        return $query->where('sudah_diterbitkan', true);
    }
}
