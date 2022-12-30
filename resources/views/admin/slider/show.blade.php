@extends('layouts.master') 
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                       Slider Details
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row">

                                <!-- <h5 class="fw-bolder">Basic Information</h5> -->

                                <div class="col-md-4 ">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Title</h6>
                                        <p class="mb-0">{{ ucfirst($data->title) ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Link</h6>
                                        <p class="mb-0">{{ $data->link ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">  
                                        <h6 class="fw-bolder">Status</h6>
                                        <p class="mb-0">{{ isset($data) && ($data->status == 1) ? 'Active' : 'In-Active'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Image</h6>

                                        @if(!empty($data->image))
                                            <div class="even mt-3">
                                                <div class="parc">
                                                    <span class="pip" data-title="{{$data->image}}">
                                                        <img src="{{ url(config('app.slider_image')).'/'.$data->image ?? '' }}" alt="" width="150" height="100">
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
