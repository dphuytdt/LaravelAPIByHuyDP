<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/login",
     *     summary="Login Page",
     *     description="Display the login page",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Login page rendered",
     *         @OA\MediaType(
     *             mediaType="text/html"
     *         )
     *     )
     * )
     */
    public function showLoginForm()
    {
        return response()->json([
            'success' => true,
            'message' => 'Login Page',
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     description="Authenticate user and generate access token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="access_token_here")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
    */
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if(!Auth::attempt($login)){
            return response(['message' => 'Invalid login credentials']);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'Login successfully!',
            'data' => [
                'user' => Auth::user(),
                'token' => $accessToken
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/logout",
     *     summary="User logout",
     *     description="Invalidate user token and logout",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Logout successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ]);
        }
    }
}
