@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if(Session::has('error'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
        @endif
        @if(Session::has('success'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('success') }}</p>
        @endif
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header border-bottom">
                        Create User
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($certificate) ? $certificate->id : '' }}">
                            
                            <h5 class="fw-bolder">{{ 'Basic Information' }}</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name'),'' }}" required>
                                    @error('name')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Email *</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email'),'' }}" required>
                                    @error('email')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Phone *</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone'),'' }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Password *</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Profile Image <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                    <input type="file" name="profileImage" class="form-control @error('profileImage') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('profileImage')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Location *</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Location" value="{{ old('location'),'' }}" required>
                                    @error('location')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Latitude *</label>
                                    <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Latitude" value="{{ old('latitude'),'' }}" required>
                                    @error('latitude')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> Longitude *</label>
                                    <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" value="{{ old('longitude'),'' }}" required>
                                    @error('longitude')
                                        <span class="invalid-feedback fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input class="form-check-input is_driver" type="checkbox" name="driver"  {{ old('driver') ? 'checked' : '' }} value="1">
                                    {{ __('Driver') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input class="form-check-input is_vendor" type="checkbox" name="vendor"  {{ old('vendor') ? 'checked' : '' }} value="1">
                                    {{ __('Vendor') }}
                                </label>
                            </div>

                            <div class="driverInfoSection hide" id="driverInfoSection">
                                <h5 class="fw-bolder">{{ 'Driver Information' }}</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Date Of Birth *</label>
                                        <input type="date" name="dob" class="form-control is_required @error('dob') is-invalid @enderror" placeholder="Date Of Birth" value="{{ old('dob'),'' }}" max="{{ date('Y-m-d'); }}">
                                        @error('dob')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Aadhar Number *</label>
                                        <input type="text" name="driverAadhar" class="form-control is_required @error('driverAadhar') is-invalid @enderror" placeholder="Aadhar Number" value="{{ old('driverAadhar'),'' }}">
                                        @error('driverAadhar')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Pan Card Number *</label>
                                        <input type="text" name="driverPanCard" class="form-control is_required @error('driverPanCard') is-invalid @enderror" placeholder="Pan Card Number" value="{{ old('driverPanCard'),'' }}">
                                        @error('driverPanCard')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Vehicle Number *</label>
                                        <input type="text" name="driverVehicle" class="form-control is_required @error('driverVehicle') is-invalid @enderror" placeholder="Vehicle Number" value="{{ old('driverVehicle'),'' }}">
                                        @error('driverVehicle')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Driving Licence Number *</label>
                                        <input type="text" name="driverDrivingLicence" class="form-control is_required @error('driverDrivingLicence') is-invalid @enderror" placeholder="Driving License Number" value="{{ old('driverDrivingLicence'),'' }}">
                                        @error('driverDrivingLicence')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Bank Statement & Cancel Cheque * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverStatement" class="form-control is_required @error('driverStatement') is-invalid @enderror" accept="image/jpeg,image/png">
                                        @error('driverStatement')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Licence Front Image * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverLicenceFront" class="form-control is_required @error('driverLicenceFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                        @error('driverLicenceFront')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Licence Back Image * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverLicenceBack" class="form-control is_required @error('driverLicenceBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                        @error('driverLicenceBack')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Aadhar Card Front * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverAadharFront" class="form-control is_required @error('driverAadharFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                        @error('driverAadharFront')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Aadhar Card Back * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverAadharBack" class="form-control is_required @error('driverAadharBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                        @error('driverAadharBack')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="mt-2"> Pan Card Image * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                        <input type="file" name="driverPanImage" class="form-control is_required @error('driverPanImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                        @error('driverPanImage')
                                            <span class="invalid-feedback fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 pt-5">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <!-- <div class="form-check-label">
                                                        <input type="checkbox" class="form-check-input">Vendor
                                                    </div> -->
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="driverVerify"  {{ old('driverVerify') ? 'checked' : '' }} value="1">
                                                        {{ __('Approve as Driver') }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <!-- <div class="form-check-label">
                                                        <input type="checkbox" class="form-check-input">Vendor
                                                    </div> -->
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="driverMode"  {{ old('driverMode') ? 'checked' : '' }} value="1">
                                                        {{ __('Delivery Mode On/Off') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="vendorInfoSection hide" id="vendorInfoSection">
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
                                                <label for="name" class="mt-2"> Aadhar Number *</label>
                                                <input type="text" name="aadharNumber" class="form-control is_required @error('aadharNumber') is-invalid @enderror" placeholder="Aadhar Number" value="{{ old('aadharNumber'),'' }}">
                                                @error('aadharNumber')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Pan Card Number *</label>
                                                <input type="text" name="panCardNumber" class="form-control is_required @error('panCardNumber') is-invalid @enderror" placeholder="Pan Card Number" value="{{ old('panCardNumber'),'' }}">
                                                @error('panCardNumber')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Bank Statement & Cancel Cheque * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="bankStatement" class="form-control is_required @error('bankStatement') is-invalid @enderror" accept="image/png,image/jpeg">
                                                @error('bankStatement')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Pan Card Image * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="panCardImage" class="form-control is_required @error('panCardImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                                @error('panCardImage')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Aadhar Card Front * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="aadharCardFront" class="form-control is_required @error('aadharCardFront') is-invalid @enderror" accept="image/png,image/jpeg">
                                                @error('aadharCardFront')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Aadhar Card Back * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="aadharCardBack" class="form-control is_required @error('aadharCardBack') is-invalid @enderror" accept="image/png,image/jpeg">
                                                @error('aadharCardBack')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="mt-2"> Delivery Range *</label>
                                                <select name="deliveryRange" class="form-control is_required form-select">
                                                    <option value="" {{ old('deliveryRange') == '' ? 'selected' : '' }} >Select Range</option>
                                                    <option value="5" {{ old('deliveryRange') == 5 ? 'selected' : '' }} >5 km</option>
                                                    <option value="10" {{ old('deliveryRange') == 10 ? 'selected' : '' }} >10 km</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Admin Commission *</label>
                                                <input type="text" name="admin_commission" class="form-control is_required @error('admin_commission') is-invalid @enderror" placeholder="Admin Commission" value="{{ old('admin_commission'),'' }}">
                                                @error('admin_commission')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="vendorVerify"  {{ old('vendorVerify') ? 'checked' : '' }} value="1">
                                                        {{ __('Approve as Vendor') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeInfo" role="tabpanel" aria-labelledby="store-info-tab">
                                        {{ old('start_time[1]') }}
                                        <div class="form-group">
                                            
                                            <label class="mt-2"> Store Timing * </label>

                                            @for($i=1; $i<=7; $i++)
                                                <div class="row">
                                                    
                                                    <div class="form-group col-md-3">
                                                        <div class="form-check">
                                                            <label class="form-check-label text-muted">
                                                                <input class="form-check-input " type="checkbox" name="weekday[{{$i}}]"  {{ old('weekday[$i]') ? 'checked' : '' }} value="1"> {{ $week_arr[$i] }}
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

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name" class="mt-2"> Store Image * <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                                <input type="file" name="storeImage" class="form-control is_required @error('storeImage') is-invalid @enderror" accept="image/png,image/jpeg">
                                                @error('storeImage')
                                                    <span class="invalid-feedback fw-bold" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="storeOpen"  {{ old('storeOpen') ? 'checked' : '' }}>
                                                        {{ __('Store Open') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label text-muted">
                                                        <input class="form-check-input" type="checkbox" name="self_delivery"  {{ old('self_delivery') ? 'checked' : '' }} value="1">
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