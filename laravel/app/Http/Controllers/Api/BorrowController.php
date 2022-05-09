<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Borrow\StoreRequest;
use App\Http\Requests\Borrow\UpdateRequest;
use App\Http\Resources\Borrow\BorrowCollection;
use App\Http\Resources\Borrow\BorrowResource;
use App\Http\Services\Borrow\BorrowService;
use App\Http\Services\Product\ProductService;
use App\Models\Borrow;
use App\Models\Product;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    protected $borrowService;
    protected $productService;

    public function __construct(BorrowService $borrow, ProductService $product)
    {
        $this->borrowService = $borrow;
        $this->productService = $product;
    }

    public function index()
    {
        $data = $this->borrowService->getAll();
        $items = new BorrowCollection(BorrowResource::collection($data));
        return response()->json($items);
    }

    public function edit($id)
    {
        $borrow = $this->borrowService->find($id);
        $item = new BorrowResource($borrow);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'user_code' => 'required',
            'product' => 'required',
            'quantity' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' =>  $validator->errors()
            ]);
        }

        $message = 'Kiểm tra lại tên sách';
        $valid = false;
        $product = Product::where('title', $request->post('product'))->first();
        if ($request->quantity == 0) {
            $message = 'Số lượng không hợp lệ';
            return response()->json([
                'VALID' => $valid,
                'TN' => $message,
            ]);
        }
        if ($product) {

            $qtyNew = $request->quantity;
            $borrow = $this->borrowService->find($id);
            $qtyOld = $borrow->quantity;
            $status = $request->status;
            $request['product_id'] = $product->id;
            if ($status != 'dang_muon') {
                $product->update([
                    'quantity' => $product->quantity + $qtyNew
                ]);
                $valid = $this->borrowService->update($request, $id);
            } else {
                $handleQty = $this->productService->handleBorrowBook($product, $qtyNew, $status, $qtyOld);
                if ($handleQty != true) {
                    $message = 'Kho không đủ số lượng sách yêu cầu';
                    return response()->json([
                        'VALID' => false,
                        'TN' => $message,
                    ]);
                }
                $valid = $this->borrowService->update($request, $id);
            }
            $message = 'Update Thành công';
        }
        return response()->json([
            'VALID' => $valid,
            'TN' => $message
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_code' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' =>  $validator->errors()
            ]);
        }
        $message = 'Đã có lỗi xảy ra!';
        $valid = false;
        $product = Product::where('title', $request->post('product'))->first();
        $qty = $request->quantity;
        if ($request->quantity == 0) {
            $message = 'Số lượng không hợp lệ';
            return response()->json([
                'VALID' => $valid,
                'TN' => $message,
            ]);
        }
        if ($product) {
            $handleQty = $this->productService->handleBorrowBook($product, $qty);
            if ($handleQty != true) {
                $message = 'Kho không đủ số lượng sách yêu cầu';
                return response()->json([
                    'VALID' => false,
                    'TN' => $message,
                ]);
            }
            $request['product_id'] = $product->id;
            $valid = $this->borrowService->insert($request);
            $message = 'Thêm mới thành công!';
        } else {
            $message = 'Kiểm tra lại tên sách';
            return response()->json([
                'VALID' => $valid,
                'TN' => $message
            ]);
        }

        return response()->json([
            'VALID' => $valid,
            'TN' => $message,
        ]);
    }

    public function destroy($id)
    {
        $validDestroy = $this->borrowService->destroy($id);
        return response()->json([
            'VALID' => $validDestroy
        ]);
    }

    public function borrow(Request $request)
    {
        $user = Student::where('user_id', $request->user_id)->first();
        $values = $request->post();
        if ($user) {
            $borrow =  Borrow::create([
                'user_code' => $user->student_code,
                'quantity' => $values['quantity'],
                'product_id' => $values['product_id'],
                'staff_id' => 0,
                'status' => 'dang_muon'
            ]);
            return response()->json([
                'VALID' => true,
                'TN' => 'Mượn thành công !'
            ]);
        }

        return response()->json([
            'VALID' => false,
            'TN' => 'Người dùng không phù hợp'
        ]);
    }
}
