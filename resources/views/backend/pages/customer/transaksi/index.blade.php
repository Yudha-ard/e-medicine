@extends('backend.layouts.layout')

@section('title', 'Transaksi')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Transaksi</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Transaksi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="actions clearfix d-flex justify-content-end m-2">
                                <a class="btn btn-success m-1" href="{{ route('customer.transaksi.export') }}" role="menuitem">
                                    <i class='bx bx-export'></i> Excel
                                </a>
                                <a class="btn btn-danger m-1" onclick="printInvoice()" role="menuitem">
                                    <i class='bx bxs-file-pdf'></i> PDF
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No Transaksi</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Obat</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Diskon</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Method</th>
                                            <th scope="col">Apotek</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($transaksis as $transaksi)
                                        @foreach ($transaksi->detailTransaksi as $detail)
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
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <p class="mb-0 badge badge-soft-primary">
                                                        {{ $transaksi->no_transaksi }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 badge badge-soft-info">
                                                        {{ $transaksi->tgl_transaksi }}
                                                    </p>
                                                </td>
                                                <td>{{ $detail->obat->name }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>{{ $detail->obat->diskon }} %</td>
                                                <td>Rp. {{ number_format($detail->obat->harga, 2, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($detail->total, 2, ',', '.') }}</td>
                                                <td>
                                                    <p class="mb-0 badge badge-soft-success">
                                                        {{ $transaksi->pembayaran }}
                                                    </p>
                                                </td>
                                                <td>{{ $transaksi->apotek->name }}</td>
                                                <td>
                                                    <p class="mb-0 badge {{ $statusClass[$transaksi->status] }}">{{ $transaksi->status }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.transaksi.show', $transaksi->id) }}" class="btn btn-primary btn-sm">
                                                        <i class='bx bx-show'></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="pagination pagination-rounded justify-content-center mt-4">
                                                    <li class="page-item {{ $transaksis->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $transaksis->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $transaksis->lastPage(); $i++)
                                                        <li class="page-item {{ $i == $transaksis->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $transaksis->url($i) }}" class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ $transaksis->currentPage() == $transaksis->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $transaksis->nextPageUrl() }}" class="page-link" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
</div>
<script>
    function printInvoice() {
        var contentToPrint = document.querySelector('.table-responsive').outerHTML;

        var printWindow = window.open(' ', '_blank');
        printWindow.document.open();

        printWindow.document.write('<html><head><title>Print Invoice E-Medicine</title></head><body>' + contentToPrint + '</body></html>');

        printWindow.document.close();

        printWindow.print();
        printWindow.close();
    }
</script>
@stop