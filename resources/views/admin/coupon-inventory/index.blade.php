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
                <div class="row tabelhed d-flex justify-content-between">
                    <div class="col-lg-2 col-md-2 col-sm-2 d-flex">
                            <!-- <a class="ad-btn btn text-center" href="{{ route('admin.coupons.create') }}"> Add</a> -->
                    </div>

                    <div class="col-lg-10 col-md-10"> 

                        <div class="right-item d-flex justify-content-end" >

                            <!-- <div class="p-0 mx-1"> -->
                            <!-- <form action="" method="GET" class="mx-1">
                                <select class="form-control" id="status" name="status">
                                    <option value="">Select Status</option>
                                    <option value="active" {{ isset($status) ? ($status == "active" ? 'selected' : '' ) : '' }} >Active</option>
                                    <option value="in-active" {{ isset($status) ? ($status == "in-active" ? 'selected' : '' ) : '' }} >In-Active</option>
                                </select>

                                @if(isset($_GET['category']))<input type="hidden" name="category" value="{{$_GET['category']}}">@endif
                                @if(isset($_GET['keyword']))<input type="hidden" name="keyword" value="{{$_GET['keyword']}}">@endif
                                @if(isset($_GET['items']))<input type="hidden" name="items" value="{{$_GET['items']}}">@endif
                            </form> -->
                            <!-- </div> -->

                            <form action="" method="GET" class="d-flex">
                                <!-- <select class="form-control mx-1" id="status" name="status">
                                    <option value="">Select Status</option>
                                    <option value="active" {{ isset($status) ? ($status == "active" ? 'selected' : '' ) : '' }} >Active</option>
                                    <option value="in-active" {{ isset($status) ? ($status == "in-active" ? 'selected' : '' ) : '' }} >In-Active</option>
                                </select> -->

                                <input type="text" name="keyword" id="keyword" class="form-control" value="{{ isset($keyword) ? $keyword : '' }}" placeholder="Search" required>

                                <button class="btn-sm search-btn keyword-btn" type="submit">
                                    <i class="ti-search pl-3" aria-hidden="true"></i>
                                </button>

                                <a href="{{ route('admin.coupon-inventories.index') }}" class="btn-sm reload-btn">
                                    <i class="ti-reload pl-3 redirect-icon" aria-hidden="true"></i>
                                </a>

                                <!-- @if(isset($_GET['category']))<input type="hidden" name="category" value="{{$_GET['category']}}">@endif
                                @if(isset($_GET['status']))<input type="hidden" name="status" value="{{$_GET['status']}}">@endif
                                @if(isset($_GET['items']))<input type="hidden" name="items" value="{{$_GET['items']}}">@endif -->
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 mt-auto">
                                <h5>Coupon Inventory</h5>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="row float-end">
                                    <div class="col-xl-12 d-flex float-end">
                                        <div class="items paginatee">
                                            <form action="" method="GET">
                                                <select class="form-select m-0 items" name="items" id="items" aria-label="Default select example">
                                                    <option value='10' {{ isset($items) ? ($items == '10' ? 'selected' : '' ) : '' }}>10</option>
                                                    <option value='20' {{ isset($items) ? ($items == '20' ? 'selected' : '' ) : '' }}>20</option>
                                                    <option value='30' {{ isset($items) ? ($items == '30' ? 'selected' : '' ) : '' }}>30</option>
                                                    <option value='40' {{ isset($items) ? ($items == '40' ? 'selected' : '' ) : '' }}>40</option>
                                                    <option value='50' {{ isset($items) ? ($items == '50' ? 'selected' : '' ) : '' }}>50</option>
                                                </select>

                                                @if(isset($_GET['category']))<input type="hidden" name="category" value="{{$_GET['category']}}">@endif
                                                @if(isset($_GET['status']))<input type="hidden" name="status" value="{{$_GET['status']}}">@endif
                                                @if(isset($_GET['keyword']))<input type="hidden" name="keyword" value="{{$_GET['keyword']}}">@endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table">
                            <table id="example" class="table table-striped table-bordered no-action">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Name</th>
                                        <th>Coupon</th>
                                        <th>Discount Type</th>
                                        <th>Toral Price</th>
                                        <th>Discount Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                @if(count($data)>0)
                                    @php 
                                        isset($_GET['items']) ? $items = $_GET['items'] : $items = 10;
                                        isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;

                                        $i = (($page-1)*$items)+1; 
                                    @endphp

                                    @foreach($data as $key => $value)
                                        <tr data-entry-id="{{ $value->id }}">
                                            <td>{{ $i++ ?? ''}}</td>
                                            <td>{{ $value->user->name ?? '' }}</td>
                                            <td>{{ $value->coupon_code ?? '' }}</td>
                                            <td>{{ isset($value->discount_type) ? ($value->discount_type == 'F' ? 'Fixed' : 'Percentage') : '' }}</td>
                                            <td>{{ $value->total_price ?? '' }}</td>
                                            <td>{{ $value->discounted_price ?? '' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.coupons.show', $value->id) }}" class="btn btn-sm btn-icon p-2">
                                                    <i class="mdi mdi-eye mx-1" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" title="View"></i>
                                                </a>
            
                                                <!-- <a href="{{ route('admin.coupons.edit', $value->id) }}" class="btn btn-sm btn-icon p-2">
                                                    <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" title="Edit"></i>
                                                </a>

                                                <button type="submit" class="btn btn-sm btn-icon p-2 delete-record" route="{{ route('admin.coupons.destroy', $value->id) }}"><i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Delete"></i></button>  -->

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="7">No Data Found</td></tr>
                                @endif
                            </table>
                            @if ((request()->get('keyword')) || (request()->get('status')) || (request()->get('category')) || (request()->get('items')))
                                {{ $data->appends(['keyword' => request()->get('keyword'),'status' => request()->get('status'),'category' => request()->get('category'),'items' => request()->get('items')])->links() }}
                            @else
                                {{ $data->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection