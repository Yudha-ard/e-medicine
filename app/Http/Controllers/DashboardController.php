<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Obat;
use App\Models\User;
use App\Models\Apotek;
use App\Models\Transaksi;
use App\Models\KategoriObat;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function customer()
    {
        $apoteks = Apotek::where('status', 'active')->get();
        $transaksis = Transaksi::whereIn('status', ['Accept', 'Delivered'])
            ->whereHas('detailTransaksi', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->orderBy('id', 'ASC')
            ->get();

        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->whereIn('transaksi_id', $transaksiID)
            ->select(DB::raw('MONTH(transaksi.tgl_transaksi) as month'), DB::raw('SUM(detail_transaksi.qty) as total_qty'))
            ->groupBy('month')
            ->get();

        $months = collect([
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'October', 'November', 'Desember',
        ]);

        $data = Transaksi::whereIn('status', ['Accept', 'Delivered'])
            ->whereYear('tgl_transaksi', Carbon::now()->year)
            ->selectRaw('MONTH(tgl_transaksi) as month, COUNT(*) as total_items, SUM(total) as total_transaksis')
            ->groupBy('month')
            ->get();

        $monthlyData = $months->map(function ($month, $index) use ($data, $details) {
            $monthData = $data->where('month', $index + 1)->first();
            $monthQty = $details->where('month', $index + 1)->sum('total_qty');

            return [
                'month' => $month,
                'total_transaksis' => $monthData ? $monthData->total_transaksis : 0,
                'total_items' => $monthData ? $monthData->total_items : 0,
                'total_qty' => $monthQty,
            ];
        });

        $transaksiIDs = Transaksi::whereIn('status', ['Accept', 'Delivered'])
        ->where('user_id', Auth::user()->id)
        ->pluck('id');
        
        $topItems = DetailTransaksi::whereIn('transaksi_id', $transaksiIDs)
            ->select('obat_id', DB::raw('SUM(qty) as total_qty'))
            ->with('obat.kategori')
            ->groupBy('obat_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();


        return view('backend.pages.customer.index',compact('apoteks', 'transaksis', 'details', 'monthlyData', 'topItems'));
    }

    public function admin()
    {
        $countApotek = Apotek::count();
        $countObat = Obat::count();
        $countKategori = KategoriObat::count();
        $countUser = User::count();
        $countTransaksi = Transaksi::count();
        $totalTransaksi = Transaksi::where('status', ['Accept','Delivered'])->sum('total');

        $months = collect([
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ]);

        $transaksiData = Transaksi::whereIn('status', ['Accept', 'Delivered'])
            ->whereYear('tgl_transaksi', Carbon::now()->year)
            ->selectRaw('MONTH(tgl_transaksi) as month, COUNT(*) as total_items, SUM(total) as total_transaksis')
            ->groupBy('month')
            ->get();

        $detailTransaksiData = DetailTransaksi::whereIn('transaksi_id', function ($query) {
            $query->select('id')
                ->from('transaksi')
                ->whereIn('status', ['Accept', 'Delivered'])
                ->whereYear('tgl_transaksi', Carbon::now()->year);
        })
            ->selectRaw('MONTH(created_at) as month, SUM(qty) as total_qty')
            ->groupBy('month')
            ->get();

        $itemSellCountData = [];
        foreach ($months as $index => $month) {
            $monthData = $detailTransaksiData->where('month', $index + 1)->first();
            $itemSellCountData[$month] = $monthData ? $monthData->total_qty : 0;
        }

        $chartData = [];
        foreach ($months as $index => $month) {
            $monthData = $transaksiData->where('month', $index + 1)->first();
            $chartData[] = [
                'month' => $month,
                'total' => $monthData ? $monthData->total_transaksis : 0,
            ];
        }

        $topItems = Obat::join('detail_transaksi', 'obat.id', '=', 'detail_transaksi.obat_id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->join('kategori_obat', 'obat.kategori_id', '=', 'kategori_obat.id')
            ->select('obat.id', 'obat.name', 'kategori_obat.name as kategori_name', 'obat.status as obat_status', 'transaksi.status as transaksi_status', DB::raw('SUM(detail_transaksi.qty) as total_qty'))
            ->whereIn('transaksi.status', ['Accept', 'Delivered'])
            ->groupBy('obat.id', 'obat.name', 'kategori_obat.name', 'obat.status', 'transaksi.status')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('backend.pages.admin.index', compact(
            'months',
            'countApotek',
            'countObat',
            'countKategori',
            'countUser',
            'countTransaksi',
            'totalTransaksi',
            'itemSellCountData',
            'chartData',
            'topItems'
        ));
    }

    public function apoteker()
    {
        $apotekId = Auth::user()->apotek_id;

        $sumTotalObat = Obat::where('apotek_id', Auth::user()->apotek_id)->count('stock');
        $sumTotalKategori = KategoriObat::count();
        $sumTotalCustomer = Transaksi::where('apotek_id', Auth::user()->apotek_id)->count('user_id');
        $sumTransaksi = Transaksi::where('apotek_id', Auth::user()->apotek_id)->whereIn('status', ['Delivered', 'Accept'])->count();
        $sumTotalTransaksi = Transaksi::where('apotek_id', Auth::user()->apotek_id)->whereIn('status', ['Delivered', 'Accept'])->sum('total');

        $months = collect([
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ]);

        $transaksiData = Transaksi::whereIn('status', ['Accept', 'Delivered'])
            ->whereYear('tgl_transaksi', Carbon::now()->year)
            ->where('apotek_id', $apotekId)
            ->selectRaw('MONTH(tgl_transaksi) as month, COUNT(*) as total_items, SUM(total) as total_transaksis')
            ->groupBy('month')
            ->get();

        $detailTransaksiData = DetailTransaksi::whereIn('transaksi_id', function ($query) use ($apotekId) {
                $query->select('id')
                    ->from('transaksi')
                    ->whereIn('status', ['Accept', 'Delivered'])
                    ->whereYear('tgl_transaksi', Carbon::now()->year)
                    ->where('apotek_id', $apotekId);
            })
            ->selectRaw('MONTH(created_at) as month, SUM(qty) as total_qty')
            ->groupBy('month')
            ->get();

        $itemSellCountData = [];
        foreach ($months as $index => $month) {
            $monthData = $detailTransaksiData->where('month', $index + 1)->first();
            $itemSellCountData[$month] = $monthData ? $monthData->total_qty : 0;
        }

        $chartData = [];
        foreach ($months as $index => $month) {
            $monthData = $transaksiData->where('month', $index + 1)->first();
            $chartData[] = [
                'month' => $month,
                'total' => $monthData ? $monthData->total_transaksis : 0,
            ];
        }

        $topItems = Obat::where('obat.apotek_id', Auth::user()->apotek_id)
            ->join('detail_transaksi', 'obat.id', '=', 'detail_transaksi.obat_id')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->join('kategori_obat', 'obat.kategori_id', '=', 'kategori_obat.id')
            ->select('obat.id', 'obat.name', 'kategori_obat.name as kategori_name', 'obat.status as obat_status', 'transaksi.status as transaksi_status', DB::raw('SUM(detail_transaksi.qty) as total_qty'))
            ->groupBy('obat.id', 'obat.name', 'kategori_obat.name', 'obat.status', 'transaksi.status')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('backend.pages.apoteker.index', compact(
            'sumTotalObat',
            'sumTotalKategori',
            'sumTotalCustomer',
            'sumTotalTransaksi',
            'sumTransaksi',
            'chartData',
            'itemSellCountData',
            'topItems'
        ));
    }

    public function kurir()
    {
        $transaksi = Transaksi::all();
        $transaksis = Transaksi::where('status', "Delivered")->orderBy('id', 'ASC')->limit(5)->get();
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        $monthlyCounts = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::createFromDate(null, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate(null, $month, 1)->endOfMonth();

            $count = Transaksi::where('status', 'Delivered')
                ->whereBetween('tgl_transaksi', [$startOfMonth, $endOfMonth])
                ->count();

            $monthlyCounts[] = $count;
        }

        return view('backend.pages.kurir.index', compact('transaksi', 'transaksis', 'details', 'monthlyCounts'));
    }
}
