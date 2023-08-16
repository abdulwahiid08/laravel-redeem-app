<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function redeem(Request $request, $kode)
    {
        // dd('Kode berjalan' . $kode);

        $voucher = Voucher::where('kode_voucher', $kode)
            ->where('status', 'aktif')
            ->where('masa_berlaku', '>', now())
            ->first();

        if (!$voucher) {
            return response()->json(['error' => 'Yahhh! Voucher anda sudah kadaluarsa']);
        }

        $voucher['status'] = 'redeem';
        $voucher->save();

        return response()->json(['message' => 'Yeayy! Voucher berhasil di klaim']);
    }
}
