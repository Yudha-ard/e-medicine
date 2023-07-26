@extends('backend.layouts.layout')

@section('title', 'Apotek')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Apotek</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Apotek</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.apotek.update', $apoteks->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Apotek Name" value="{{ old('name', $apoteks->name) }}" required>
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone" value="{{ old('phone', $apoteks->phone) }}" required>
                                        @if ($errors->has('phone'))
                                            <div class="text-danger">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="active" value="active" {{ old('status', $apoteks->status) === 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive" {{ old('status', $apoteks->status) === 'inactive' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inactive">
                                                Inactive
                                            </label>
                                        </div>
                                        @if ($errors->has('status'))
                                            <div class="text-danger">
                                                {{ $errors->first('status') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="deskripsi">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="10" placeholder="Enter address apotek">{{ old('address', $apoteks->address) }}</textarea>
                                        @if ($errors->has('address'))
                                            <div class="text-danger">
                                                {{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="actions clearfix d-flex justify-content-end">
                            <div class="row m-2">
                                <ul role="menu" aria-label="Pagination">
                                    <a class="btn btn-info" href="{{ route('admin.apotek') }}" role="menuitem">
                                        <i class="bx bx-arrow-back"></i> Back
                                    </a>
                                    <button class="btn btn-primary" type="submit" role="menuitem">Submit</button>
                                </ul>
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