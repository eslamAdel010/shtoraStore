<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class commentController extends Controller
{
        // ✅ استرجاع جميع التعليقات
    public function index()
    {
        $comments = Comment::all();

        if ($comments->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No comments found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'comments' => $comments,
        ], 200);
    }

    // ✅ إضافة تعليق جديد
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $comment = Comment::create([
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ], 201);
    }

    // ✅ استرجاع تعليق معين
    public function show($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => 404,
                'message' => 'Comment not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'comment' => $comment,
        ], 200);
    }

    // ✅ تحديث تعليق
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => 404,
                'message' => 'Comment not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Comment updated successfully',
            'comment' => $comment,
        ], 200);
    }
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        if (!$comment) {
            return response()->json([
                'status' => 404,
                'message' => 'Comment not found',
            ], 404);
        }
    $comment->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Comment deleted done',
        ], 200);
    }
}
