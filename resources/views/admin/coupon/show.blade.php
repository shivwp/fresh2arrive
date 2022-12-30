@extends('layouts.master') 
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                       Category Details
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row">

                                <!-- <h5 class="fw-bolder">Basic Information</h5> -->

                                <div class="col-md-4 ">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Vendor Name</h6>
                                        <p class="mb-0">
                                            @foreach($vendor_name as $vendor)
                                                {{ ucfirst($vendor->name).',' ?? '-'}}
                                            @endforeach
                                        </p>
                                        <!-- <p class="mb-0">{{ ucfirst($data->vendor->name) ?? '-'}}</p> -->
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Coupon Code</h6>
                                        <p class="mb-0">{{ $data->coupon_code ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Valid From</h6>
                                        <p class="mb-0">{{ date('d-M-Y', strtotime($data->valid_from)) ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Valid Upto</h6>
                                        <p class="mb-0">{{ date('d-M-Y', strtotime($data->valid_to)) ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Discount Type</h6>
                                        <p class="mb-0">{{ isset($data->discount_type) ? ($data->discount_type == 'F' ? 'Fixed' : 'Percentage') : '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Discount</h6>
                                        <p class="mb-0">{{ $data->amount ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Maximim Reedem <span class="info">(Single User)</span></h6>
                                        <p class="mb-0">{{ $data->max_reedem ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Maximum no. of User</h6>
                                        <p class="mb-0">{{ $data->max_user ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Maximum Discount</h6>
                                        <p class="mb-0">{{ $data->max_discount ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Minimum Order Value</h6>
                                        <p class="mb-0">{{ $data->min_order_value ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Coupon Detail</h6>
                                        <p class="mb-0">{!! !empty($data->coupon_details) ? $data->coupon_details : '-' !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">  
                                        <h6 class="fw-bolder">Status</h6>
                                        <p class="mb-0">{{ isset($data) && ($data->status == 1) ? 'Active' : 'In-Active'}}</p>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-danger btn_back" href="{{ url()->previous() }}">
                                {{ 'Back to list' }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
