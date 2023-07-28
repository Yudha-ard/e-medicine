<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->where('user_id', Auth::user()->id)
            ->orderBy('tgl_transaksi', 'DESC')
            ->paginate(10);

        return view('backend.pages.customer.transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        if ($transaksis->user_id !== Auth::user()->id) {
            Alert::error('error','Detail Transaksi Tidak Ditemukan');
            return redirect()->back();
        }
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.customer.transaksi.show', compact('transaksis','details'));
    }

    public function indexApotek()
    {
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->where('apotek_id', Auth::user()->apotek_id)
            ->orderBy('tgl_transaksi', 'DESC')
            ->paginate(10);

        return view('backend.pages.apoteker.transaksi.index', compact('transaksis'));
    }
    public function showApotek($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        
        if ($transaksis->apotek->id !== Auth::user()->apotek_id) {
            Alert::error('error','Detail Transaksi Tidak Ditemukan');
            return redirect()->back();
        }

        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.apoteker.transaksi.show', compact('transaksis', 'details'));
    }

    public function indexAdmin()
    {
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->orderBy('tgl_transaksi', 'DESC')
            ->paginate(10); 

        return view('backend.pages.admin.transaksi.index', compact('transaksis'));
    }

    public function showAdmin($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.admin.transaksi.show', compact('transaksis','details'));
    }
}
