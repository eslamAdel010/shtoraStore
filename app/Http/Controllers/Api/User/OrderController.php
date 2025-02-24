<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\Order;
use App\Models\Api\Admin\OrderDetailes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // ✅ جلب جميع الطلبات
    public function index()
    {
        $orders = Order::paginate(20);

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'orders' => $orders,
        ], 200);
    }

    // ✅ إضافة طلب جديد
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'other_phone' => 'nullable|string|max:20',
            'adress' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'cart' => 'required|array', // التحقق من أن السلة ليست فارغة
            'cart.*.id' => 'required|exists:products,id', // التأكد من وجود المنتج
            'cart.*.quantity' => 'required|integer|min:1', // التأكد من أن الكمية صحيحة
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }
    
        // 1️⃣ إنشاء الطلب في جدول "orders"
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'other_phone' => $request->other_phone,
            'adress' => $request->adress,
            'status' => 'processing',
            'note' => $request->note,
        ]);
    
        // 2️⃣ إدخال تفاصيل المنتجات في جدول "order_details"
        foreach ($request->cart as $cartItem) {
            OrderDetailes::create([
                'order_id' => $order->id,
                'product_id' => $cartItem['id'],
                'quantity' => $cartItem['quantity'],
                'total' => $cartItem['quantity'] * $cartItem['price'],
                'state' => 'pending',
            ]);
        }
    
        return response()->json([
            'status' => 201,
            'message' => 'تم إنشاء الطلب وإضافة تفاصيل المنتجات بنجاح!',
            'order' => $order,
        ], 201);
    }
    
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'order' => $order,
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Order deleted successfully',
        ], 200);
    }
};