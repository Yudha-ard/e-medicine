@extends('backend.layouts.layout')

@section('title', 'Detail')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">Order</li>
                        <li class="breadcrumb-item active">Detail</li>
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
            @php
                $statusClass = [
                    'Done' => 'badge-soft-success',
                    'Accept' => 'badge-soft-success',
                    'On Process' => 'badge-soft-primary',
                    'Delivered' => 'badge-soft-info',
                    'Cancel' => 'badge-soft-danger',
                    'Pending' => 'badge-soft-warning',
                ];
            @endphp
            <div class="card invoice">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-start mb-3">
                                <h2>E-Medicine</h2>
                            </div>
                        </div>
                    </div>
                    
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Apotek</strong> : {{ $transaksis->apotek->name }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Nama</strong> : {{ $transaksis->user->name }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Tanggal</strong> : {{ $transaksis->tgl_transaksi }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>No Transaksi</strong> : {{ $transaksis->no_transaksi }}
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4 text-dark">
                                <strong>Alamat</strong> : {{ $transaksis->user->address }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 text-dark">
                                <strong>Status</strong> : 
                                <p class="mb-0 badge {{ $statusClass[$transaksis->status] }}">{{ $transaksis->status }}</td>
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
                                    @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $detail->obat->name }}</td>
                                        <td>{{ $detail->obat->diskon }} %</td>
                                        <td class="text-right">Rp {{ number_format($detail->obat->harga, 2) }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td class="text-right">Rp {{ number_format(($detail->obat->harga - ($detail->obat->harga * $detail->obat->diskon / 100)) * $detail->qty, 2, ',', '.') }}</td>
                                    @php
                                        $total_qty += $detail->qty;
                                        $total_harga += (($detail->obat->harga - ($detail->obat->harga * $detail->obat->diskon / 100)) * $detail->qty);
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
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <li class="list-inline-item px-2">
                                @if ($transaksis->status === 'Pending')
                                <form action="{{ route('apoteker.order.accept', $transaksis->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">
                                        <i class="bx bx-check"></i> Terima
                                    </button>
                                </form>
                                <form action="{{ route('apoteker.order.cancel', $transaksis->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bx bx-info-circle"></i> Cancel
                                    </button>
                                </form>
                                @elseif ($transaksis->status === 'Cancel')
                                <form action="{{ route('apoteker.order.delete', $transaksis->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-x"></i> Hapus
                                    </button>
                                </form>
                                @endif
                                <button class="btn btn-primary m-3" onclick="printInvoice()"><i class='bx bx-printer'></i> Print</button>
                            </li>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function printInvoice() {
        var contentToPrint = document.querySelector('.invoice').outerHTML;

        var printWindow = window.open(' ', '_blank');
        printWindow.document.open();

        printWindow.document.write('<html><head><title>Print Invoice E-Medicine</title></head><body>' + contentToPrint + '</body></html>');

        printWindow.document.close();

        printWindow.print();
        printWindow.close();
    }
</script>
@stop
