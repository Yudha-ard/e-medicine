<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.customer.riwayat.index', compact(['transaksis','details']));
    }

    public function show($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        if ($transaksis->user_id !== Auth::user()->id) {
            Alert::error('error','Detail Transaksi Tidak Ditemukan');
            return redirect()->back();
        }
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.customer.riwayat.show', compact('transaksis','details'));
    }
    public function indexApotek()
    {
        $transaksis = Transaksi::where('apotek_id', Auth::user()->apotek_id)->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.apoteker.riwayat.index', compact(['transaksis','details']));
    }

    public function showApotek($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        if ($transaksis->apotek->id !== Auth::user()->apotek_id) {
            Alert::error('error','Detail Transaksi Tidak Ditemukan');
            return redirect()->back();
        }
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.apoteker.riwayat.show', compact('transaksis','details'));
    }
    public function indexAdmin()
    {
        $transaksis = Transaksi::orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.admin.riwayat.index', compact(['transaksis','details']));
    }

    public function showAdmin($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.admin.riwayat.show', compact('transaksis','details'));
    }
    public function indexKurir()
    {
        $transaksis = Transaksi::where('status', "Delivered")->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.kurir.riwayat.index', compact(['transaksis','details']));
    }

    public function showKurir($id)
    {
        $transaksis = Transaksi::findOrFail($id);
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.kurir.riwayat.show', compact('transaksis','details'));
    }

}
