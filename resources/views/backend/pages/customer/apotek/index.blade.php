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
                                <li class="breadcrumb-item active">Apotek</li>
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
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i =1 @endphp
                                    @foreach ($apoteks as $apotek)
                                        <tr>
                                            <td>
                                                <a href="{{ route('customer.apotek.show', $apotek->id) }}" class="text-dark">
                                                    {{ $i++ }}
                                                </a>
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 mb-1">
                                                    <a class="text-dark">{{ $apotek->name }}</a>
                                                </h5>
                                            </td>
                                            <td>{!! substr($apotek->address, 0, 50) . '...' !!}</td>
                                            <td>{{ $apotek->phone }}</td>
                                            <td>
                                                <p class="mb-0 badge {{ $apotek->status === 'active' ? 'badge-soft-success' : ($apotek->status === 'inactive' ? 'badge-soft-danger' : 'badge-soft-primary') }} font-size-11 m-1">{{ $apotek->status }}</p>
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        @if($apotek->status === 'active')
                                                        <a href="{{ route('customer.order.apotek', ['apotek' => $apotek->id]) }}" class="btn btn-warning" title="Order">
                                                            <i class='bx bx-cart'></i> Order
                                                        </a>
                                                        @endif
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
                                                    <li class="page-item {{ $apoteks->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $apoteks->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $apoteks->lastPage(); $i++)
                                                        <li class="page-item {{ $i == $apoteks->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $apoteks->url($i) }}" class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ $apoteks->currentPage() == $apoteks->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $apoteks->nextPageUrl() }}" class="page-link" aria-label="Next">
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