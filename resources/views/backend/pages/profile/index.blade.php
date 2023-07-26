@extends('backend.layouts.layout')

@section('title', 'Profile')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Profile</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Profile</li>
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
                                    <div class="actions clearfix d-flex justify-content-end">
                                        <a class="btn btn-info" href="{{ Auth::user()->role === 'administrator' ? route('admin.profile.edit') : (Auth::user()->role === 'customer' ? route('customer.profile.edit') : (Auth::user()->role === 'apoteker' ? route('apoteker.profile.edit') : route('kurir.profile.edit'))) }}" role="menuitem">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                    </div>
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
