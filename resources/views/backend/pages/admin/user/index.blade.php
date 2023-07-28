@extends('backend.layouts.layout')

@section('title', 'User')

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

                const userId = this.getAttribute('data-id');

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
                        document.getElementById('delete-form-' + userId).submit();
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
                        <h4 class="mb-sm-0 font-size-18">User</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">User</li>
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
                                <a class="btn btn-info" href="{{ route('admin.user.create') }}" role="menuitem">
                                    <i class="bx bx-plus"></i> Add User
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 70px;">Profile</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i =1 @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.user.show', $user->id) }}" class="text-dark">
                                                    {{ $i++ }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle">
                                                        <img class="rounded-circle header-profile-user" src="{{ $user->img_profile ? asset('storage/images/user/'.$user->img_profile) : asset('storage/images/user/user.png') }}" />
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 mb-1"><a class="text-dark">{{ $user->name }}</a></h5>
                                                <p class="mb-0 badge badge-soft-primary font-size-11 m-1">{{ $user->role }}</p>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{!! substr($user->address, 0, 50) . '...' !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                            <i class="bx bx-edit"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST"  style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger text-white btn-sm delete-button" data-id="{{ $user->id }}" title="Hapus">
                                                                <i class="bx bx-trash"></i> Hapus
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
                                                    <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                                                        <a href="{{ $users->previousPageUrl() }}" class="page-link" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                                        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $users->url($i) }}" class="page-link">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                                                        <a href="{{ $users->nextPageUrl() }}" class="page-link" aria-label="Next">
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