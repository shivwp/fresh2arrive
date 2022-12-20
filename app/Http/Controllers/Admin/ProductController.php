<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Helper\Helper;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Product::query();

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

        $d['data'] = $q->orderBy('created_at','DESC')->with('Category')->paginate($d['items']);
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');

        return view('admin.product.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');
        $d['units'] = Helper::Units();
        return view('admin.product.create',$d);
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
                'title' => 'required | string | unique:products,name,'.$request->id,
                'category' => 'required',
                'SKU' => 'required | unique:products,SKU,'.$request->id,
                'qty' => 'required | numeric',
                'qty_type' => 'required',
                'price' => 'required | numeric',
                'status' => 'required',
            ] + (!empty($request->id) ? ['image' => 'mimes:jpeg,png,jpg'] : ['image' => 'required | mimes:jpeg,png,jpg'])
        );

        $imagePath = config('app.product_image');

        $pages = Product::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->title,
                'category_id' => $request->category,
                'SKU' => $request->SKU,
                'qty' => $request->qty,
                'qty_type' => $request->qty_type,
                'price' => $request->price,
                'image' => $request->hasfile('image') ? Helper::storeImage($request->file('image'),$imagePath,$request->imageOld) : (isset($request->imageOld) ? $request->imageOld : ''),
                'status' => $request->status,
            ]
        );

        $result = $pages->update();

        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.products.index')->with('success','Product Updated successfully');
            }
            else
            {
                return redirect()->route('admin.products.index')->with('success','Product Created successfully');
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
        $data['data'] = Product::where('id',$id)->with('Category')->first();

        return view('admin.product.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d['categories'] = Category::where('status', '=', 1)->pluck('name', 'id');
        $d['units'] = Helper::Units();
        $d['data'] = Product::where('id', $id)->first();
        return view('admin.product.create',$d);
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
            $data= Product::where('id',$id)->first();
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
            $data= Product::where('id',$id)->first();
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
}
