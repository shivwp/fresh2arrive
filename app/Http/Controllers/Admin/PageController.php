<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Page::query();

        if($request->keyword){
            $d['keyword'] = $request->keyword;

            $q->where('title', 'like', '%'.$d['keyword'].'%')->orwhere('slug', 'like', '%'.$d['keyword'].'%');
        }

        if($request->items){
            $d['items'] = $request->items;
        }
        else{
            $d['items'] = 10;
        }

        $d['data'] = $q->orderBy('created_at','DESC')->paginate($d['items']);

        return view('admin.page.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | string',
            'content' => 'required | string',
        ]);

        if(empty($request->slug)){
            $request['slug'] = Str::slug($request->title);
            $request['new_slug'] = $request['slug'];

            $count=1;
            while(Page::where('slug', '=', $request['new_slug'])->exists())
                {
                    $request['new_slug'] = $request['slug'].'-'.$count;
                    $count++;
                }
        }
        else
        {
            $request['new_slug'] = $request->slug;
        }

        $pages = Page::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'title' => $request->title,
                'slug' => $request['new_slug'],
                'content' => $request->content,
            ]
        );

        $result = $pages->update();

        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.pages.index')->with('success','Page Updated successfully');
            }
            else
            {
                return redirect()->route('admin.pages.index')->with('success','Page Created successfully');
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
    public function edit($id)
    {
        $d['data'] = Page::where('id', $id)->first();
        return view('admin.page.create',$d);
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
            $data= Page::where('id',$id)->delete();
            if($data) {
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
}
