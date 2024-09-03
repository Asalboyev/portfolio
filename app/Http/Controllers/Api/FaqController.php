<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Information;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/faqs")
 */
class FaqController extends Controller

{
    /**
     * @OA\Get(
     *     path="/api/faqs/",
     *     summary="Get list of reviews",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reviews"
     *     )
     * )
     */
    public function index()
    {
        $portfolios = Faq::all();
        return response()->json($portfolios);
    }
    /**
     * @OA\Get(
     *     path="/api/info/",
     *     summary="Get list of reviews",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reviews"
     *     )
     * )
     */
    public function info()
    {
        // Get the first portfolio by ordering by id
        $portfolio = Information::orderBy('id', 'asc')->first();

        // Check if a portfolio was found
        if (!$portfolio) {
            // Return a 404 Not Found response if no portfolio is found
            return response()->json(['message' => 'No portfolio found.'], 404);
        }

        // Return the portfolio as a JSON response
        return response()->json($portfolio);
    }






    /**
     * @OA\Get(
     *     path="/api/faqs/{id}",
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
        $portfolio = Faq::find($id);

        if (is_null($portfolio)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($portfolio);
    }
}
