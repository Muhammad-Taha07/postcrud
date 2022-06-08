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
use App\User;


class PostController extends Controller
{
    public function fetchPosts()
    {
        try
        {
            $posts = Post::all();
            return response()->json([
                "success" => true,
                "status"  => 200,
                "message" => "Posts have been fetched",
                "data"    => $posts
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
        try
        {
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
    public function RealtionshipFetch()
    {
        try
        {
        $post = User::where('id', 7)->with('postfetched')->first();
            return response()->json([
                "success" => true,
                "status"  => 200,
                "message" => "Relationship fetched",
                "data"    => $post
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                "success" => false,
                "status"  => 404,
                "message" => "Relation not found"
            ], 404);
        }
    }

    public function useJoins()
    {
        try
        {
        $result = DB::table('users')
        ->join('posts','posts.id', '=', 'posts.user_id')
        ->select('users.name as UserName', 'posts.title as PostName')
        ->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Success",
            "data" => $result
        ], 200);
        }

        catch(Exception $e)
        {
            return response()->json([
                "success" => false,
                "status" => 400,
                "message" => "Not found Relationship"
            ], 400);
        }
    }

}
