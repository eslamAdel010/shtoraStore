<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // ✅ تسجيل حساب جديد
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'title' => 'required|string',
            'salary' => 'required|numeric',
            'department' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'title' => $request->title,
            'salary' => $request->salary,
            'department' => $request->department,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'تم تسجيل المشرف بنجاح!',
            'admin' => $admin,
        ], 201);
    }

public function login(Request $request)
{
    // ✅ التحقق من صحة البيانات المدخلة
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    try {
        // ✅ محاولة تسجيل الدخول من خلال `admin` guard
        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'بيانات تسجيل الدخول غير صحيحة!'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['message' => 'حدث خطأ أثناء إنشاء التوكن!'], 500);
    }

    // ✅ الحصول على بيانات الأدمن المسجل دخول
    $admin = Auth::guard('admin')->user();

    return response()->json([
        'message' => 'تم تسجيل الدخول بنجاح!',
        'token' => $token,
        'admin' => [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'title' => $admin->title,
            'department' => $admin->department,
            'salary' => $admin->salary,
        ],
    ]);
}

    // ✅ استرجاع بيانات المشرف باستخدام التوكن
    public function profile()
    {
        return response()->json([
            'status' => 200,
            'admin' => Auth::user()
        ]);
    }

    // ✅ تسجيل الخروج وإبطال التوكن
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'تم تسجيل الخروج بنجاح!']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'حدث خطأ أثناء تسجيل الخروج!'], 500);
        }
    }
}
