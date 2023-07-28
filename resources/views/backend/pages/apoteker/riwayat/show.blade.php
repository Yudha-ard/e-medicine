@extends('backend.layouts.layout')

@section('title', 'Riwayat')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Riwayat</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="invoice p-5">
                            <span class="mb-2">
                                <strong><i>{{ $transaksis->apotek->name }}</i></strong>
                                </br>
                                {{ date('d M, Y') }}
                            </span>
                            <div class="text-left logo mb-4 mt-2">
                                <h1>E-Medicine</h1>
                            </div>
                            <h5>Your order Confirmed!</p>
                            </h5>
                            <span class="font-weight-bold d-block mt-4">Hello, <strong>{{ Auth::user()->name }}</strong></span>
                            <span class="mb-1">
                                You order has been
                                <p class="mb-0 badge {{ $statusClass[$transaksis->status] }}">{{ $transaksis->status }}</p>
                            </span>
                            
                            <div class="border-top mt-3 mb-3 border-bottom table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="mb-1 text-left">
                                                    <span class="small">
                                                        <strong>Date</strong>
                                                    </span>
                                                    </br>
                                                    <span class="small">{{ $transaksis->tgl_transaksi }}</span>
                                                </div>
                                                <div class="mb-1 text-left">
                                                    <span class="small">
                                                        <strong>No</strong>
                                                    </span>
                                                    </br>
                                                    <span class="small">{{ $transaksis->no_transaksi }}</span>
                                                </div>
                                                <div class="mb-1 text-left">
                                                    <span class="small">
                                                        <strong>Method</strong>
                                                    </span>
                                                    </br>
                                                    <span class="small">{{ $transaksis->pembayaran }}</span>
                                                </div>
                                                <div class="mb-1 text-left">
                                                    <span class="small">
                                                        <strong>Address</strong>
                                                    </span>
                                                    </br>
                                                    <span class="small">{{ $transaksis->user->address }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="product border-bottom table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <th>
                                            <span class="small">No</span>
                                        </th>
                                        <th>
                                            <span class="small">Obat</span>
                                        </th>
                                        <th>
                                            <span class="small">Qty</span>
                                        </th>
                                        <th>
                                            <span class="small">Diskon</span>
                                        </th>
                                        <th>
                                            <span class="small">Harga</span>
                                        </th>
                                        <th>
                                            <span class="small">Total</span>
                                        </th>
                                    </thead>
                                    <tbody>
                                    @php $i = 1; @endphp
                                        @foreach ($details as $detail)
                                        <tr>
                                            <td class="small" width="5%">
                                                {{ $i++ }}
                                            </td>
                                            <td class="small" width="30%">
                                                {{ $detail->obat->name }}
                                            </td>
                                            <td class="small" width="5%">
                                                {{ $detail->qty }}
                                            </td>
                                            <td class="small" width="5%">
                                                {{ $detail->obat->diskon }} %
                                            </td>
                                            <td class="small" width="25%">
                                                Rp. {{ number_format($detail->obat->harga, 2, ',', '.') }}
                                            </td>
                                            <td class="small" width="30%">
                                                Rp. {{ number_format($detail->total, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row d-flex justify-content-end">
                                <div class="col-md-5">
                                    <table class="table table-borderless">
                                        <tbody class="totals">
                                            <tr>
                                                <td>
                                                    <div class="text-left small">
                                                        <span class="text-muted">Sub Total</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-right small">
                                                        <span>Rp. {{ number_format($transaksis->total, 2, ',', '.') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <p class="font-weight-bold mb-0 text-dark">Thanks for Order with us!</p>
                            <span>E-Medicine  © </span>
                            <span>
                                <script>document.write(new Date().getFullYear())</script>
                            </span>
                        </div>
                        <button class="btn btn-primary m-3" onclick="printInvoice()"><i class='bx bx-printer'></i> Print</button>
                    </div>
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
