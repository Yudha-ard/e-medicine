@extends('backend.layouts.layout')

@section('title', 'Kategori')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Kategori</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kategori</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('apoteker.kategori.update', $kategoris->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-3">
                                    <label for="formFile" class="form-label">Photo</label>
                                    <input type="file" class="form-control form-control-sm" name="img_kategori" id="img_kategori" value="{{ old('img_kategori', $kategoris->img_kategori) }}">
                                    @if ($errors->has('img_kategori'))
                                        <div class="text-danger">
                                            {{ $errors->first('img_kategori') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Kategori Name" value="{{ old('name', $kategoris->name) }}" required>
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" placeholder="Enter kategori deskripsi">{{ old('deskripsi', $kategoris->deskripsi) }}</textarea>
                                        @if ($errors->has('deskripsi'))
                                            <div class="text-danger">
                                                {{ $errors->first('deskripsi') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="actions clearfix d-flex justify-content-end">
                            <div class="row m-2">
                                <ul role="menu" aria-label="Pagination">
                                    <a class="btn btn-info" href="{{ route('apoteker.kategori') }}" role="menuitem">
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