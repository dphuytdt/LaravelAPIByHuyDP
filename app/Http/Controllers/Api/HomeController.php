<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/home",
     *      operationId="getHomeList",
     *      tags={"Home"},
     *      summary="Get HomePage",
     *      description="Returns Home Page",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *     )
     *
     * Returns list of Home
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Home',
        ]);
    }
}
