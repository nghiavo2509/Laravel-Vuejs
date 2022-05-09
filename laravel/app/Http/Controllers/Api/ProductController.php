<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Services\Product\ProductService;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $product)
    {
        $this->productService = $product;
    }
    public function index()
    {
        $products = $this->productService->get();
        $items = new ProductCollection(ProductResource::collection($products));
        return response()->json($items);
    }

    public function get(Request $request)
    {
        if ($request->has('status')) {
            $products = $this->productService->get($request->status);
            $items = new ProductCollection(ProductResource::collection($products));
        }
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:lib_genres,title',
                'category_id' => 'required',
                'genre_id' => 'required',
                'quantity' => 'required',
                'status' => 'required',
            ],
            [
                'category_id.required' => 'The category field is required!',
                'genre_id.required' => 'The genre field is required!'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' =>  $validator->errors()
            ]);
        }
        $message = 'Thêm sản phẩm thành công';
        $validProduct = $this->productService->insert($request);
        return response()->json([
            'VALID' => $validProduct,
            'TN' => $message
        ]);
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        if ($product) {
            return response()->json([
                'product' => new ProductResource($product),
                'status' => 200
            ]);
        }
        return response()->json([
            'status' => 404
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:lib_products,title,' . $id,
                'category_id' => 'required',
                'genre_id' => 'required',
                'quantity' => 'required',
                'status' => 'required',
            ],
            [
                'category_id.required' => 'The category field is required!',
                'genre_id.required' => 'The genre field is required!'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' =>  $validator->errors()
            ]);
        }
        $message = 'Đã có lỗi xảy ra!';
        $valid = $this->productService->update($request, $id);
        if ($valid) {
            $message = 'Update Thành công!';
            return response()->json(
                [
                    'VALID' => $valid,
                    'TN' => $message,
                ]
            );
        }
        return response()->json(
            [
                'VALID' => $valid,
                'TN' => $message,
            ]
        );
    }

    public function destroy($id)
    {
        $message = 'Đã có lỗi xảy ra!';

        $valid = $this->productService->destroy($id);
        if ($valid) {
            $message = 'Xóa Thành công!';
            return response()->json(
                [
                    'VALID' => $valid,
                    'TN' => $message,
                ]
            );
        }
        return response()->json(
            [
                'VALID' => $valid,
                'TN' => $message,
            ]
        );
    }

    public function status($id)
    {
        $valid = $this->productService->status($id);
        return response()->json([
            'VALID' => $valid
        ]);
    }

    public function getProductByCategory($id)
    {
        $items = Product::where([
            'category_id' => $id,
            'status' => 1
        ])->get();
        return response()->json(['products' => $items]);
    }
}
