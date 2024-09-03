<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

/**
 * @OA\PathItem(path="/api/posts")
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts/",
     *     summary="Get list of reviews",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reviews"
     *     )
     * )
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }



    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
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
        $post = Post::find($id);

        if (is_null($post)) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($post);
    }
}
