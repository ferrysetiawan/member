<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['nama_produk', 'kategori_id', 'satuan'];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id');
    }

    public function r01a()
    {
        return $this->belongsToMany(R01A::class, 'menu_r01a', 'menu_id', 'r01_a_id')->withPivot('quantity');;
    }
}
