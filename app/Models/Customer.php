<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'nama_customer'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'tsk_customer_id');
    }

    public function voucher()
    {
        return $this->hasMany(Voucher::class, 'vch_customer_id');
    }
}
