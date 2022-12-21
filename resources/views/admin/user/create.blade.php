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
                        Create User
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="basic-form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ isset($data) ? $data->id : '' }}">
                            <input type="hidden" name="driver_id" id="driver_id" value="{{ (isset($data) && isset($data->driver)) ? $data->driver->id : '' }}">
                            <input type="hidden" name="vendor_id" id="vendor_id" value="{{ (isset($data) && isset($data->vendor)) ? $data->vendor->id : '' }}">
                            
                            <h5 class="fw-bolder">{{ 'Basic Information' }}</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', isset($data) ? $data->name : '') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', isset($data) ? $data->email : '') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mt-auto">
                                    <!-- <label for="name" class="mt-2"> Password  <span class="text-danger">{{ isset($data) && isset($data->id) ? '' : '*' }}</span> }} <i class="mdi mdi-information-outline" data-toggle="tooltip" data-placement="right" title="Password must contain atleast one Lower case letter, atleast one Upper case letter, atleast one Number and atleast one Special character."></i></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" minlength="8" {{ isset($data) ? '' : 'required' }}>
                                    @error('password')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror -->

                                    <label for="name" class="mt-2"> Phone <span class="text-danger">*</span></label>
                                    <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone', isset($data) ? $data->phone : '') }}" min="0" minlength="10" maxlength="10" required>
                                    @error('phone')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    @if(!empty($data->profile_image))
                                        <div class="mt-3">
                                            <span class="pip" data-title="{{$data->profile_image}}">
                                                <img src="{{ url(config('app.profile_image')).'/'.$data->profile_image ?? '' }}" alt="" width="150" height="100">
                                            </span>
                                        </div>
                                    @endif
                                    <label for="name" class="mt-2"> Profile Image <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                    <input type="file" name="profileImage" class="form-control @error('profileImage') is-invalid @enderror" accept="image/jpeg,image/png">
                                    <input type="hidden" class="form-control" name="profileImageOld" value="{{ isset($data) ? $data->profile_image : ''}}">
                                    @error('profileImage')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Location <span class="text-danger">*</span></label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Location" value="{{ old('location', isset($data) ? $data->location : '') }}" required>
                                    @error('location')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Latitude <span class="text-danger">*</span></label>
                                    <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Latitude" value="{{ old('latitude', isset($data) ? $data->latitude : '') }}" required>
                                    @error('latitude')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Longitude <span class="text-danger">*</span></label>
                                    <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" value="{{ old('longitude', isset($data) ? $data->longitude : '') }}" required>
                                    @error('longitude')
                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 pt-5 {{ isset($data) ? 'mt-auto' : '' }}">
                                    <div class="row">
                                        <div class="form-group col-md-6 {{ isset($data) ? 'mb-0 mt-auto' : '' }}">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input is_driver" type="checkbox" name="driver" {{ old('driver') ? 'checked' : (isset($data) ? ($data->is_driver ? 'checked' : '' ) : '' ) }} value="1">
                                                    {{ __('Driver') }}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 {{ isset($data) ? 'mb-0 mt-auto' : '' }}">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input is_vendor" type="checkbox" name="vendor" {{ old('vendor') ? 'checked' : (isset($data) ? ($data->is_vendor ? 'checked' : '' ) : '' ) }} value="1">
                                                    {{ __('Vendor') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="driverInfoSection hide" id="driverInfoSection">
                                <h5 class="fw-bolder">{{ 'Driver Information' }}</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Date Of Birth <span class="text-danger">*</span></label>
                                        <input type="date" name="dob" class="form-control is_required @error('dob') is-invalid @enderror" placeholder="Date Of Birth" value="{{ old('dob', (isset($data) && isset($data->driver)) ? $data->driver->dob : '') }}" max="{{ date('Y-m-d'); }}">
                                        @error('dob')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Aadhar Number <span class="text-danger">*</span></label>
                                        <input type="text" name="driverAadhar" class="form-control is_required @error('driverAadhar') is-invalid @enderror" placeholder="Aadhar Number" value="{{ old('driverAadhar', (isset($data) && isset($data->driver)) ? $data->driver->aadhar_no : '') }}">
                                        @error('driverAadhar')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Pan Card Number <span class="text-danger">*</span></label>
                                        <input type="text" name="driverPanCard" class="form-control is_required @error('driverPanCard') is-invalid @enderror" placeholder="Pan Card Number" value="{{ old('driverPanCard', (isset($data) && isset($data->driver)) ? $data->driver->pan_no : '') }}">
                                        @error('driverPanCard')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Vehicle Number <span class="text-danger">*</span></label>
                                        <input type="text" name="driverVehicle" class="form-control is_required @error('driverVehicle') is-invalid @enderror" placeholder="Vehicle Number" value="{{ old('driverVehicle', (isset($data) && isset($data->driver)) ? $data->driver->vehicle_no : '') }}">
                                        @error('driverVehicle')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 {{ isset($data) ? 'mt-auto' : '' }}">
                                        <label for="name" class="mt-2"> Driving Licence Number <span class="text-danger">*</span></label>
                                        <input type="text" name="driverDrivingLicence" class="form-control is_required @error('driverDrivingLicence') is-invalid @enderror" placeholder="Driving License Number" value="{{ old('driverDrivingLicence', (isset($data) && isset($data->driver)) ? $data->driver->licence_no : '') }}">
                                        @error('driverDrivingLicence')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->bank_statement))
                                            <div class="">
                                                <span class="pip" data-title="{{$data->driver->bank_statement}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->bank_statement ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Bank Statement & Cancel Cheque <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverStatement" class="form-control is_required @error('driverStatement') is-invalid @enderror" accept="image/jpeg,image/png">
                                        <input type="hidden" class="form-control" name="driverStatementOld" value="{{ (isset($data) && isset($data->driver->bank_statement)) ? $data->driver->bank_statement : ''}}">
                                        @error('driverStatement')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->licence_front_image))
                                            <div class="mt-3">
                                                <span class="pip" data-title="{{$data->driver->licence_front_image}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->licence_front_image ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Licence Front Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverLicenceFront" class="form-control is_required @error('driverLicenceFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                        <input type="hidden" class="form-control" name="driverLicenceFrontOld" value="{{ (isset($data) && isset($data->driver->licence_front_image)) ? $data->driver->licence_front_image : ''}}">
                                        @error('driverLicenceFront')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->licence_back_image))
                                            <div class="mt-3">
                                                <span class="pip" data-title="{{$data->driver->licence_back_image}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->licence_back_image ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Licence Back Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverLicenceBack" class="form-control is_required @error('driverLicenceBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                        <input type="hidden" class="form-control" name="driverLicenceBackOld" value="{{ (isset($data) && isset($data->driver->licence_back_image)) ? $data->driver->licence_back_image : ''}}">
                                        @error('driverLicenceBack')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->aadhar_front_image))
                                            <div class="even mt-3">
                                                <span class="pip" data-title="{{$data->driver->aadhar_front_image}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->aadhar_front_image ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Aadhar Card Front <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverAadharFront" class="form-control is_required @error('driverAadharFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                        <input type="hidden" class="form-control" name="driverAadharFrontOld" value="{{ (isset($data) && isset($data->driver->aadhar_front_image)) ? $data->driver->aadhar_front_image : ''}}">
                                        @error('driverAadharFront')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->aadhar_back_image))
                                            <div class="even mt-3">
                                                <span class="pip" data-title="{{$data->driver->aadhar_back_image}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->aadhar_back_image ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Aadhar Card Back <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverAadharBack" class="form-control is_required @error('driverAadharBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                        <input type="hidden" class="form-control" name="driverAadharBackOld" value="{{ (isset($data) && isset($data->driver->aadhar_back_image)) ? $data->driver->aadhar_back_image : ''}}">
                                        @error('driverAadharBack')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        @if(!empty($data->driver->pan_card_image))
                                            <div class="even mt-3">
                                                <span class="pip" data-title="{{$data->driver->pan_card_image}}">
                                                    <img src="{{ url(config('app.driver_document')).'/'.$data->driver->pan_card_image ?? "" }}" alt="" width="150" height="100">
                                                </span>
                                            </div>
                                        @endif
                                        <label for="name" class="mt-2"> Pan Card Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverPanImage" class="form-control is_required @error('driverPanImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                        <input type="hidden" class="form-control" name="driverPanImageOld" value="{{ (isset($data) && isset($data->driver->pan_card_image)) ? $data->driver->pan_card_image : ''}}">
                                        @error('driverPanImage')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 pt-5 {{ isset($data) ? 'mt-auto' : '' }}">
                                        <div class="row">
                                            <div class="form-group col-md-6 {{ isset($data) ? 'mb-0 mt-auto' : '' }}">
                                                <div class="form-check">
                                                    <!-- <div class="form-check-label">
                                                        <input type="checkbox" class="form-check-input">Vendor
                                                    </div> -->
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="driverVerify" {{ old('driverVerify') ? 'checked' : (isset($data) ? ($data->as_driver_verified ? 'checked' : '' ) : '' ) }} value="1">
                                                        {{ __('Approve as Driver') }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 {{ isset($data) ? 'mb-0 mt-auto' : '' }}">
                                                <div class="form-check">
                                                    <!-- <div class="form-check-label">
                                                        <input type="checkbox" class="form-check-input">Vendor
                                                    </div> -->
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="driverMode"  {{ old('driverMode') ? 'checked' : (isset($data) ? ($data->is_driver_online ? 'checked' : '' ) : '' ) }} value="1">
                                                        {{ __('Delivery Mode On/Off') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="vendorInfoSection hide" id="vendorInfoSection">
                            <!-- <div class="vendorInfoSection @if(isset($data) && $data->is_vendor==true) @else hide @endif   " id="vendorInfoSection"> -->
                                <h5 class="fw-bolder">{{ 'Vendor Information' }}</h5>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="vendor-info-tab" data-bs-toggle="tab" data-bs-target="#vendorInfo" type="button" role="tab" aria-controls="vendorInfo" aria-selected="true">Vendor Info</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="store-info-tab" data-bs-toggle="tab" data-bs-target="#storeInfo" type="button" role="tab" aria-controls="storeInfo" aria-selected="false">Store Info</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="vendorInfo" role="tabpanel" aria-labelledby="vendor-info-tab">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Aadhar Number <span class="text-danger">*</span></label>
                                                <input type="text" name="aadharNumber" class="form-control is_required @error('aadharNumber') is-invalid @enderror" placeholder="Aadhar Number" value="{{ old('aadharNumber', (isset($data) && isset($data->vendor)) ? $data->vendor->aadhar_no : '') }}">
                                                @error('aadharNumber')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Pan Card Number <span class="text-danger">*</span></label>
                                                <input type="text" name="panCardNumber" class="form-control is_required @error('panCardNumber') is-invalid @enderror" placeholder="Pan Card Number" value="{{ old('panCardNumber', (isset($data) && isset($data->vendor)) ? $data->vendor->pan_no : '') }}">
                                                @error('panCardNumber')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                @if(!empty($data->vendor->bank_statement))
                                                    <div class="even mt-3">
                                                        <span class="pip" data-title="{{$data->vendor->bank_statement}}">
                                                            <img src="{{ url(config('app.vendor_document')).'/'.$data->vendor->bank_statement ?? "" }}" alt="" width="150" height="100">
                                                        </span>
                                                    </div>
                                                @endif
                                                <label for="name" class="mt-2"> Bank Statement & Cancel Cheque <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="bankStatement" class="form-control is_required @error('bankStatement') is-invalid @enderror" accept="image/png,image/jpeg">
                                                <input type="hidden" class="form-control" name="bankStatementOld" value="{{ (isset($data) && isset($data->vendor->bank_statement)) ? $data->vendor->bank_statement : ''}}">
                                                @error('bankStatement')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                @if(!empty($data->vendor->pan_card_image))
                                                    <div class="mt-3">
                                                        <span class="pip" data-title="{{$data->vendor->pan_card_image}}">
                                                            <img src="{{ url(config('app.vendor_document')).'/'.$data->vendor->pan_card_image ?? "" }}" alt="" width="150" height="100">
                                                        </span>
                                                    </div>
                                                @endif
                                                <label for="name" class="mt-2"> Pan Card Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="panCardImage" class="form-control is_required @error('panCardImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                                <input type="hidden" class="form-control" name="panCardImageOld" value="{{ (isset($data) && isset($data->vendor->pan_card_image)) ? $data->vendor->pan_card_image : ''}}">
                                                @error('panCardImage')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                @if(!empty($data->vendor->aadhar_front_image))
                                                    <div class="even mt-3">
                                                        <span class="pip" data-title="{{$data->vendor->aadhar_front_image}}">
                                                            <img src="{{ url(config('app.vendor_document')).'/'.$data->vendor->aadhar_front_image ?? "" }}" alt="" width="150" height="100">
                                                        </span>
                                                    </div>
                                                @endif
                                                <label for="name" class="mt-2"> Aadhar Card Front <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="aadharCardFront" class="form-control is_required @error('aadharCardFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                                <input type="hidden" class="form-control" name="aadharCardFrontOld" value="{{ (isset($data) && isset($data->vendor->aadhar_front_image)) ? $data->vendor->aadhar_front_image : ''}}">
                                                @error('aadharCardFront')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                @if(!empty($data->vendor->aadhar_back_image))
                                                    <div class="mt-3">
                                                        <span class="pip" data-title="{{$data->vendor->aadhar_back_image}}">
                                                            <img src="{{ url(config('app.vendor_document')).'/'.$data->vendor->aadhar_back_image ?? "" }}" alt="" width="150" height="100">
                                                        </span>
                                                    </div>
                                                @endif
                                                <label for="name" class="mt-2"> Aadhar Card Back <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="aadharCardBack" class="form-control is_required @error('aadharCardBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                                <input type="hidden" class="form-control" name="aadharCardBackOld" value="{{ (isset($data) && isset($data->vendor->aadhar_back_image)) ? $data->vendor->aadhar_back_image : ''}}">
                                                @error('aadharCardBack')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                        
                                        
                                        
                                            <div class="form-group col-md-6">
                                                <label class="mt-2"> Delivery Range <span class="text-danger">*</span></label>
                                                <select name="deliveryRange" class="form-control is_required form-select @error('deliveryRange') is-invalid @enderror">
                                                    <option value="" {{ old('deliveryRange') ? ((old('deliveryRange') == '') ? 'selected' : '' ) : ( (isset($data) && $data->delivery_range == 0) ? 'selected' : '' ) }} >Select Range</option>
                                                    @foreach($range as $key => $value) 
                                                        <option value={{$key}} {{ old('deliveryRange') ? ((old('deliveryRange') == $key) ? 'selected' : '' ) : ( (isset($data) && $data->delivery_range == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('deliveryRange')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Admin Commission <span class="text-danger">*</span></label>
                                                <input type="text" name="admin_commission" class="form-control is_required @error('admin_commission') is-invalid @enderror" placeholder="Admin Commission" value="{{ old('admin_commission', isset($data) ? $data->admin_commission : '') }}">
                                                @error('admin_commission')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="vendorVerify" {{ old('vendorVerify') ? 'checked' : (isset($data) ? ($data->as_vendor_verified ? 'checked' : '' ) : '' ) }} value="1">
                                                        {{ __('Approve as Vendor') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeInfo" role="tabpanel" aria-labelledby="store-info-tab">
                                        {{ old('start_time[1]') }}
                                        {{-- $data->vendor_availability --}}
                                        
                                        <div class="form-group">
                                            
                                            <label class="mt-2"> Store Timing </label>

                                            @if(isset($data) && (count($data->vendor_availability)>0))
                                                @foreach($data->vendor_availability as $value)
                                                    <input type="hidden" name="vendor_available_id[]" value="{{ $value->id }}">

                                                    <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <div class="form-check">
                                                                    <label class="form-check-label text-muted">
                                                                        <input class="form-check-input " type="checkbox" name="weekday[{{$value->week_day}}]" {{ $value->status == 1 ? 'checked' : '' }} value="1"> {{ $week_arr[$value->week_day] }}
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <input type="time" name="start_time[{{$value->week_day}}]" class="form-control" value="{{ $value->start_time }}">
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <input type="time" name="end_time[{{$value->week_day}}]" class="form-control" value="{{ $value->end_time }}">
                                                            </div>
                                                        </div>
                                                @endforeach
                                            @else
                                                @for($i=1; $i<=7; $i++)
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            <div class="form-check">
                                                                <label class="form-check-label text-muted">
                                                                    <input class="form-check-input " type="checkbox" name="weekday[{{$i}}]" {{ old('weekday[$i]') ? 'checked' : '' }} value="1"> {{ $week_arr[$i] }}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-3">
                                                            <input type="time" name="start_time[{{$i}}]" class="form-control" value="{{ old('start_time[$i]'),'' }}">
                                                        </div>

                                                        <div class="form-group col-md-3">
                                                            <input type="time" name="end_time[{{$i}}]" class="form-control" value="{{ old('start_time[$i]'),'' }}">
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                @if(!empty($data->vendor->store_image))
                                                    <div class="mt-3">
                                                        <span class="pip" data-title="{{$data->vendor->store_image}}">
                                                            <img src="{{ url(config('app.vendor_document')).'/'.$data->vendor->store_image ?? "" }}" alt="" width="150" height="100">
                                                        </span>
                                                    </div>
                                                @endif
                                                <label for="name" class="mt-2"> Store Image <span class="text-danger">*</span> <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="storeImage" class="form-control is_required @error('storeImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                                <input type="hidden" class="form-control" name="storeImageOld" value="{{ (isset($data) && isset($data->vendor->store_image)) ? $data->vendor->store_image : ''}}">
                                                @error('storeImage')
                                                    <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="storeOpen" {{ old('storeOpen') ? 'checked' : (isset($data) ? ($data->is_vendor_online ? 'checked' : '' ) : '' ) }}>
                                                        {{ __('Store Open') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="self_delivery" {{ old('self_delivery') ? 'checked' : (isset($data) ? ($data->self_delivery ? 'checked' : '' ) : '' ) }} value="1">
                                                        {{ __('Self Delivery') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

@section('scripts')
<script>
    
$(document).ready(function(){
    
    // $(document).on('click', 'input', function(){

    //     $(this).next('span.invalid-feedback.form-invalid').css('display','none');
    //     console.log($(this).next('span.invalid-feedback.form-invalid'));

    //     // $(this).closest('span.invalid-feedback.form-invalid').css('display','none');
    //     // console.log($(this).closest('span.invalid-feedback.form-invalid'));
    // });

    $(document).on("change",".is_driver", function(){

        if(this.checked == true) {
            $('.driverInfoSection').removeClass("hide");
            $('.driverInfoSection .is_required').attr('required',"required");
        } 
        else {
            $('.driverInfoSection').addClass("hide");
            $('.driverInfoSection .is_required').removeAttr('required');
        }

    });

    if($('.is_driver').is(":checked") == true) {
        $('.driverInfoSection').removeClass("hide");
        if($('#id').val() == "") {
            $('.driverInfoSection .is_required').attr('required',"required");
        }
    }
    else {
        $('.driverInfoSection').addClass("hide");
        $('.driverInfoSection .is_required').removeAttr('required');
    }

    $(document).on('change','.is_vendor', function(){

        if(this.checked == true) {
            $('.vendorInfoSection').removeClass("hide");
            $('.vendorInfoSection .is_required').attr('required',"required");
        } 
        else {
            $('.vendorInfoSection').addClass("hide");
            $('.vendorInfoSection .is_required').removeAttr('required');
        }

    });

    if($('.is_vendor').is(":checked") == true) {
        $('.vendorInfoSection').removeClass("hide");
        if($('#id').val() == "") {
            $('.vendorInfoSection .is_required').attr('required',"required");
        }
    }
    else {
        $('.vendorInfoSection').addClass("hide");
        $('.vendorInfoSection .is_required').removeAttr('required');
    } 
    
});
</script>
@endsection