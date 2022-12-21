@extends('layouts.master') 
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                       Product Details
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row">

                                <!-- <h5 class="fw-bolder">Basic Information</h5> -->

                                <div class="col-md-4 ">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Title</h6>
                                        <p class="mb-0">{{ ucfirst($data->name) ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Category</h6>
                                        <p class="mb-0">{{ isset($data) && isset($data->category->name) ? $data->category->name : '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">SKU</h6>
                                        <p class="mb-0">{{ $data->SKU ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Quantity</h6>
                                        <p class="mb-0">{{ $data->qty.' '.$data->qty_type ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Market Price</h6>
                                        <p class="mb-0">{{ number_format((float)$data->market_price, 2, '.', '') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Regular Price</h6>
                                        <p class="mb-0">{{ number_format((float)$data->regular_price, 2, '.', '') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">  
                                        <h6 class="fw-bolder">Status</h6>
                                        <p class="mb-0">{{ isset($data) && ($data->status == 1) ? 'Active' : 'In-Active'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="p-3 listViewclr">  
                                        <h6 class="fw-bolder">Content</h6>
                                        <p class="mb-0">{!! $data->content ?? '-' !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Image</h6>

                                        @if(!empty($data->image))
                                            <div class="even mt-3">
                                                <div class="parc">
                                                    <span class="pip" data-title="{{$data->image}}">
                                                        <img src="{{ url(config('app.product_image')).'/'.$data->image ?? '' }}" alt="" width="150" height="100">
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <p class="mb-0"> No Image Found </p>
                                        @endif
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
