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
                        App Setting
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.app-setting.store') }}" method="POST" enctype="multipart/form-data" id="basic-form">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> App Version <span class="text-danger">*</span></label>
                                    <input type="text" name="app_version" class="form-control @error('app_version') is-invalid @enderror" placeholder="App Version" value="{{ old('app_version', isset($data) && isset($data['app_version']) ? $data['app_version'] : '' ) }}" required>
                                    @error('app_version')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Maintenance Mode <span class="text-danger">*</span></label>
                                    <select name="maintenance_mode" class="form-control is_required form-select @error('maintenance_mode') is-invalid @enderror" required>
                                        <option value="false" {{ old('maintenance_mode') ? ((old('maintenance_mode') == 'false') ? 'selected' : '' ) : (isset($data) && isset($data['maintenance_mode']) ? ($data['maintenance_mode'] == 'false' ? 'selected' : '' ) : '' ) }} >False</option>
                                        <option value="true" {{ old('maintenance_mode') ? ((old('maintenance_mode') == 'true') ? 'selected' : '' ) : (isset($data) && isset($data['maintenance_mode']) ? ($data['maintenance_mode'] == 'true' ? 'selected' : '' ) : '' ) }} >True</option>
                                    </select>
                                    @error('maintenance_mode')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Force Update Mode<span class="text-danger">*</span></label>
                                    <select name="force_update" class="form-control is_required form-select @error('force_update') is-invalid @enderror" required>
                                        <option value="false" {{ old('force_update') ? ((old('force_update') == 'false') ? 'selected' : '' ) : (isset($data) && isset($data['force_update']) ? ($data['force_update'] == 'false' ? 'selected' : '' ) : '' ) }} >False</option>
                                        <option value="true" {{ old('force_update') ? ((old('force_update') == 'true') ? 'selected' : '' ) : (isset($data) && isset($data['force_update']) ? ($data['force_update'] == 'true' ? 'selected' : '' ) : '' ) }} >True</option>
                                    </select>
                                    @error('force_update')
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
