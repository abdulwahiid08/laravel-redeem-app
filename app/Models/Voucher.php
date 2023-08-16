<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
        'vch_customer_id',
        'vch_transaksi_id',
        'kode_voucher',
        'status',
        'masa_berlaku',
    ];

    // Relasi
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
