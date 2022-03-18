<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'total_price',
    ];

    public function item()
    {
        return $this->hasMany(Item::class, 'transaction_id', 'id');
    }
}
