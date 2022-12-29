<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryCollection;
use App\Http\Resources\Admin\CategoryResource;
use Illuminate\Http\Request;
use App\Helper\ResponseBuilder;
use App\Models\Category;
use App\Helper\Helper;
use Validator;
use Auth;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoriesList(Request $request)
    {
        try {
            $data = Category::where('status', 1)->get();
            if(count($data) > 0) {
                $this->response = new CategoryCollection($data);
                return ResponseBuilder::success(trans('global.all_categories'),$this->success,$this->response);
            }
            return ResponseBuilder::success(trans('global.no_categories'),$this->success,[]);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * Display a single Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($id)
    {
        try {
            $data = Category::where('id', $id)->where('status', 1)->first();

            if(empty($data)) {
                return ResponseBuilder::success(trans('global.no_category'),$this->success,[]);
            }

            $this->response = new CategoryResource($data);
            return ResponseBuilder::success(trans('global.category'),$this->success,$this->response);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }
}
