@extends('backend.layouts.layout')

@section('title', 'Obat')

@section('content')
@if (config('sweetalert.animation.enable'))
    <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
@endif

@if (config('sweetalert.theme') != 'default')
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
@endif

@if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const obatId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + obatId).submit();
                    }
                });
            });
        });
    });
</script>
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
                                <li class="breadcrumb-item active">Obat</li>
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
                                <a class="btn btn-info" href="{{ route('apoteker.obat.create') }}" role="menuitem">
                                    <i class="bx bx-plus"></i> Add Obat
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 70px;">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Diskon</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i =1 @endphp
                                    @foreach ($obats as $obat)
                                        <tr>
                                            <td>
                                                <a href="{{ route('apoteker.obat.show', $obat->id) }}" class="text-dark">
                                                    {{ $i++ }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle">
                                                        <img class="rounded-circle header-profile-user" src="{{ $obat->img_obat ? asset('storage/images/obat/'.$obat->img_obat) : asset('storage/images/obat/obat.png') }}" />
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 mb-1"><a class="text-dark">{{ $obat->name }}</a></h5>
                                            </td>
                                            <td>{{ $obat->stock }}</td>
                                            <td>Rp. {{ number_format($obat->harga,2,',','.') }} </td>
                                            <td>{{ $obat->diskon }} %</td>
                                            <td>
                                                <p class="mb-0 badge badge-soft-primary">
                                                {{ $obat->kategori->name }}
                                                </p>
                                            </td>
                                            <td>{!! substr($obat->deskripsi, 0, 50) . '...' !!}</td>
                                            <td>
                                                <p class="mb-0 badge {{ $obat->status === 'Tersedia' ? 'badge-soft-success' : ($obat->status === 'Habis' ? 'badge-soft-danger' : 'badge-soft-primary') }} font-size-11 m-1">{{ $obat->status }}</p>
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ route('apoteker.obat.edit', $obat->id) }}" class="btn btn-warning" title="Edit">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item px-2">
                                                        <form id="delete-form-{{ $obat->id }}" action="{{ route('apoteker.obat.destroy', $obat->id) }}" method="POST"  style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger delete-button" data-id="{{ $obat->id }}" title="Hapus">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
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

                                    </div>
                                </div>
                            </div>
                        </div>

        
        </div>
    </div>
</div>
@stop