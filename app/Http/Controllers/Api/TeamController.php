<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
/**
 * @OA\PathItem(path="/api/teams")
 */
class TeamController extends Controller

{
    /**
     * @OA\Get(
     *     path="/api/teams",
     *     summary="Get list of reviews",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reviews"
     *     )
     * )
     */
    public function index()
    {
        $partners = Team::all();
        return response()->json($partners);
    }

    /**
     * @OA\Get(
     *     path="/api/teams/{id}",
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
        $partner = Team::find($id);

        if (is_null($partner)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($partner);
    }
}
