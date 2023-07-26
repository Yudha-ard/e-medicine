@extends('backend.layouts.layout')

@section('title', 'Obat')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Obat</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Obat</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('apoteker.obat.update', $obats->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <img src="{{ $obats->img_obat ? URL::asset('storage/images/obat/'.$obats->img_obat) : URL::asset('storage/images/obat/obat.png') }}" alt="" class="img-thumbnail rounded-circle w-55" />
                                        </li>
                                        <div class="mt-3">
                                            <label for="formFile" class="form-label">Photo</label>
                                            <input type="file" class="form-control form-control-sm" name="img_obat" id="img_obat" value="{{ old('img_obat', $obats->img_obat) }}">
                                            @if ($errors->has('img_obat'))
                                                <div class="text-danger">
                                                    {{ $errors->first('img_obat') }}
                                                </div>
                                            @endif
                                        </div>
                                    </ul>
                                </div>
                                
                                <div class="content clearfix">
                                    <section id="vertical-example-p-0" role="tabpanel" aria-labelledby="vertical-example-h-0" class="body current" aria-hidden="false">
                                            <div class="row">
                                            <input type="hidden" name="apotek_id" id="apotek_id" value="{{ old('apotek_id', $obats->apotek_id) }}" required>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Fullname" value="{{ old('name', $obats->name) }}" required>
                                                        @if ($errors->has('name'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="stock">Stock</label>
                                                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Enter Stock" value="{{ old('stock', $obats->stock) }}" required>
                                                        @if ($errors->has('stock'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('stock') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="harga">Harga</label>
                                                        <input type="number" class="form-control" name="harga" id="harga" placeholder="Enter Price" value="{{ old('harga', $obats->harga) }}" required>
                                                        @if ($errors->has('harga'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('harga') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="diskon">Diskon</label>
                                                        <input type="number" class="form-control" name="diskon" id="diskon" placeholder="Enter Discount" value="{{ old('diskon', $obats->diskon) }}" required>
                                                        @if ($errors->has('diskon'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('diskon') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="status">Status</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="tersedia" value="Tersedia" {{ old('status', $obats->status) === 'Tersedia' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="tersedia">
                                                                Tersedia
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="habis" value="Habis" {{ old('status', $obats->status) === 'Habis' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="habis">
                                                                Habis
                                                            </label>
                                                        </div>
                                                        @error('status')
                                                            <div class="text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>  
                                                </div>
                                                <div class="col-lg-6'">
                                                    <div class="mb-3">
                                                    <label for="role">Kategori</label>
                                                        <select class="form-select" name="kategori_id" id="kategori_id">
                                                            <option value="">-- Select Kategori --</option>
                                                            @foreach($kategoris as $kategori)
                                                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $obats->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('kategori_id'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('kategori_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="address">Deskripsi</label>
                                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" placeholder="Enter Your Description">{{ old('deskripsi', $obats->deskripsi) }}</textarea>
                                                        @if ($errors->has('deskripsi'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('deskripsi') }}
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
                                            <a class="btn btn-info" href="{{ route('apoteker.obat') }}" role="menuitem"><i class="bx bx-arrow-back"></i> Back</a>
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