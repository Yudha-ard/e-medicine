@extends('backend.layouts.layout')

@section('title', 'Profile')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Profile</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ Auth::user()->role === 'administrator' ? route('admin.profile.update') : (Auth::user()->role === 'customer' ? route('customer.profile.update') : (Auth::user()->role === 'apoteker' ? route('apoteker.profile.update') : route('kurir.profile.update'))) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="vertical-example" class="vertical-wizard wizard clearfix vertical" role="application">

                                <div class="steps clearfix">
                                    <ul role="tablist">
                                        <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                            <img src="{{ URL::asset('storage/images/user/'.$users->img_profile)}}"
                                                alt="" class="img-thumbnail rounded-circle w-55" />
                                        </li>
                                        <div class="mt-3">
                                            <label for="formFile" class="form-label">Photo</label>
                                            <input type="file" class="form-control form-control-sm" name="img_profile" id="img_profile" value="{{ old('img_profile', $users->img_profile) }}">
                                        </div>
                                        @if ($errors->has('img_profile'))
                                            <div class="text-danger">
                                                {{ $errors->first('img_profile') }}
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                                
                                <div class="content clearfix">
                                    <section id="vertical-example-p-0" role="tabpanel" aria-labelledby="vertical-example-h-0" class="body current" aria-hidden="false">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="name">Full Name</label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Fullname" value="{{ old('name', $users->name) }}" required>
                                                        @if ($errors->has('name'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="email">E-mail</label>
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your E-mail" value="{{ old('email', $users->email) }}" required>
                                                        @if ($errors->has('email'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="phone">Phone</label>
                                                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Your Phone" value="{{ old('phone', $users->phone) }}" required>
                                                        @if ($errors->has('phone'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('phone') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="password">Password</label>
                                                        <div class="input-group auth-pass-inputgroup">
                                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" aria-label="Password" aria-describedby="password-addon" value="{{ old('password') }}" required>
                                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                            @if ($errors->has('password'))
                                                                <div class="text-danger">
                                                                    {{ $errors->first('password') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="address">Address</label>
                                                        <textarea name="address" id="address" class="form-control" rows="5" placeholder="Enter Your Address">{{ old('address', $users->address) }}</textarea>
                                                        @if ($errors->has('address'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('address') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                    </section>

                                </div>
                                <div class="actions clearfix">
                                    <ul role="menu" aria-label="Pagination">
                                        <li aria-hidden="false" aria-disabled="false">
                                            <a class="btn btn-info" href="{{ Auth::user()->role === 'administrator' ? route('admin.profile') : (Auth::user()->role === 'customer' ? route('customer.profile') : (Auth::user()->role === 'apoteker' ? route('apoteker.profile') : route('kurir.profile'))) }}" role="menuitem">Back</a>
                                        </li>
                                        <li aria-hidden="false" aria-disabled="false">
                                            <button class="btn btn-primary" type="submit" role="menuitem">Submit</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            </form>
        </div>
    </div>
</div>
@stop