@extends('backend.layouts.layout')

@section('title', 'Kategori')

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

                const kategoriId = this.getAttribute('data-id');

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
                        document.getElementById('delete-form-' + kategoriId).submit();
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
                        <h4 class="mb-sm-0 font-size-18">Kategori</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Kategori</li>
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
                                <a class="btn btn-info" href="{{ route('apoteker.kategori.create') }}" role="menuitem">
                                    <i class="bx bx-plus"></i> Add Kategori
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 70px;">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i =1 @endphp
                                    @foreach ($kategoris as $kategori)
                                        <tr>
                                            <td>
                                                <a href="{{ route('apoteker.kategori.show', $kategori->id) }}" class="text-dark">
                                                    {{ $i++ }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle">
                                                        <img class="rounded-circle header-profile-user" src="{{ $kategori->img_kategori ? asset('storage/images/kategori/'.$kategori->img_kategori) : asset('storage/images/kategori/kategori.png') }}" />
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 mb-1"><a class="text-dark">{{ $kategori->name }}</a></h5>
                                            </td>
                                            <td>{!! substr($kategori->deskripsi, 0, 50) . '...' !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ route('apoteker.kategori.edit', $kategori->id) }}" class="btn btn-warning" title="Edit">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item px-2">
                                                        <form id="delete-form-{{ $kategori->id }}" action="{{ route('apoteker.kategori.destroy', $kategori->id) }}" method="POST"  style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger delete-button" data-id="{{ $kategori->id }}" title="Hapus">
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
                                                    <li class="page-item {{ $kategoris->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $kategoris->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $kategoris->lastPage(); $i++)
                                                        <li class="page-item {{ $i == $kategoris->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $kategoris->url($i) }}" class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ $kategoris->currentPage() == $kategoris->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $kategoris->nextPageUrl() }}" class="page-link" aria-label="Next">
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