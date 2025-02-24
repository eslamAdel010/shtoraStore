<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\ReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturnController extends Controller
{
    public function index()
    {
        $returnItems = ReturnItem::with('order')->get();

        if ($returnItems->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No return items found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'return_items' => $returnItems,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $returnItem = ReturnItem::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Return item created successfully',
            'return_item' => $returnItem,
        ], 201);
    }

    public function show($id)
    {
        $returnItem = ReturnItem::with('order')->find($id);

        if (!$returnItem) {
            return response()->json([
                'status' => 404,
                'message' => 'Return item not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'return_item' => $returnItem,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $returnItem = ReturnItem::find($id);

        if (!$returnItem) {
            return response()->json([
                'status' => 404,
                'message' => 'Return item not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'sometimes|exists:orders,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $returnItem->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Return item updated successfully',
            'return_item' => $returnItem,
        ], 200);
    }

    public function destroy($id)
    {
        $returnItem = ReturnItem::find($id);

        if (!$returnItem) {
            return response()->json([
                'status' => 404,
                'message' => 'Return item not found',
            ], 404);
        }

        $returnItem->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Return item deleted successfully',
        ], 200);
    }
}
