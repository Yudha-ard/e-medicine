@extends('backend.layouts.layout')

@section('title', 'Checkout')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('customer.order.apotek', ['apotek' => $apoteks->id]) }}">Order</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
            @if($errors->any())
            <div class="alert alert-danger md-5" align="center" role="alert">
                {{ implode('', $errors->all(':message')) }}
            </div>
            @endif
            @if (session()->has('msg'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session()->get('msg') }}</li>
                    </ul>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session()->get('error') }}</li>
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-start mb-3">
                                <h2>E-Medicine</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mb-3">
                                <a class="m-1" href="{{ route('customer.order.apotek.destroy', $apoteks->id) }}">
                                    <button class="btn btn-danger" type="reset">
                                        <i class="bx bx-trash"></i> Batalkan
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('customer.order.apotek.checkout', ['apotek' => $apoteks->id]) }}" method="POST">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Apotek</strong> : {{ $apoteks->name }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Tanggal</strong> : {{ $date }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 text-dark">
                                <strong>No Transaksi</strong> : {{ $no_trx }}
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Diskon</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                        $total_qty=0;
                                        $total_harga=0;
                                    @endphp
                                    @foreach ((array) session()->get('cart') as $id => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['diskon'] }} %</td>
                                        <td class="text-right">Rp {{ number_format($item['harga'], 2) }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td class="text-right">Rp {{ number_format(($item['harga'] - ($item['harga'] * $item['diskon'] / 100)) * $item['qty'], 2, ',', '.') }}</td>
                                    @php
                                        $total_qty += $item['qty'];
                                        $total_harga += (($item['harga'] - ($item['harga'] * $item['diskon'] / 100)) * $item['qty']);
                                    @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                        <td><strong>Total</strong></td>
                                        <td><strong>{{ $total_qty }}</strong></td>
                                        <td><strong>Rp. {{ number_format($total_harga, 2, ',', '.') }}</strong></td> 
                                    </tr>
                                </tfoot>
                            </table>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="mb-3">
                                        <label for="apotek">Pembayaran</label>
                                        <select class="form-select" name="pembayaran" id="pembayaran">
                                            <option value="">-- Select Pembayaran --</option>
                                            <option value="Tunai" {{ old('pembayaran') == "Tunai" ? 'selected' : '' }}>Tunai</option>
                                            <option value="E-Wallet" {{ old('pembayaran') == "E-Wallet" ? 'selected' : '' }}>E-Wallet</option>
                                            <option value="Bank" {{ old('pembayaran') == "Bank" ? 'selected' : '' }}>Bank</option>
                                        </select>
                                        @if ($errors->has('pembayaran'))
                                            <div class="text-danger">
                                                {{ $errors->first('pembayaran') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                        <input type="hidden" name="tgl_transaksi" value="{{ $date }}">
                        <input type="hidden" name="no_transaksi" value="{{ $no_trx }}">
                        <input type="hidden" name="pembayaran" value="tunai">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="apotek_id" value="{{ $apoteks->id }}">
                        <input type="hidden" name="total" value="{{ $total_harga }}">

                        @foreach ((array) session()->get('cart') as $id => $item)
                        @php
                            $total_qty=0;
                            $total_harga=0;
                            $total_qty += $item['qty'];
                            $total_harga += (($item['harga'] - ($item['harga'] * $item['diskon'] / 100)) * $item['qty']);
                        @endphp
                            <input type="hidden" name="obat_id[]" value="{{ $item['obat_id'] }}">
                            <input type="hidden" name="qty[]" value="{{ $total_qty }}">
                            <input type="hidden" name="total[]" value="{{ $total_harga }}">
                        @endforeach
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-cart"></i> Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
