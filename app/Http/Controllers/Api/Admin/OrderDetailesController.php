<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\OrderDetailes;
use Illuminate\Http\Request;

class OrderDetailesController extends Controller
{
     // جلب جميع تفاصيل الطلبات
     public function index()
     {
         $orderDetails = OrderDetailes::with([ 'product',  'order'])->get();
         return response()->json($orderDetails);
     }
 
   
     // عرض تفاصيل طلب معين
     public function show($id)
     {
         $orderDetail = OrderDetailes::with(['user', 'product', 'size', 'order'])->findOrFail($id);
         return response()->json($orderDetail);
     }
 
     // تحديث تفاصيل الطلب
     public function update(Request $request, $id)
     {
         $orderDetail = OrderDetailes::findOrFail($id);
 
         $request->validate([
             'state' => 'sometimes|string',
             'user_id' => 'sometimes|exists:users,id',
             'product_id' => 'sometimes|exists:products,id',
             'size_id' => 'sometimes|exists:sizes,id',
             'order_id' => 'sometimes|exists:orders,id',
             'total' => 'sometimes|numeric',
         ]);
 
         $orderDetail->update($request->all());
         return response()->json($orderDetail);
     }
 
     // حذف تفاصيل الطلب
     public function destroy($id)
     {
         $orderDetail = OrderDetailes::findOrFail($id);
         $orderDetail->delete();
         return response()->json(['message' => 'Order Detail deleted successfully']);
     }
}
