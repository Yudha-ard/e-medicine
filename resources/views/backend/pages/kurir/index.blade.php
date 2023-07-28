@extends('backend.layouts.layout')

@section('title', 'Dashboard')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Kurir Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="row align-item-center">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('kurir.order') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Orders</p>
                                                <h4 class="mb-0">{{ $transaksi->where('status', 'Accept')->count() }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <a href="{{ route('kurir.riwayat') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Riwayat</p>
                                                <h4 class="mb-0">{{ $transaksi->where('status', 'Delivered')->count() }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end row -->

                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex flex-wrap">
                                <h4 class="card-title mb-4">Delivered</h4>
                            </div>

                            <div id="line-chart" class="apex-charts" data-colors='["--bs-primary", "--bs-warning", "--bs-success"]' dir="ltr"></div>
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
                                                <p class="mb-0 badge {{ $statusClass[$transaksi->status] }}">{{ $transaksi->status }}</p>
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ route('kurir.riwayat.show', $transaksi->id) }}" class="btn btn-warning" title="Edit">
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
                                                    <li class="page-item">
                                                        <a href="{{ route('kurir.riwayat') }}" class="btn btn-soft-primary" aria-label="Riwayat">
                                                            Riwayat <i class='bx bx-right-arrow-alt'></i>
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
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
    <script>
        var monthlyCounts = @json($monthlyCounts);

        var chartData = {
        chart: {
            type: 'line',
            height: 350
        },
        series: [{
            name: 'Counts',
            data: monthlyCounts
        }],
        xaxis: {
            categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        },
        colors: ['#007bff'],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            legend: {
                show: false
            },
            grid: {
                borderColor: '#e0e6ed',
                row: {
                colors: ['#f3f6ff', 'transparent'],
                opacity: 0.5
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#line-chart"), chartData);
        chart.render();
    </script>
@stop