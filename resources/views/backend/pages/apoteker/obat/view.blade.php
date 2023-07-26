@extends('backend.layouts.layout')

@section('title', 'Obat')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Obat</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Obat</li>
                                <li class="breadcrumb-item active">View</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="content clearfix">
                                <section id="vertical-example-p-0" role="tabpanel" aria-labelledby="vertical-example-h-0" class="body current" aria-hidden="false">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <div class="avatar-lx">
                                                    <img src="{{ $obats->img_obat ? asset('storage/images/obat/'.$obats->img_obat) : asset('storage/images/obat/obat.png') }}" alt="" class="img-thumbnail rounded-circle" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Nama</th>
                                                            <td>{{ $obats->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Stock</th>
                                                            <td>{{ $obats->stock }}
                                                                <small>
                                                                    <i>Stock</i>
                                                                </small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Harga</th>
                                                            <td>Rp {{ number_format($obats->harga,2,',','.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Diskon</th>
                                                            <td>{{ $obats->diskon }} %</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Kategori</th>
                                                            <td>{{ $obats->kategori->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <td>
                                                                <p class="mb-0 badge {{ $obats->status === 'Tersedia' ? 'badge-soft-success' : ($obats->status === 'Habis' ? 'badge-soft-danger' : 'badge-soft-primary') }} font-size-11 m-1">
                                                                    {{ $obats->status }}
                                                                </p>
                                                            <td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Deskripsi</th>
                                                            <td>{{ $obats->deskripsi }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>                        
                        </div>
                    </div>
                    <!-- end card -->
                    <div class="actions clearfix">
                        <ul role="menu" aria-label="Pagination">
                            <a href="{{ route('apoteker.obat') }}" class="btn btn-primary" role="menuitem">
                                <i class="bx bx-arrow-back"></i> Back</a>
                        </ul>
                    </div>
                    <!-- end card -->
                </div>
            </div>
            
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@stop
