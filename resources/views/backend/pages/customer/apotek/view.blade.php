@extends('backend.layouts.layout')

@section('title', 'Apotek')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Apotek</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Apotek</li>
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
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Name</th>
                                                            <td>{{ $apoteks->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Address</th>
                                                            <td>{{ $apoteks->address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Phone</th>
                                                            <td>{{ $apoteks->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <td>
                                                                <p class="mb-0 badge {{ $apoteks->status === 'active' ? 'badge-soft-success' : ($apoteks->status === 'inactive' ? 'badge-soft-danger' : 'badge-soft-primary') }} font-size-11 m-1">{{ $apoteks->status }}</p>
                                                            </td>
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
                            <a href="{{ route('customer.apotek') }}" class="btn btn-primary" role="menuitem">
                                <i class="bx bx-arrow-back"></i> Back</a>
                            <li class="list-inline-item px-2">
                                @if($apoteks->status === 'active')
                                <a href="{{ route('customer.order.apotek', ['apotek' => $apoteks->id]) }}" class="btn btn-warning" title="Order">
                                    <i class='bx bx-cart'></i> Order
                                </a>
                                @endif
                            </li>
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
