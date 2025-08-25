<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('Admin API Token')->accessToken;

        return response()->json([
            'admin' => $admin,
            'token' => $token,
        ]);
    }


    public function me(Request $request)
    {
        return response()->json($request->user('admin-api'));
    }

    public function logout(Request $request)
    {
        $request->user('admin-api')->token()->revoke();
        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
