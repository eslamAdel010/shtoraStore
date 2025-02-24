<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CommentController;
use App\Http\Controllers\Api\Admin\OrderDetailesController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ReturnController;
use App\Http\Controllers\Api\Admin\SizeController;
use App\Http\Controllers\Api\User\OrderController;
use App\Models\Api\Admin\OrderDetailes;
use Illuminate\Support\Facades\Route;



// ✅ مجموعة راوت التعليقات (Comments)
Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/', [CommentController::class, 'store']);
    Route::get('/{id}', [CommentController::class, 'show']);
    Route::post('/{id}', [CommentController::class, 'update']);
    Route::delete('/{id}', [CommentController::class, 'delete']);
});

// ✅ مجموعة راوت الأحجام (Sizes)
Route::prefix('sizes')->group(function () {
    Route::get('/', [SizeController::class, 'index']);
    Route::post('/', [SizeController::class, 'store']);
    Route::get('/{id}', [SizeController::class, 'show']);
    Route::post('/{id}', [SizeController::class, 'update']);
    Route::delete('/{id}', [SizeController::class, 'destroy']);
});

// ✅ مجموعة راوت المرتجعات (Returns)
Route::prefix('returns')->group(function () {
    Route::get('/', [ReturnController::class, 'index']);
    Route::post('/', [ReturnController::class, 'store']);
    Route::get('/{id}', [ReturnController::class, 'show']);
});

// ✅ مجموعة راوت المنتجات (Products)
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

// ✅ مجموعة راوت الطلبات (Orders)
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']); // ✅ عرض كل الطلبات
    Route::post('/', [OrderController::class, 'store']); // ✅ إنشاء طلب جديد + حفظ بيانات السلة
    Route::get('/{id}', [OrderController::class, 'show']); // ✅ عرض تفاصيل طلب معين
    Route::delete('/{id}', [OrderController::class, 'destroy']); // ✅ حذف طلب معين
});

// ✅ مجموعة راوت الفئات (Categories)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);      // عرض جميع الفئات
    Route::post('/', [CategoryController::class, 'store']);     // إضافة فئة جديدة
    Route::get('/{id}', [CategoryController::class, 'show']);   // عرض فئة محددة
    Route::post('/{id}', [CategoryController::class, 'update']);// تحديث فئة
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // حذف فئة
});
Route::prefix('orderDetailes')->group(function () {
    Route::get('/', [OrderDetailesController::class, 'index']);      // عرض جميع الفئات
    Route::post('/', [OrderDetailesController::class, 'store']);     // إضافة فئة جديدة
    Route::get('/{id}', [OrderDetailesController::class, 'show']);   // عرض فئة محددة
    Route::post('/{id}', [OrderDetailesController::class, 'update']);// تحديث فئة
    Route::delete('/{id}', [OrderDetailesController::class, 'destroy']); // حذف فئة
});

Route::group([
    
    'middleware' => 'api',
    'prefix' => 'auth'
    
], function ($router) {
    Route::post('register', [AdminController::class ,'register' ]);

    Route::post('login', [AdminController::class ,'login' ]);
    Route::post('logout', [AdminController::class ,'logout']);
    Route::post('refresh', [AdminController::class ,'refresh']);
    Route::post('me', [AdminController::class ,'me']);

});