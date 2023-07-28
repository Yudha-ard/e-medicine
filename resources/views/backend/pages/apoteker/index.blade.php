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
                        <h4 class="mb-sm-0 font-size-18">Apoteker Dashboard</h4>

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
                                <a href="{{ route('apoteker.obat') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Obat</p>
                                                <h4 class="mb-0">{{ $sumTotalObat }}</h4>
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
                                <a href="{{ route('apoteker.kategori') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Kategori</p>
                                                <h4 class="mb-0">{{ $sumTotalKategori }}</h4>
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
                                <a href>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Customer</p>
                                                <h4 class="mb-0">{{ $sumTotalCustomer }}</h4>
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
                                <a href="{{ route('apoteker.riwayat') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Transaksi</p>
                                                <h4 class="mb-0">{{ $sumTransaksi }}</h4>
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
                                <a href="{{ route('apoteker.transaksi') }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Transaksi</p>
                                                <h4 class="mb-0">Rp. {{ number_format($sumTotalTransaksi, 2, ',', '.') }}</h4>
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
                                <h4 class="card-title mb-4">Penjualan</h4>
                            </div>

                            <div id="chartContainer" class="apex-charts" data-colors='["--bs-primary", "--bs-warning", "--bs-success"]' dir="ltr"></div>
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
                                                        {{ $item->name}}
                                                    </td>
                                                    <td>
                                                        {{ $item->kategori_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->total_qty }}
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 badge {{ $item->obat_status === 'Tersedia' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                            {{ $item->obat_status }}
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
                                                        <a href="{{ route('apoteker.obat') }}" class="btn btn-soft-primary" aria-label="Obat">
                                                            Obat <i class='bx bx-right-arrow-alt'></i>
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
    document.addEventListener("DOMContentLoaded", function() {
        const itemSellCountData = @json($itemSellCountData);
        const chartData = @json($chartData);

        const combinedData = chartData.map(data => ({
            month: data.month,
            total: data.total,
            itemSellCount: itemSellCountData[data.month] || 0,
        }));

        const totalTransaksiSeries = combinedData.map(data => data.total);
        const itemSellCountSeries = combinedData.map(data => data.itemSellCount);
        const totalTransaksiLabels = combinedData.map(data => data.month);

        const mergedSeries = [
            {
                name: 'Total Transaksi',
                type: 'line',
                data: totalTransaksiSeries,
            },
            {
                name: 'Total Item',
                type: 'line',
                data: itemSellCountSeries,
            },
        ];

        const chartOptions = {
            chart: {
                height: 350,
            },
            xaxis: {
                categories: totalTransaksiLabels,
            },
            series: mergedSeries,
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            grid: {
                borderColor: '#e0e6ed',
                row: {
                colors: ['#f3f6ff', 'transparent'],
                opacity: 0.5
                }
            }
        };

        const combinedChart = new ApexCharts(document.querySelector("#chartContainer"), chartOptions);
        combinedChart.render();
    });
</script>
@stop