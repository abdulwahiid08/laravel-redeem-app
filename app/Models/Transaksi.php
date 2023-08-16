<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'tsk_customer_id',
        'kode_transaksi',
        'total_belanja',
        'ket_transaksi'
    ];

    // Relasi
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function voucher()
    {
        return $this->hasOne(Voucher::class, 'vch_transaksi_id');
    }
}
