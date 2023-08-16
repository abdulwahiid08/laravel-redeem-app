<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $cekCustomer = Customer::where('user_id', Auth::user()->id)->first();

        // Membuat data customer berdasarkan data user
        if ($cekCustomer == null) {
            Customer::create([
                'user_id' => Auth::user()->id,
                'nama_customer' => Auth::user()->name
            ]);
        }

        return view('transaksi.index');
    }

    public function store(Request $request)
    {
        $cekCustomer = Customer::where('user_id', Auth::user()->id)->first();

        // Cek apakah user sudah jadi customer atau belem
        if ($cekCustomer == null) {
            return response()->json(['error' => 'Oppss! User belum terdaftar jadi customer']);
        }

        $idTransaksi = 'Invoice-' . uniqid();

        $data = Transaksi::create([
            'tsk_customer_id' => Auth::user()->customer->id,
            'kode_transaksi' => $idTransaksi,
            'total_belanja' => $request->total_belanja,
        ]);
        // set number format total belanja
        $data['totalBelanja'] = number_format($data->total_belanja);

        $dataVoucher = '';

        if ($request->total_belanja >= 1000000) {
            $kodeVoucher = str::random();

            $dataVoucher = Voucher::create([
                'vch_customer_id' => Auth::user()->customer->id,
                'vch_transaksi_id' => $data->id,
                'kode_voucher' => $kodeVoucher,
                'status' => 'aktif',
                'masa_berlaku' => now()->addMonth(3),
            ]);
        }

        return response()->json([
            'message' => 'Transaksi berhasil di proses',
            'data' => $data,
            'voucher' => $dataVoucher
        ]);
    }

    public function klaim(Request $request, $kode)
    {
        $getTransaksi = Transaksi::where('kode_transaksi', $kode)->first();
        // Cek Transaksi
        if (!$getTransaksi) {
            return response()->json(['error' => 'ID Transaksi tidak ditemukan, cek kembali ID Transaksi']);
        }

        $getVoucher = Voucher::where('vch_transaksi_id', $getTransaksi->id)->first();
        // Set Format Masa berlaku
        $getVoucher['masa_berlaku'] = date('d-M-Y', strtotime($getVoucher->masa_berlaku));

        return response()->json($getVoucher);
    }
}
