<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profile/{id}",
     *     summary="View user profile",
     *    operationId="viewProfile",
     *    @OA\Parameter(
     *          name="id",
    *           in="path",
*               required=true,
     *     ),  
     *     description="Retrieve user profile information",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile information retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Profile information retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *             @OA\Property(property="user", type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="fullname", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="username", type="string", example="johndoe"),
     *             @OA\Property(property="role", type="string", example="user"),
     *             @OA\Property(property="province_id", type="integer", example=1),
     *             @OA\Property(property="district_id", type="integer", example=10),
     *             @OA\Property(property="ward_id", type="integer", example=111),
     *             @OA\Property(property="address", type="string", example="123 Street"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="gender", type="integer", example="1"),
     *             @OA\Property(property="birthday", type="string", example="1990-01-01"),
     *             @OA\Property(property="avatar", type="string", example="http://example.com/avatar.png"),
     *                 )
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
    public function viewProfile($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Profile information retrieved successfully',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                'data' => ''
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/profile",
     *     summary="Update user profile",
     *     description="Update the user profile information",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Profile updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="The name field is required.")
     *                 ),
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email must be a valid email address.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }

    

}
