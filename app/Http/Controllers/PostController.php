<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\config\Constants;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\AccessToken;
use Illuminate\Support\Facades\Auth;
use App\Post;


class PostController extends Controller
{
    public function fetchPosts()
    {
        try
        {
            $post = Post::all();

            return response()->json([
                "success" => true,
                "status"  => 200,
                "message" => "Posts have been fetched",
                "data"    => $post
            ], 200);
        }

        catch(Exception $e)
        {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => "Fail to fetch posts."
            ], 500);
        }
    }
    public function createPost(Request $req)
    {
        $user = Auth::user();
        // dd($user);
        try
        {
            /* $user->posts()->create([
                'post_title' => $req->post_title,
                'post_description' => $req->post_description,
                'post_status' => Constants::POST_TYPE_ACTIVE,
            ]); */

        $posts = Post::create([
            'title' => $req->post_title,
            'user_id' => $user->id,
            'description' => $req->post_description,
            'status' => Constants::POST_TYPE_ACTIVE,
        ]);

        return response()->json([
            "success" => true,
            "status"  => 200,
            "message" => "Post Created Successfully",
            "data"    => $posts
        ], 200);
    }

    catch(Exception $e)
    {
        return response()->json([
            "success" => false,
            "status" => 400,
            "message" => "Post Creation fail",
        ], 400);
    }
}
}
