<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = EmailTemplate::query();

        if($request->keyword){
            $d['keyword'] = $request->keyword;

            $q->where(function ($query) use ($d) {
                $query->where('title', 'like', '%'.$d['keyword'].'%')
                ->orwhere('email_key', 'like', '%'.$d['keyword'].'%')
                ->orwhere('email_subject', 'like', '%'.$d['keyword'].'%');
            });
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

        return view('admin.email-template.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.email-template.create');
        
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
            'email_key' => 'required',
            'email_subject' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        $data = EmailTemplate::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'question' => $request->question,
                'answer' => $request->answer,
                'title' => $request->title,
                'email_key' => $request->email_key,
                'email_subject' => $request->email_subject,
                'email_content' => $request->content,
                'status' => $request->status,
            ]
        );

        $result = $data->update();

        if($result)
        {
            if($request->id)
            {
                return redirect()->route('admin.email-templates.index')->with('success','Email Template Updated successfully');
            }
            else
            {
                return redirect()->route('admin.email-templates.index')->with('success','Email Template Created successfully');
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
        $data['data'] = EmailTemplate::where('id',$id)->first();

        return view('admin.email-template.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d['data'] = EmailTemplate::where('id', $id)->first();
        return view('admin.email-template.create',$d);
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
            $data= EmailTemplate::where('id',$id)->first();
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
            $data= EmailTemplate::where('id',$id)->first();
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
