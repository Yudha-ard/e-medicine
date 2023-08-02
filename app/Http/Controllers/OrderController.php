<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Apotek;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index() {

        $apoteks = Apotek::where('status', 'active')->orderBy('id', 'ASC')->paginate(10);
     
        if(Auth::user()->role === 'customer') {
            
            return view('backend.pages.customer.order.index', compact('apoteks'));
        
        } elseif (Auth::user()->role === 'apoteker') {
            
            return view('backend.pages.apoteker.order.index', compact('apoteks'));
        
        } elseif (Auth::user()->role === 'kurir') {
            
            return view('backend.pages.kurir.order.index', compact('apoteks'));
        }
    }
    public function apotek($id) {
        $apoteks = Apotek::findOrFail($id);
        $users = Auth::user();
        $obats = Obat::where('apotek_id', $apoteks->id)->paginate(10);
        $orders = Transaksi::where('user_id', $users->id)->pluck('apotek_id')->toArray();
        return view('backend.pages.customer.order.apotek', compact(['apoteks','orders','obats']));
    }
    public function create($id) {

        $now = Carbon::now();
        $date = $now->format('Y-m-d H:i:s');
        $no_trx = "E-MEDC-".$now->format('YmdHis');
        $apoteks = Apotek::findOrFail($id);
        $transaksis = Transaksi::all();

        return view('backend.pages.customer.order.chekout', compact(['date','no_trx','apoteks','transaksis']));
    }
    
    public function add(Request $request, $id)
    {
        $this->validate($request, [
            'id_obat' => 'required',
            'qty' => 'required|integer|min:1',
        ]);

        $apotek = Apotek::findOrFail($id);
        $obat = Obat::findOrFail($request->id_obat);

        $available_stock = $obat->stock;
        $input_qty = $request->qty;

        if ($input_qty <= $available_stock) {
            $harga_unit = $obat->harga * $input_qty;

            $cart = session()->get('cart', []);

            if (count($cart) > 0) {
                $firstItem = reset($cart);
                if ($firstItem['apotek_id'] !== $apotek->id) {
                    Alert::error('gagal', 'Anda tidak dapat menambahkan item dari apotek yang berbeda, selesaikan terlebih dahulu pesanannya !');
                    return redirect()->back();
                }
            }

            if (isset($cart[$obat->id])) {
                $cart[$obat->id]['qty'] += $input_qty;
                $cart[$obat->id]['total'] += ($harga_unit * $input_qty);
            } else {
                $cart[$obat->id] = [
                    "apotek_id" => $apotek->id,
                    "apotek_name" => $apotek->name,
                    "obat_id" => $obat->id,
                    "name" => $obat->name,
                    "harga" => $obat->harga,
                    "diskon" => $obat->diskon,
                    "qty" => $input_qty,
                    "total" => ($harga_unit * $input_qty),
                ];
            }

            session()->put('cart', $cart);

            Alert::success('sukses', 'Sukses tambah obat di Keranjang!');
            return redirect()->route('customer.order.apotek', ['apotek' => $id]);
        } else {
            Alert::error('gagal', 'Stock Tidak Cukup!');
            return redirect()->back();
        }
    }

    public function store(Request $request, $id)
    {
        
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'no_transaksi' => 'required|string',
            'pembayaran' => 'required|string',
            'user_id' => 'required|integer',
            'apotek_id' => 'required|integer',
            'total' => 'required|array',
            'total.*' => 'required|numeric|min:0',
            'obat_id.*' => 'required|integer',
            'qty.*' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $total_amount = array_sum($request->input('total'));

            $transaksi = Transaksi::create([
                'tgl_transaksi' => $request->input('tgl_transaksi'),
                'no_transaksi' => $request->input('no_transaksi'),
                'pembayaran' => $request->input('pembayaran'),
                'user_id' => $request->input('user_id'),
                'apotek_id' => $request->input('apotek_id'),
                'total' => $total_amount,
                'paid' => 0,
                'status' => "Pending",
            ]);

            $obatIds = $request->input('obat_id');
            $qtys = $request->input('qty');
            $totals = $request->input('total');

            for ($i = 0; $i < count($obatIds); $i++) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $obatIds[$i],
                    'qty' => $qtys[$i],
                    'total' => $totals[$i],
                ]);

                $obat = Obat::findOrFail($obatIds[$i]);
                $obat->stock -= $qtys[$i];
                $obat->save();
            }

            DB::commit();
            $cart = session()->get('cart');

            if (is_array($cart)) {
                foreach ($cart as $id => $value) {
                    unset($cart[$id]);
                }

                session()->put('cart', $cart);

                Alert::success('sukses', 'Transaksi Berhasil !');
                return redirect()->route('customer.transaksi');
            }
        } catch (Exception $e) {

            DB::rollback();

            Alert::error('gagal', 'Transaksi Gagal !');
            return back();
        }
    }

    public function destroy($apotekId)
    {
        $cart = session()->get('cart');

        if(is_array($cart)){
            foreach($cart as $id => $value){
                unset($cart[$id]);
            }
            session()->put('cart',$cart);
            Alert::success('sukses', 'Sukses hapus obat dari Keranjang!');
        } else {
            Alert::error('gagal', 'Obat tidak ditemukan dalam Keranjang!');
        }

        return redirect()->route('customer.order.apotek', ['apotek' => $apotekId]);
    }
    public function indexApotek() {
        $transaksis = Transaksi::where('apotek_id', Auth::user()->apotek_id)->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.apoteker.order.index', compact(['transaksis','details']));
    }

    public function showApotek($id){
        $transaksis = Transaksi::findOrFail($id);
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();
        
        if ($transaksis->apotek->id !== Auth::user()->apotek_id) {
            Alert::error('error','Detail Transaksi Tidak Ditemukan');
            return redirect()->back();
        }

        return view('backend.pages.apoteker.order.show', compact('transaksis','details'));
    }
    public function accept($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            
            if ($transaksi->apotek->id !== Auth::user()->apotek_id) {
                Alert::error('error','Detail Transaksi Tidak Ditemukan');
                return redirect()->back();
            }

            if ($transaksi->status === "Pending") {
                $transaksi->status = "Accept";
                $transaksi->save();

                Alert::success('success', 'Status transaksi berhasil diubah menjadi "On Process"');
                return redirect()->back();
            } else {
                Alert::error('error', 'Status transaksi tidak dapat diubah karena status saat ini bukan "Pending"');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('error', 'Terjadi kesalahan saat mengubah status transaksi: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $transaksi = Transaksi::findOrFail($id);
            
            if ($transaksi->apotek->id !== Auth::user()->apotek_id) {
                Alert::error('error','Detail Transaksi Tidak Ditemukan');
                return redirect()->back();
            }

            $details = $transaksi->detailTransaksi;
            foreach ($details as $detail) {
                $obat = $detail->obat;
                $obat->stock += $detail->qty;
                $obat->save();
                $detail->delete();
            }

            $transaksi->status = "Cancel";
            $transaksi->save();

            DB::commit();

            Alert::success('sukses', 'Transaksi berhasil dibatalkan!');
            return redirect()->route('apoteker.order');
        } catch (Exception $e) {
            DB::rollback();
            Alert::error('gagal', 'Gagal membatalkan transaksi!');
            return back();
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $transaksi = Transaksi::findOrFail($id);

            if ($transaksi->apotek->id !== Auth::user()->apotek_id) {
                Alert::error('error','Detail Transaksi Tidak Ditemukan');
                return redirect()->back();
            }

            $details = $transaksi->detailTransaksi;
            foreach ($details as $detail) {
                $obat = $detail->obat;
                $obat->stock += $detail->qty;
                $obat->save();
                $detail->delete();
            }

            $transaksi->delete();

            DB::commit();

            Alert::success('sukses', 'Transaksi berhasil dihapus!');
            return redirect()->route('apoteker.order');
        } catch (Exception $e) {
            DB::rollback();
            Alert::error('gagal', 'Gagal menghapus transaksi!');
            return back();
        }
    }
    public function indexKurir() {
        $transaksis = Transaksi::where('status', 'Accept')->orderBy('id', 'ASC')->paginate(10);
        $transaksiID = $transaksis->pluck('id');

        $details = DetailTransaksi::whereIn('transaksi_id', $transaksiID)
            ->select('transaksi_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('transaksi_id')
            ->get();

        return view('backend.pages.kurir.order.index', compact(['transaksis','details']));
    }

    public function showKurir($id){
        $transaksis = Transaksi::findOrFail($id);
        $details = DetailTransaksi::where('transaksi_id', $transaksis->id)->get();

        return view('backend.pages.kurir.order.show', compact('transaksis','details'));
    }
    public function acceptKurir($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            if ($transaksi->status === "Accept") {
                $transaksi->status = "Delivered";
                $transaksi->save();

                Alert::success('success', 'Status transaksi berhasil diubah menjadi "Delivered"');
                return redirect()->back();
            } else {
                Alert::error('error', 'Status transaksi tidak dapat diubah karena status saat ini bukan "Pending"');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('error', 'Terjadi kesalahan saat mengubah status transaksi: ' . $e->getMessage());
            return redirect()->back();
        }
    }

}
