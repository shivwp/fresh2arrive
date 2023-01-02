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
                        {{ isset($data) && isset($data->id) ? 'Edit Vendor Product' : 'Create Vendor Product' }}
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.vendor-products.store') }}" method="POST" enctype="multipart/form-data" id="basic-form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ isset($data) ? $data->id : '' }}">
                            <input type="hidden" name="vendor_product_id" value="{{ isset($data) ? $data->id : '' }}">
                            <!-- <input type="hidden" name="slug" id="slug" value="{{ isset($data) ? $data->slug : '' }}"> -->
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Vendors <span class="text-danger">*</span></label>
                                    <select name="vendor" class="form-control form-select @error('vendor') is-invalid @enderror" required>
                                        <option value="" {{ old('vendor') ? ((old('vendor') == '') ? 'selected' : '' ) : ( (isset($data) && $data->vendor_id == 0) ? 'selected' : '' ) }} >Select vendor</option>
                                        @foreach($vendors as $key => $value) 
                                            <option value={{$key}} {{ old('vendor') ? ((old('vendor') == $key) ? 'selected' : '' ) : ( (isset($data) && $data->vendor_id == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="mt-2"> Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control form-select @error('category') is-invalid @enderror category" required>
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
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="hidden" name="product_id" id="product_id" value="{{ isset($data) ? $data->product_id : '' }}">
                                    <label class="mt-2"> Products <span class="text-danger">*</span></label>
                                    <select name="product" class="form-control form-select @error('product') is-invalid @enderror products" required>
                                        <option value="" {{ old('product') ? ((old('product') == '') ? 'selected' : '' ) : ( (isset($data) && $data->product_id == 0) ? 'selected' : '' ) }} >Select Product</option>
                                        
                                    </select>
                                    @error('product')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="mt-2"> SKU </label>
                                    <input type="text" name="SKU" class="form-control @error('SKU') is-invalid @enderror SKU" placeholder="SKU" value="{{ old('SKU', isset($data) && isset($data->product->SKU) ? $data->product->SKU : '') }}" disabled>
                                    @error('SKU')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @php $count=0; @endphp
                            @if(isset($data->variants) && (count($data->variants)>0))
                            @foreach($data->variants as $variant)
                            <div class="variants " id="variants">
                                <div class="row">
                                    <input type="hidden" name="vendor_product_variant_id[]" value="{{ $variant->id }}">
                                    <input type="hidden" name="variants_count" id="variants_count" value="{{isset($data->variants) && (count($data->variants)>0) ? count($data->variants) : ''}}">
                            
                                    <div class="form-group col-md-2">
                                        <label for="name" class="mt-2"> Quantity <span class="text-danger">*</span></label>
                                        
                                        <input type="number" name="variants[{{$count}}][variant_qty]" class="form-control @error('variant_qty') is-invalid @enderror variant_qty" placeholder="Quantity" value="{{ old('variant_qty', isset($variant) && isset($variant->variant_qty) ? $variant->variant_qty : '') }}" required min="0">
                                        @error('variant_qty')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label class="mt-2"> Quantity Type <span class="text-danger">*</span></label>
                                        <select name="variants[{{$count}}][variant_qty_type]" class="form-control form-select @error('variant_qty_type') is-invalid @enderror variant_qty_type" required>
                                            <option value="" {{ old('variant_qty_type') ? ((old('variant_qty_type') == '') ? 'selected' : '' ) : ( (isset($variant) && $variant->variant_qty_type == 0) ? 'selected' : '' ) }} >Select Quantity Type</option>
                                            @foreach($units as $key => $value) 
                                                <option value={{$key}} {{ old('variant_qty_type') ? ((old('variant_qty_type') == $key) ? 'selected' : '' ) : ( (isset($variant) && $variant->variant_qty_type == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('variant_qty_type')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="mt-2"> Market Price <span class="text-danger">*</span></label>
                                        <input type="number" name="variants[{{$count}}][market_price]" class="form-control @error('market_price') is-invalid @enderror market_price" placeholder="Market Price" value="{{ old('market_price', isset($variant) && isset($variant->market_price) ? $variant->market_price : '') }}" required min="0" max="9999.99" step="0.01">
                                        @error('market_price')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="mt-2"> Regular Price <span class="text-danger">*</span></label>
                                        <input type="number" name="variants[{{$count}}][price]" class="form-control @error('price') is-invalid @enderror price" placeholder="Regular Price" value="{{ old('price', isset($variant) && isset($variant->price) ? $variant->price : '') }}" required min="0" max="9999.99" step="0.01">
                                        @error('price')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-1 mt-auto mb-auto">
                                        <a class="mt-3 remove_variant_btn" id="remove_variant_btn">
                                            <i class="mdi mdi-delete mx-1" data-bs-html="true" title="Remove"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php $count++; @endphp
                            @endforeach
                            @else
                            <input type="hidden" name="variants_count" id="variants_count" value="1">
                            <div class="variants " id="variants">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="name" class="mt-2"> Quantity <span class="text-danger">*</span></label>
                                        
                                        <input type="number" name="variants[{{$count}}][variant_qty]" class="form-control @error('variant_qty') is-invalid @enderror variant_qty" placeholder="Quantity" value="{{ old('variant_qty', isset($variant) && isset($variant->variant_qty) ? $variant->variant_qty : '') }}" required min="0">
                                        @error('variant_qty')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label class="mt-2"> Quantity Type <span class="text-danger">*</span></label>
                                        <select name="variants[{{$count}}][variant_qty_type]" class="form-control form-select @error('variant_qty_type') is-invalid @enderror variant_qty_type" required>
                                            <option value="" {{ old('variant_qty_type') ? ((old('variant_qty_type') == '') ? 'selected' : '' ) : ( (isset($variant) && $variant->variant_qty_type == 0) ? 'selected' : '' ) }} >Select Quantity Type</option>
                                            @foreach($units as $key => $value) 
                                                <option value={{$key}} {{ old('variant_qty_type') ? ((old('variant_qty_type') == $key) ? 'selected' : '' ) : ( (isset($variant) && $variant->variant_qty_type == $key) ? 'selected' : '' ) }} >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('variant_qty_type')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="mt-2"> Market Price <span class="text-danger">*</span></label>
                                        <input type="number" name="variants[{{$count}}][market_price]" class="form-control @error('market_price') is-invalid @enderror market_price" placeholder="Market Price" value="{{ old('market_price', isset($variant) && isset($variant->market_price) ? $variant->market_price : '') }}" required min="0" max="9999.99" step="0.01">
                                        @error('market_price')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="mt-2"> Regular Price <span class="text-danger">*</span></label>
                                        <input type="number" name="variants[{{$count}}][price]" class="form-control @error('price') is-invalid @enderror price" placeholder="Regular Price" value="{{ old('price', isset($variant) && isset($variant->price) ? $variant->price : '') }}" required min="0" max="9999.99" step="0.01">
                                        @error('price')
                                            <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-1 mt-auto mb-auto">
                                        <a class="mt-3 remove_variant_btn" id="remove_variant_btn">
                                            <i class="mdi mdi-delete mx-1" data-bs-html="true" title="Remove"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="new_variants" id="new_variants"></div>
                            <div class="col-md-1 mb-4">
                                <div class="add_image" id="add_image">
                                    <a class="btn btn-sm btn-primary add_variant_btn ad-btn" id="add_variant_btn">
                                        <i class="mdi mdi-plus mx-1" data-bs-html="true" title="Add"></i>
                                    </a>
                                </div>
                            </div>
                        

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="mt-3 img-div {{ !empty($data->image) ? 'show-img' : 'hide-img' }}">
                                        <span class="pip" data-title="{{isset($data->image)}}">
                                            <img src="{{ isset($data->image) ? url(config('app.vendor_product_image')).'/'.$data->image : '' }}" class="image" alt="" width="150" height="100">
                                        </span>
                                    </div>
                                    <label for="name" class="mt-2"> Image <span class="text-danger info">(Only jpeg, png, jpg files allowed)</span></label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png">
                                    <input type="hidden" class="form-control imageOld" name="imageOld" value="{{ isset($data) ? $data->image : ''}}">
                                    @error('image')
                                        <span class="invalid-feedback form-invalid fw-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mt-auto">
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

@section('scripts')
<script>

function getProducts(category_id, selected_product = null) {
    var route = "{{ url('admin/vendor-products/products') }}/"+category_id+'?selected_product='+selected_product;

    $.ajax({
        method: 'GET',
        url: route,
        success: function(response){
            if(response.success == true) {
                return $('.products').html(response.output);
            }
        },
    });
}

function getProductDetail(product_id) {
    var route = "{{ url('admin/vendor-products/products-details') }}/"+product_id;

    $.ajax({
        method: 'GET',
        url: route,
        success: function(response){
            if(response.success == true) {
                $('.SKU').val(response.output.SKU);
                $('.variant_qty').val(response.output.qty);
                $('.variant_qty_type').val(response.output.qty_type);
                $('.market_price').val(response.output.market_price);
                $('.price').val(response.output.regular_price);
                $('.image').attr('src',response.output.full_image_path);
                $('.imageOld').val(response.output.image);
                $('.img-div').removeClass('hide-img').addClass('show-img');
            }
            else if(response.success == false) {
                console.log('Error');
            }
        },
    });
}
$(document).ready(function(){

    var category_id = $('.category').val();
    var selected_product = $("#product_id").val();
    getProducts(category_id,selected_product); 

    $(document).on('change', '.category', function(){
        var category_id = $(this).val();

        if(category_id == '') {
            category_id = 0;
        }
        getProducts(category_id); 
    });

    $(document).on('change', '.products', function(){
        var product_id = $(this).val();
        getProductDetail(product_id);
    });

    variants_count = document.getElementById('variants_count').value;
    // var variants_count = 1;
    $('#add_variant_btn').click(function(){
        
        data = '<div class="variants " id="variants">'
                + ' <div class="row">'
                    + ' <div class="form-group col-md-2">'
                        + ' <label for="name" class="mt-2"> Quantity <span class="text-danger">*</span></label>'
                        + ' <input type="number" name="variants['+variants_count+'][variant_qty]" class="form-control @error('variant_qty') is-invalid @enderror variant_qty" placeholder="Quantity" value="{{ old('variant_qty', isset($data) && isset($data->variant_qty) ? $data->variant_qty : '') }}" required min="0">'
                        + ' @error('variant_qty')'
                            + ' <span class="invalid-feedback form-invalid fw-bold" role="alert">'
                                + ' {{ $message }}'
                            + ' </span>'
                        + ' @enderror'
                    + ' </div>'
                    
                    + ' <div class="form-group col-md-3">'
                        + ' <label class="mt-2"> Quantity Type <span class="text-danger">*</span></label>'
                        + ' <select name="variants['+variants_count+'][variant_qty_type]" class="form-control form-select @error('variant_qty_type') is-invalid @enderror variant_qty_type" required>'
                            + ' <option value="" {{ old('variant_qty_type') ? ((old('variant_qty_type') == '') ? 'selected' : '' ) : ( (isset($data) && $data->variant_qty_type == 0) ? 'selected' : '' ) }} >Select Quantity Type</option>'
                            + ' @foreach($units as $key => $value) '
                                + ' <option value={{$key}} {{ old('variant_qty_type') ? ((old('variant_qty_type') == $key) ? 'selected' : '' ) : ( (isset($data) && $data->variant_qty_type == $key) ? 'selected' : '' ) }} >{{ $value }}</option>'
                            + ' @endforeach'
                        + ' </select>'
                        + ' @error('variant_qty_type')'
                            + ' <span class="invalid-feedback form-invalid fw-bold" role="alert">'
                                + ' {{ $message }}'
                            + ' </span>'
                        + ' @enderror'
                    + ' </div>'

                    + ' <div class="form-group col-md-3">'
                        + ' <label for="name" class="mt-2"> Market Price <span class="text-danger">*</span></label>'
                        + ' <input type="number" name="variants['+variants_count+'][market_price]" class="form-control @error('market_price') is-invalid @enderror market_price" placeholder="Market Price" value="{{ old('market_price', isset($data) && isset($data->market_price) ? $data->market_price : '') }}" required min="0" max="9999.99" step="0.01">'
                        + ' @error('market_price')'
                            + ' <span class="invalid-feedback form-invalid fw-bold" role="alert">'
                                + ' {{ $message }}'
                            + ' </span>'
                        + ' @enderror'
                    + ' </div>'

                    + ' <div class="form-group col-md-3">'
                        + ' <label for="name" class="mt-2"> Regular Price <span class="text-danger">*</span></label>'
                        + ' <input type="number" name="variants['+variants_count+'][price]" class="form-control @error('price') is-invalid @enderror price" placeholder="Regular Price" value="{{ old('price', isset($data) && isset($data->price) ? $data->price : '') }}" required min="0" max="9999.99" step="0.01">'
                        + ' @error('price')'
                            + ' <span class="invalid-feedback form-invalid fw-bold" role="alert">'
                                + ' {{ $message }}'
                            + ' </span>'
                        + ' @enderror'
                    + ' </div>'

                    + ' <div class="col-md-1 mt-auto mb-auto">'
                        + ' <a class="mt-3 remove_variant_btn" id="remove_variant_btn">'
                            + ' <i class="mdi mdi-delete mx-1" data-bs-html="true" title="Remove"></i>'
                        + ' </a>'
                    + ' </div>'
                + ' </div>'
            + ' </div>';

        $('#new_variants').append(data);
        document.getElementById('remove_variant_btn').style.removeProperty('display');
        variants_count++;

    });
    

    $("body").on("click", "#remove_variant_btn", function () {
        variants_count--;

        $(this).parents("#variants").remove();
        // document.getElementById('add_variant_btn').style.removeProperty('display');

        if(variants_count == 1)
        {
            $('#remove_variant_btn').first().css('display', 'none');
        }
        else
        {
            document.getElementById('remove_variant_btn').style.removeProperty('display');
        }

    });

    if(variants_count>1)
    {
        document.getElementById('remove_variant_btn').style.removeProperty('display');
    }
    else
    {
        $('#remove_variant_btn').first().css('display', 'none');
    }
});
</script>
@endsection