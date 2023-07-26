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
                                <li class="breadcrumb-item active">Riwayat</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No Transaksi</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Method</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i =1 @endphp
                                    @foreach ($transaksis as $transaksi)
                                    @php
                                        $detail = $details->where('transaksi_id', $transaksi->id)->first();
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
                                                <p class="mb-0 badge badge-soft-primary">{{ $transaksi->no_transaksi}}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 badge badge-soft-warning">{{ $transaksi->tgl_transaksi}}</p>
                                            </td>
                                            <td>Rp. {{ number_format($transaksi->total, 2, ',', '.') }}</td>
                                            <td>
                                                <p class="mb-0 badge badge-soft-success">{{ $transaksi->pembayaran }}</p>
                                            </td>
                                            <td>{{ $detail ? $detail->total_qty : 0 }}</td>
                                            <td>
                                                <p class="mb-0 badge {{ $statusClass[$transaksi->status] }}">{{ $transaksi->status }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ route('apoteker.riwayat.show', $transaksi->id) }}" class="btn btn-warning" title="Edit">
                                                            <i class="bx bx-show"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                            </tr>
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
@stop