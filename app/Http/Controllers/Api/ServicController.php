<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servic;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/services")
 */
class ServicController extends Controller

{
    /**
     * @OA\Get(
     *     path="/api/services/",
     *     summary="Get list of reviews",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reviews"
     *     )
     * )
     */
    public function index()
    {
        // Filter portfolios where status is 'active'
        $activePortfolios = Servic::where('status', 'active')->get();

        // Check if any active portfolios are found
        if ($activePortfolios->isEmpty()) {
            // Return a 404 Not Found response if no active portfolios are found
            return response()->json(['message' => 'No active portfolios found.'], 404);
        }

        // Return the active portfolios as a JSON response
        return response()->json($activePortfolios);
    }


    /**
     * @OA\Get(
     *     path="/api/services/{id}",
     *     summary="Get a review by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A review"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function show($id)
    {
        $portfolio = Servic::find($id);

        if (is_null($portfolio)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($portfolio);
    }
}
