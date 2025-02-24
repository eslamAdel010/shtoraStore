<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        if (! $categories) {
            return response()->json([
                'status' => 404,
                'message' => 'No categories found',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'categories' => $categories,
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:204800',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        } else {
            $imagePath = null;
        }

        $category = Category::create([
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Category created successfully',
            'category' => $category,
        ], 201);
    }


    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'category' => $category,
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }

        $request->validate([
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // تحديث الاسم
        $category->category = $request->category;

        // تحديث الصورة إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // حفظ الصورة الجديدة
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'category' => $category,
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }

        // حذف الصورة من التخزين إذا كانت موجودة
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
