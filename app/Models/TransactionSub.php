<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSub extends Model
{
    protected $table = 'transaction_subs';

    protected $fillable = [
        'transaction_id',
        'grandtotal',
        'discount',
    ];

    /**
     * Relasi ke model Transaction (Many to One).
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
