<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
class CartController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/cart",
     *     summary="View cart",
     *     description="View the contents of the user's shopping cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Cart retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Cart retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="items", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Product 1"),
     *                         @OA\Property(property="price", type="number", format="float", example=19.99),
     *                         @OA\Property(property="quantity", type="integer", example=3)
     *                     )
     *                 ),
     *                 @OA\Property(property="total_price", type="number", format="float", example=59.97)
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
    public function index()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart retrieved successfully',
            'data' => [
                'items' => $cart,
                'total_price' => $totalPrice
            ]
        ]);
    }



    /**
     * @OA\Post(
     *     path="/api/cart",
     *     summary="Add item to cart",
     *     description="Add an item to the user's shopping cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item added to cart",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Item added to cart successfully")
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
     *                 @OA\Property(property="product_id", type="array",
     *                     @OA\Items(type="string", example="The product_id field is required.")
     *                 ),
     *                 @OA\Property(property="quantity", type="array",
     *                     @OA\Items(type="string", example="The quantity field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        $cart = Cart::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        if ($cart) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item added to cart failed'
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/cart",
     *     summary="Update cart",
     *     description="Update the contents of the user's shopping cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=3)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Cart updated successfully")
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
     *                 @OA\Property(property="items", type="array",
     *                     @OA\Items(type="string", example="The items field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);

        foreach ($request->items as $item) {
            $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $item['product_id'])->first();
            $cart->quantity = $item['quantity'];
            $cart->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/cart/{productId}",
     *     summary="Delete item from cart",
     *     description="Delete an item from the user's shopping cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         description="ID of the product to be deleted from the cart",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Item deleted successfully")
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
     *         response=404,
     *         description="Item not found in cart",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Item not found in cart")
     *         )
     *     )
     * )
     */
    public function destroy($productId)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->first();

        if ($cart) {
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/cart",
     *     summary="Delete all items from cart",
     *     description="Delete all items from the user's shopping cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="All items deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="All items deleted successfully")
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
    public function destroyAll()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'All items deleted successfully'
        ]);
    }


}
