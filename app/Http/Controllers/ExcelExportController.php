<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
class ExcelExportController extends Controller
{
    public function exportOrderKurir() {

        $transaksis = Transaksi::where('status', 'Accept')->orderBy('id', 'ASC')->get();
        $transaksiID = $transaksis->pluck('id');
        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $details->sum('total_qty');
        
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Order Kurir] -".Carbon::now()->format('Y-m-d-H:i').".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );
        
            $header = array('No', 'No Transaksi', 'Tanggal', 'Total', 'Method', 'Apotek', 'Qty', 'Status');
            $footer = array('', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'), '', 'Total', $totalQty, '');
        
            $callback = function () use ($transaksis, $details, $header, $footer) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $header);
                $i = 1;
                foreach ($transaksis as $transaksi) {
                    $detail = $details->where('transaksi_id', $transaksi->id)->first();
                    $data = array(
                        $i++,
                        $transaksi->no_transaksi,
                        $transaksi->tgl_transaksi,
                        'Rp '.number_format($transaksi->total, 2, ',', '.'),
                        $transaksi->pembayaran,
                        $transaksi->apotek->name,
                        $detail->total_qty,
                        $transaksi->status
                    );
        
                    fputcsv($file, $data);
                }
        
                fputcsv($file, $footer);
        
                fclose($file);
            };
        
            return response()->stream($callback, 200, $headers);
        }

    public function exportRiwayatKurir() {
        $transaksis = Transaksi::where('status', "Delivered")->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();
        
        $totalTransaksi = $transaksis->sum('total');
        $totalQty = $details->sum('total_qty');

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=[Laporan Riwayat Kurir] -".Carbon::now()->format('Y-m-d-H:i').".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );

        $header = array('No', 'No Transaksi', 'Tanggal', 'Total', 'Method', 'Qty', 'Status');
        $footer = array('', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'), 'Total', $totalQty, '');

        $callback = function () use ($transaksis, $details, $header, $footer) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $header);
            $i = 1;
            foreach ($transaksis as $transaksi) {
                $detail = $details->where('transaksi_id', $transaksi->id)->first();
                $data = array(
                    $i++,
                    $transaksi->no_transaksi,
                    $transaksi->tgl_transaksi,
                    'Rp '.number_format($transaksi->total, 2, ',', '.'),
                    $transaksi->pembayaran,
                    $detail->total_qty,
                    $transaksi->status
                );

                fputcsv($file, $data);
            }

            fputcsv($file, $footer);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function exportTransaksiCustomer()
    {
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->where('user_id', Auth::user()->id)
            ->orderBy('tgl_transaksi', 'DESC')
            ->get();

        $totalTransaksi = $transaksis->sum('total');
        $totalQty = $transaksis->sum(function ($transaksi) {
            return $transaksi->detailTransaksi->sum('qty');
        });

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=[Laporan Transaksi Customer] -" . Carbon::now()->format('Y-m-d-H:i') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );

        $file = fopen('php://output', 'w');

        fputcsv($file, ['No', 'No Transaksi', 'Tanggal', 'Obat', 'Qty', 'Diskon', 'Harga', 'Total', 'Method', 'Apotek', 'Status']);

        $i = 1;
        foreach ($transaksis as $transaksi) {
            foreach ($transaksi->detailTransaksi as $detail) {
                fputcsv($file, [
                    $i++,
                    $transaksi->no_transaksi,
                    $transaksi->tgl_transaksi,
                    $detail->obat->name,
                    $detail->qty,
                    $detail->obat->diskon,
                    'Rp '.number_format($detail->obat->harga, 2, ',', '.'),
                    'Rp '.number_format($detail->total, 2, ',', '.'),
                    $transaksi->pembayaran,
                    $transaksi->apotek->name,
                    $transaksi->status,
                ]);
            }
        }

        fputcsv($file, ['', '', '', 'Total',$totalQty, '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'),'', ]);

        fclose($file);

        $response = Response::make('', 200, $headers);
        $response->sendHeaders();
        readfile('php://output');
        exit;
    }
    public function exportRiwayatCustomer()
    {
        $transaksis = Transaksi::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        $totalTransaksi = $transaksis->sum('total');
        $totalQty = $details->sum('total_qty');

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=[Laporan Riwayat Customer] -".Carbon::now()->format('Y-m-d-H:i').".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );

        $header = array('No', 'No Transaksi', 'Tanggal', 'Total', 'Method', 'Apotek', 'Qty', 'Status');
        $footer = array('', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'), '', 'Total', $totalQty, '');

        $callback = function () use ($transaksis, $details, $header, $footer) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $header);
            $i = 1;
            foreach ($transaksis as $transaksi) {
                $detail = $details->where('transaksi_id', $transaksi->id)->first();
                $data = array(
                    $i++,
                    $transaksi->no_transaksi,
                    $transaksi->tgl_transaksi,
                    'Rp '.number_format($transaksi->total, 2, ',', '.'),
                    $transaksi->pembayaran,
                    $transaksi->apotek->name,
                    $detail->total_qty,
                    $transaksi->status
                );

                fputcsv($file, $data);
            }

            fputcsv($file, $footer);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportOrderApotek() {
        $transaksis = Transaksi::where('apotek_id', Auth::user()->apotek_id)->orderBy('id', 'ASC')->get();
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $details->sum('total_qty');
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Order ".Auth::user()->apotek->name."] - ".Carbon::now()->format('Y-m-d-H:i').".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );
    
            $header = array('No', 'No Transaksi', 'Tanggal', 'Total', 'Method', 'Apotek', 'Qty', 'Status');
            $footer = array('', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'), '', 'Total', $totalQty, '');
    
            $callback = function () use ($transaksis, $details, $header, $footer) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $header);
                $i = 1;
                foreach ($transaksis as $transaksi) {
                    $detail = $details->where('transaksi_id', $transaksi->id)->first();
                    $data = array(
                        $i++,
                        $transaksi->no_transaksi,
                        $transaksi->tgl_transaksi,
                        'Rp '.number_format($transaksi->total, 2, ',', '.'),
                        $transaksi->pembayaran,
                        $transaksi->apotek->name,
                        $detail->total_qty,
                        $transaksi->status
                    );
    
                    fputcsv($file, $data);
                }
    
                fputcsv($file, $footer);
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
    }
    public function exportTransaksiApotek() {
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->where('apotek_id', Auth::user()->apotek_id)
            ->orderBy('tgl_transaksi', 'DESC')
            ->get();

            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $transaksis->sum(function ($transaksi) {
                return $transaksi->detailTransaksi->sum('qty');
            });
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Transaksi ".Auth::user()->apotek->name."] - ".Carbon::now()->format('Y-m-d-H:i').".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );

            $file = fopen('php://output', 'w');
    
            fputcsv($file, ['No', 'No Transaksi', 'Tanggal', 'Obat', 'Qty', 'Diskon', 'Harga', 'Total', 'Method', 'Status']);
    
            $i = 1;
            foreach ($transaksis as $transaksi) {
                foreach ($transaksi->detailTransaksi as $detail) {
                    fputcsv($file, [
                        $i++,
                        $transaksi->no_transaksi,
                        $transaksi->tgl_transaksi,
                        $detail->obat->name,
                        $detail->qty,
                        $detail->obat->diskon,
                        'Rp '.number_format($detail->obat->harga, 2, ',', '.'),
                        'Rp '.number_format($detail->total, 2, ',', '.'),
                        $transaksi->pembayaran,
                        $transaksi->status,
                    ]);
                }
            }
    
            fputcsv($file, ['', '', '', 'Total',$totalQty, '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'),'', ]);
    
            fclose($file);
    
            $response = Response::make('', 200, $headers);
            $response->sendHeaders();
            readfile('php://output');
            exit;

    }
    public function exportRiwayatApotek() {
        $transaksis = Transaksi::where('apotek_id', Auth::user()->apotek_id)->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();
        
            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $details->sum('total_qty');
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Riwayat ".Auth::user()->apotek->name."] - ".Carbon::now()->format('Y-m-d-H:i').".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );
    
            $header = array('No', 'No Transaksi', 'Tanggal', 'Total', 'Method', 'Qty', 'Status');
            $footer = array('', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'), 'Total', $totalQty, '');
    
            $callback = function () use ($transaksis, $details, $header, $footer) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $header);
                $i = 1;
                foreach ($transaksis as $transaksi) {
                    $detail = $details->where('transaksi_id', $transaksi->id)->first();
                    $data = array(
                        $i++,
                        $transaksi->no_transaksi,
                        $transaksi->tgl_transaksi,
                        'Rp '.number_format($transaksi->total, 2, ',', '.'),
                        $transaksi->pembayaran,
                        $detail->total_qty,
                        $transaksi->status
                    );
    
                    fputcsv($file, $data);
                }
    
                fputcsv($file, $footer);
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
    }

    public function exportRiwayatAdmin() {
        $transaksis = Transaksi::orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();
        
            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $details->sum('total_qty');
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Riwayat] - ".Carbon::now()->format('Y-m-d-H:i').".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );
    
            $header = array('No', 'No Transaksi', 'Name', 'Tanggal', 'Total', 'Method', 'Apotek', 'Qty', 'Status');
            $footer = array('', '', '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'),'', 'Total', $totalQty, '');
    
            $callback = function () use ($transaksis, $details, $header, $footer) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $header);
                $i = 1;
                foreach ($transaksis as $transaksi) {
                    $detail = $details->where('transaksi_id', $transaksi->id)->first();
                    $data = array(
                        $i++,
                        $transaksi->no_transaksi,
                        $transaksi->user->name,
                        $transaksi->tgl_transaksi,
                        'Rp '.number_format($transaksi->total, 2, ',', '.'),
                        $transaksi->pembayaran,
                        $transaksi->apotek->name,
                        $detail->total_qty,
                        $transaksi->status
                    );
    
                    fputcsv($file, $data);
                }
    
                fputcsv($file, $footer);
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
    }

    public function exportTransaksiAdmin() {
    
        $transaksis = Transaksi::with(['detailTransaksi', 'apotek'])
            ->orderBy('tgl_transaksi', 'DESC')
            ->get(); 

            $totalTransaksi = $transaksis->sum('total');
            $totalQty = $transaksis->sum(function ($transaksi) {
                return $transaksi->detailTransaksi->sum('qty');
            });

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=[Laporan Transaksi] -" . Carbon::now()->format('Y-m-d-H:i') . ".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            );

            $file = fopen('php://output', 'w');

            fputcsv($file, ['No', 'User', 'No Transaksi', 'Tanggal','Obat','Qty','Diskon','Harga','Total','Method','Apotek ','Status']);

                $i = 1;

                foreach ($transaksis as $transaksi) {
                    foreach ($transaksi->detailTransaksi as $detail) {
                        fputcsv($file, [
                            $i++,
                            $transaksi->user->name,
                            $transaksi->no_transaksi,
                            $transaksi->tgl_transaksi,
                            $detail->obat->name,
                            $detail->qty,
                            $detail->obat->diskon,
                            'Rp '.number_format($detail->obat->harga, 2, ',', '.'),
                            'Rp '.number_format($detail->total, 2, ',', '.'),
                            $transaksi->pembayaran,
                            $transaksi->apotek->name,
                            $transaksi->status
                        ]);
                    }
                }
        
            fputcsv($file, ['', '', '', '', 'Total',$totalQty, '', 'Total', 'Rp '.number_format($totalTransaksi, 2, ',', '.'),'',]);
        
            fclose($file);
        
            $response = Response::make('', 200, $headers);
            $response->sendHeaders();
            readfile('php://output');
            exit;
        
    }
}
