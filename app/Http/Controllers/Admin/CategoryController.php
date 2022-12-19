<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Helper\Helper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Category::query();

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

        if($request->items){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->paginate($d['items']);

        return view('admin.category.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d['tax'] = Setting::where('key', 'default_tax')->first();
        return view('admin.category.create',$d);
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
                'title' => 'required | string | unique:categories,name,'.$request->id,
                'tax_percent' => 'required | integer',
                'status' => 'required',
            ] + (!empty($request->id) ? ['image' => 'mimes:jpeg,png,jpg'] : ['image' => 'required | mimes:jpeg,png,jpg'])
        );
        
        if(empty($request->slug)){
            $request['slug'] = Str::slug($request->title);
            $request['new_slug'] = $request['slug'];

            $count=1;
            while(Category::where('slug', '=', $request['new_slug'])->exists())
                {
                    $request['new_slug'] = $request['slug'].'-'.$count;
                    $count++;
                }
        }
        else
        {
            $request['new_slug'] = $request->slug;
        }

        $imagePath = config('app.category_image');

        $pages = Category::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->title,
                'slug' => $request['new_slug'],
                'image' => $request->hasfile('image') ? Helper::storeImage($request->file('image'),$imagePath,$request->imageOld) : (isset($request->imageOld) ? $request->imageOld : ''),
                'tax_percent' => $request->tax_percent,
                'status' => $request->status,
            ]
        );

        $result = $pages->update();

        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.categories.index')->with('success','Category Updated successfully');
            }
            else
            {
                return redirect()->route('admin.categories.index')->with('success','Category Created successfully');
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
        $data['data'] = Category::where('id',$id)->first();

        return view('admin.category.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d['data'] = Category::where('id', $id)->first();
        return view('admin.category.create',$d);
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
            $data= Category::where('id',$id)->first();
            $result = $data->delete();
            if($result) {
                $imagePath = config('app.category_image');
                if(isset($data->image)) {
                    Helper::removeImage($imagePath,$data->image);
                }
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
            $data= Category::where('id',$id)->first();
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
