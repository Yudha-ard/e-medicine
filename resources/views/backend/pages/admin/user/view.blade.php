@extends('backend.layouts.layout')

@section('title', 'User')

@section('content')
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
                                <li class="breadcrumb-item">User</li>
                                <li class="breadcrumb-item active">View</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>{{ $users->name }} to {{ env('APP_NAME') }} Apps.</p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row"> 
                                <div class="col-sm-12">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <img src="{{ URL::asset('storage/images/user/'.$users->img_profile)}}" alt="" class="img-thumbnail rounded-circle" />
                                    </div>
                                    <h5 class="font-size-15 text-truncate">{{ $users->name }}</h5>
                                    <span class="mb-0 text-truncate badge badge-soft-primary font-size-11 m-1">{{ $users->role }}</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                            <h4 class="card-title mb-4">Personal Information</h4>
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Full Name :</th>
                                            <td>{{ $users->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status :</th>
                                            @if ($users->status === 'active')
                                                <td><span class="badge badge-soft-success">{{ $users->status }}</span></td>
                                            @elseif ($users->status === 'inactive')
                                                <td><span class="badge badge-soft-info">{{ $users->status }}</span></td>
                                            @else
                                                <td>{{ $users->status }}</td>
                                            @endif
                                        </tr>
                                        @if ($users->role === 'apoteker')
                                            <tr>
                                                <th scope="row">Apotek :</th>
                                                @if (!empty($users->apotek_id) && !is_null($users->apotek_id))
                                                    <td>{{ $users->apotek->name }}</td>
                                                @else
                                                    <td><i>Tidak Ada</i></td>
                                                @endif
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">Mobile :</th>
                                            @if (is_null($users->phone))
                                                <td> - </td>
                                            @else
                                                <td>{{ $users->phone }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">E-mail :</th>
                                            <td>{{ $users->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address :</th>
                                            @if (is_null($users->address))
                                                <td> - </td>
                                            @else
                                                <td>{{ $users->address }}</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                          
                        </div>
                    </div>
                    <!-- end card -->
                    <div class="actions clearfix">
                        <ul role="menu" aria-label="Pagination">
                            <a href="{{ route('admin.user') }}" class="btn btn-primary" role="menuitem">
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
