<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductCollection;
use App\Http\Resources\Admin\ProductResource;
use Illuminate\Http\Request;
use App\Helper\ResponseBuilder;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function allProductsList(Request $request)
    {
        try {
            $data = Product::where('status', 1)->get();
            if(count($data) > 0) {
                $this->response = new ProductCollection($data);
                return ResponseBuilder::success(trans('global.all_products'),$this->success,$this->response);
            }
            return ResponseBuilder::success(trans('global.no_products'),$this->success,[]);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }

    /**
     * Display a single Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($id)
    {
        try {
            $data = Product::where('id', $id)->where('status', 1)->first();

            if(empty($data)) {
                return ResponseBuilder::success(trans('global.no_product'),$this->success,[]);
            }

            $this->response = new ProductResource($data);
            return ResponseBuilder::success(trans('global.product'),$this->success,$this->response);

        } catch (\Exception $e) {
            return ResponseBuilder::error($e->getMessage(),$this->badRequest);
        }
    }
}
