<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'discount_extend',
        'discount_upgrade',
        'extra_days',
        // tambahkan kolom lain jika perlu
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
