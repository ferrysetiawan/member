<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class R01A extends Model
{
    protected $table = 'r01_a';
    protected $fillable = [
        'customer_id',
        'delivery_date',
        'gambar',
        'notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'menu_r01a', 'r01_a_id', 'menu_id')->withPivot('quantity');;
    }
}
