@extends('backend.layouts.layout')

@section('title', 'Kategori')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Kategori</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Kategori</li>
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
                                                <div class="avatar-md">
                                                    <img src="{{ $kategoris->img_kategori ? asset('storage/images/kategori/'.$kategoris->img_kategori) : asset('storage/images/kategori/kategori.png') }}" alt="" class="img-thumbnail rounded-circle" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Nama</th>
                                                            <td>{{ $kategoris->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Deskripsi</th>
                                                            <td>{{ $kategoris->deskripsi }}</td>
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
                            <a href="{{ route('apoteker.kategori') }}" class="btn btn-primary" role="menuitem">
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
