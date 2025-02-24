<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();

        if ($sizes->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No sizes found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'sizes' => $sizes,
        ], 200);
    }

    // ✅ استرجاع حجم معين
    public function show($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'status' => 404,
                'message' => 'Size not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'size' => $size,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:255',
        ]);

        $size = Size::create([
            'size' => $request->size,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Size added successfully',
            'size' => $size,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'status' => 404,
                'message' => 'Size not found',
            ], 404);
        }

        $size->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Size updated successfully',
            'size' => $size,
        ], 200);
    }

    public function destroy($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'status' => 404,
                'message' => 'Size not found',
            ], 404);
        }

        $size->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Size deleted successfully',
        ], 200);
    }
}
