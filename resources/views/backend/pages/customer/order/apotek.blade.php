@extends('backend.layouts.layout')

@section('title', 'Obats')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Order</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('customer.apotek') }}">Order</a></li>
                                <li class="breadcrumb-item active">Obats</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart ({{count(session()->get('cart', []))}})
                </button>
            </div>    
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Obat yang dipilih</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Apotek</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cart = session()->get('cart', []);
                                        $i=1;
                                    @endphp
                                    @foreach ($cart as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['apotek_name'] }}</td>
                                            <td> x {{ $item['qty'] }}</td>
                                            <td>{{ number_format($item['harga'], 2, ',', '.') }}</td>
                                            <td>Rp {{ number_format(($item['harga'] - ($item['harga'] * $item['diskon'] / 100)) * $item['qty'], 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex justify-content-end mb-3">
                                <a class="m-1" href="{{ route('customer.order.apotek.destroy', $apoteks->id) }}">
                                    <button class="btn btn-danger" type="reset">Batalkan</button>
                                </a>
                                <a class="m-1" href="{{ route('customer.order.apotek.create', $apoteks->id) }}">
                                    <button class="btn btn-success" type="button">Checkout</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Stok</th>
                                            <th>Diskon</th>
                                            <th>Jumlah</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1 @endphp
                                        @foreach($obats as $obat)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $obat->name }}</td>
                                            <td>Rp. {{ number_format($obat->harga,2,',','.') }}</td>
                                            <td>
                                                <p class="mb-0 badge {{ $obat->status === 'Tersedia' ? 'badge-soft-success' : ($obat->status === 'Habis' ? 'badge-soft-danger' : 'badge-soft-primary') }} font-size-11 m-1">{{ $obat->status }}</p>
                                            </td>
                                            <td>{{ $obat->stock }}</td>
                                            <td>{{ $obat->diskon }} %</td>
                                            @php
                                                $cart = session()->get('cart', []);
                                                $qtyInCart = isset($cart[$obat->id]) ? $cart[$obat->id]['qty'] : 0;
                                            @endphp
                                            <form action="{{ route('customer.order.apotek.add', ['apotek' => $apoteks->id]) }}" method="POST">
                                            @csrf
                                            <td>
                                                <input type="hidden" name="id_obat" value="{{ $obat->id }}">
                                                <input type="number" style="max-width: 80px;" class="form-control input-number" name="qty" value="0" min="1" required
                                                @if($qtyInCart >= $obat->stock)
                                                    disabled
                                                @endif
                                            >
                                            </td>
                                            
                                                <td class="text-center">
                                                    <button type="submit" class="btn btn-success @if($qtyInCart >= $obat->stock) disabled @endif">
                                                        <i class="bx bx-plus"></i> Add
                                                    </button>
                                                </td>   
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="pagination pagination-rounded justify-content-center mt-4">
                                                    <li class="page-item {{ $obats->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $obats->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $obats->lastPage(); $i++)
                                                        <li class="page-item {{ $i == $obats->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $obats->url($i) }}" class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ $obats->currentPage() == $obats->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $obats->nextPageUrl() }}" class="page-link" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

            <div class="d-flex justify-content-end mb-3">
                <a class="m-1" href="{{ route('customer.order.apotek.destroy', $apoteks->id) }}">
                    <button class="btn btn-danger" type="reset">Batalkan</button>
                </a>
                <a class="m-1" href="{{ route('customer.order.apotek.create', $apoteks->id) }}">
                    <button class="btn btn-success" type="button">Checkout</button>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
