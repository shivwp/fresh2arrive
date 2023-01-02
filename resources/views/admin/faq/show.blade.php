@extends('layouts.master') 
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                       Faq Details
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row">

                                <!-- <h5 class="fw-bolder">Basic Information</h5> -->

                                <div class="col-md-12 ">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Question</h6>
                                        <p class="mb-0">{{ $data->question ?? '-'}}</p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="p-3 listViewclr">
                                        <h6 class="fw-bolder">Answer</h6>
                                        <p class="mb-0">{!! $data->answer ?? '-' !!}</p>
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
