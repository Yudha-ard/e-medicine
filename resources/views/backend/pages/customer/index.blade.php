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
                        <h4 class="mb-sm-0 font-size-18">Customer Dashboard</h4>

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
                                <a href="{{ route('customer.apotek') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Apotek</p>
                                                <h4 class="mb-0">{{ $apoteks->count() }}</h4>
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
                                <a href="{{ route('customer.riwayat') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Transaksi</p>
                                                <h4 class="mb-0">{{ $transaksis->count() }}</h4>
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
                                <a href="{{ route('customer.riwayat') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Transaksi</p>
                                                <h4 class="mb-0">Rp. {{ number_format($transaksis->sum('total'), 2, ',', '.') }}</h4>
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
                                <a href="{{ route('customer.transaksi') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Item</p>
                                                <h4 class="mb-0">{{ $details->sum('total_qty') }}</h4>
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
                                                    <th scope="col">Obat</th>
                                                    <th scope="col">Kategori</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $i =1 @endphp
                                            @foreach ($topItems as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        {{ $item->obat->name}}
                                                    </td>
                                                    <td>
                                                        {{ $item->obat->kategori->name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->total_qty }}
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 badge {{ $item->obat->status === 'Tersedia' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                            {{ $item->obat->status }}
                                                        </p>
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
                                                        <a href="{{ route('customer.apotek') }}" class="btn btn-soft-primary" aria-label="Apotek">
                                                            Apotek <i class='bx bx-right-arrow-alt'></i>
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
    var chartData = {
        chart: {
            type: 'line',
            height: 350
        },
        series: [
            {
                name: 'Transaksi',
                data: @json($monthlyData->pluck('total_items'))
            },
            {
                name: 'Total Transaksi',
                data: @json($monthlyData->pluck('total_transaksis'))
            },
            {
                name: 'Total Item',
                data: @json($monthlyData->pluck('total_qty'))
            }
        ],
        xaxis: {
            categories: @json($monthlyData->pluck('month'))
        },
        colors: ['#007bff', '#ffc107', '#ca1a07'],
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