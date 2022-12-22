<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\VendorProductVariant;
use App\Helper\Helper;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = VendorProduct::query();

        if($request->keyword){
            $d['keyword'] = $request->keyword;

            $q->where('name', 'like', '%'.$d['keyword'].'%');
        }

        if($request->status){
            $d['status'] = $request->status;

            if($request->status == 'active'){
                $q->where('status', '=', 1);
            }
            else {
                $q->where('status', '=', 0);
            }
        }

        if($request->category){
            $d['category'] = $request->category;

            $q->where('category_id', '=', $d['category']);
        }

        if($request->items){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->with('vendor','category','product')->paginate($d['items']);
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('admin.vendor-product.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d['vendors'] = User::where('is_vendor', '=', 1)->pluck('name', 'id');
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');
        $d['units'] = Helper::Units();
        return view('admin.vendor-product.create',$d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'vendor' => 'required',
                'category' => 'required',
                'product' => 'required',
                'status' => 'required',
                'image' => 'mimes:jpeg,png,jpg',
            ]
        );

        $imagePath = config('app.vendor_product_image');

        $data = VendorProduct::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'vendor_id' => $request->vendor,
                'category_id' => $request->category,
                'product_id' => $request->product,
                'image' => $request->hasfile('image') ? Helper::storeImage($request->file('image'),$imagePath,$request->imageOld) : (isset($request->imageOld) ? $request->imageOld : ''),
                'status' => $request->status,
            ]
        );

        $result = $data->update();

        $i = 0;
        foreach($request->variants as $variant) {

            $variants_data[] = $variant 
            + (!empty($request->id) ? ['vendor_product_id' => $request->id] : ['vendor_product_id' => $data->id])
            + (!empty($request->vendor_id) ? ['id' => $request->vendor_id[$i++]] : []);;
        }

        VendorProductVariant::upsert($variants_data, ['id'],['vendor_product_id','market_price','variant_qty','variant_qty_type','price']);
        
        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.vendor-products.index')->with('success','Product Updated successfully');
            }
            else
            {
                return redirect()->route('admin.vendor-products.index')->with('success','Product Created successfully');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Something went Wrong, Please try again!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $d['vendors'] = User::where('is_vendor', '=', 1)->pluck('name', 'id');
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');
        $d['units'] = Helper::Units();
        $d['data'] = VendorProduct::where('id', $id)->with('product','variants')->first();
        return view('admin.vendor-product.create',$d);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data= VendorProduct::where('id',$id)->first();
            $result = $data->delete();
            if($result) {
                // $imagePath = config('app.product_image');
                // if(isset($data->image)) {
                //     Helper::removeImage($imagePath,$data->image);
                // }
                return response()->json(["success" => true]);
            }
            else {
                return response()->json(["success" => false]);
            }
        }  catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message'  => "Something went wrong, please try again!",
                'error_msg' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Change the specified resource status from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id, Request $request)
    {
        try {
            $data= VendorProduct::where('id',$id)->first();

            if($data) {
                $data->status = $data->status == 1 ? 0 : 1;
                $data->save();
                return response()->json(["success" => true, "status"=> $data->status]);
            }
            else {
                return response()->json(["success" => false]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'  => "Something went wrong, please try again!",
                'error_msg' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get Products resource from storage based on category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductsByCategory($id,Request $request)
    {
        // return $request->selected_product;
        $products = Product::getProductsByCategoryId($id);

        $output= "<option value=''>Select Product</option>";
        if(count($products)>0){
            foreach($products as $item){
                $select = (isset($request->selected_product) && ($request->selected_product == $item['id'])) ? 'selected' : '';
                $output .= '<option value="'.$item['id'].'" '.$select.'>'.$item['name'].'</option>';
            }
        }
        return response()->json(['success' => true, 'output' => $output]);
    }

    /**
     * Get Products resource from storage based on id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductsById($id)
    {        
        $product = Product::getProductDetailsByID($id);
        $product->full_image_path = url(config('app.product_image')).'/'.$product->image;

        if($product){
            return response()->json(['success' => true, 'output' => $product]);
        }
        return response()->json(['success' => false]);
    }
}
