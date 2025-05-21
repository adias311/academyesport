<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSub extends Model
{
    use HasFactory;
    
    protected $table = 'user_subs';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'remain_date',
    ];

    protected $dates = [
        'remain_date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
