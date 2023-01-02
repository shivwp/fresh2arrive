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
                        {{ isset($data) && isset($data->id) ? 'Edit Email Template' : 'Create Email Template' }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.email-templates.store') }}" method="POST" enctype="multipart/form-data" id="basic-form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ isset($data) ? $data->id : '' }}">
                            
                            <div class="form-group">
                                <label for="name" class="mt-2"> Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ old('title', isset($data) ? $data->title : '') }}" required>
                                @error('title')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="mt-2"> Email Key <span class="text-danger">*</span></label>
                                <input type="text" name="email_key" class="form-control @error('email_key') is-invalid @enderror" placeholder="Email Key" value="{{ old('email_key', isset($data) ? $data->email_key : '') }}" required>
                                @error('email_key')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="mt-2"> Email Subject <span class="text-danger">*</span></label>
                                <input type="text" name="email_subject" class="form-control @error('email_subject') is-invalid @enderror" placeholder="Email Subject" value="{{ old('email_subject', isset($data) ? $data->email_subject : '') }}" required>
                                @error('email_subject')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="mt-2"> Email Content <span class="text-danger">*</span></label>
                                <textarea name="content" class="ckeditor @error('content') is-invalid @enderror" id="ckeditor" required="required">{{ empty(old('content')) ? (isset($data) ? $data->email_content : '') : old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
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
