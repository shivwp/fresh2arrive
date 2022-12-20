@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if(Session::has('success'))
            @section('scripts')
                <script>swal("Good job!", "{{ Session::get('success') }}", "success");</script>
            @endsection
        @endif

        @if(Session::has('error'))
            @section('scripts')
                <script>swal("Oops...", "{{ Session::get('error') }}", "error");</script>
            @endsection
        @endif
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header border-bottom">
                        {{ isset($data) && isset($data->id) ? 'Edit Product' : 'Create Product' }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="basic-form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ isset($data) ? $data->id : '' }}">
                            <!-- <input type="hidden" name="slug" id="slug" value="{{ isset($data) ? $data->slug : '' }}"> -->
                            
                            <div class="form-group">
                                <label for="name" class="mt-2"> Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ old('title', isset($data) ? $data->name : '') }}" required>
                                @error('title')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="form-group {{ isset($data) ? 'col-md-6' : '' }} ">
                                    <label for="name" class="mt-2"> Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png" {{ isset($data) && isset($data->id) ? '' : 'required' }}>
                                    <input type="hidden" class="form-control" name="imageOld" value="{{ isset($data) ? $data->image : ''}}">
                                    @error('image')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                @if(!empty($data->image))
                                    <div class="form-group col-md-6">
                                        <div class="mt-3">
                                            <span class="pip" data-title="{{$data->image}}">
                                                <img src="{{ url(config('app.product_image')).'/'.$data->image ?? '' }}" alt="" width="150" height="100">
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control form-select @error('category') is-invalid @enderror" required>
                                        <option value="" {{ old('category') ? ((old('category') == '') ? 'selected' : '' ) : ( (isset($data) && $data->category_id == 0) ? 'selected' : '' ) }} >Select Category</option>
                                        @foreach($categories as $key => $value) 
                                            <option value={{$key}} {{ old('category') ? ((old('category') == $key) ? 'selected' : '' ) : ( (isset($data) && $data->category_id == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> SKU <span class="text-danger">*</span></label>
                                    <input type="text" name="SKU" class="form-control @error('SKU') is-invalid @enderror" placeholder="SKU" value="{{ old('SKU', isset($data) && isset($data->SKU) ? $data->SKU : '') }}" required>
                                    @error('SKU')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" placeholder="Quantity" value="{{ old('qty', isset($data) && isset($data->qty) ? $data->qty : '') }}" required min="0">
                                    @error('qty')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                <label class="mt-2"> Quantity Type <span class="text-danger">*</span></label>
                                    <select name="qty_type" class="form-control form-select @error('qty_type') is-invalid @enderror" required>
                                        <option value="" {{ old('qty_type') ? ((old('qty_type') == '') ? 'selected' : '' ) : ( (isset($data) && $data->qty_type == 0) ? 'selected' : '' ) }} >Select Quantity Type</option>
                                        @foreach($units as $key => $value) 
                                            <option value={{$key}} {{ old('qty_type') ? ((old('qty_type') == $key) ? 'selected' : '' ) : ( (isset($data) && $data->qty_type == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('qty_type')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Price <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price', isset($data) && isset($data->price) ? $data->price : '') }}" required min="0" max="9999.99" step="0.01">
                                    @error('price')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control form-select @error('status') is-invalid @enderror" required>
                                        <option value="" {{ old('status') ? ((old('status') == '') ? 'selected' : '' ) : ( (isset($data) && $data->status == 0) ? 'selected' : '' ) }} >Select Status</option>
                                        <option value="1" {{ old('status') ? ((old('status') == 1) ? 'selected' : '' ) : ( (isset($data) && $data->status == 1) ? 'selected' : '' ) }} >Active</option>
                                        <option value="0" {{ old('status') ? ((old('status') == 0) ? 'selected' : '' ) : ( (isset($data) && $data->status == 0) ? 'selected' : '' ) }} >In-Active</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <input class="btn btn-primary" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
