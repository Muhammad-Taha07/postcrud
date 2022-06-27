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
use App\Post_Media;

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
        catch(Exception $exception)
        {
            return response()->json([
                    "success" => false,
                    "status"  => 500,
                    "message" => "Failed to fetch post",
                    "track"   => $exception->getMessage()
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

        $post_media = Post_Media::create([
                    'post_id' => $posts->id,
                    'media_url' => $req->media_url,
                    'media_thumb_url' => $req->media_thumb_url,
                    'status' => Constants::POST_MEDIA_TYPE_ACTIVE,
        ]);

        return response()->json([
                    "success" => true,
                    "status"  => 200,
                    "message" => "Post Created Successfully",
                    "data"    => $posts
        ], 200);
    }
    catch(Exception $exception)
    {
        return response()->json([
                    "success" => false,
                    "status"  => 400,
                    "message" => "Post Creation fail",
            ], 400);
    }
    }

    public function uploadFile(Request $req, Post_Media $post_media)
    {
        try
        {
        $uploadedImage = $req->file('file')->store('apiDocs');
        return response()->json([
                    "success" => true,
                    "status"  => 200,
                    "message" => "Image Uploaded Successfully",
                    "data"    => $uploadedImage
        ], 200);
        }

        catch(Exception $exception)
        {
            return response()->json([
                    "success" => false,
                    "status"  => 500,
                    "message" => "Image Uploading Failed",
                    "track"   => $exception->getMessage()
            ], 500);
        }
    }

    public function RealtionshipFetch()
    {
        try
        {
        $user = Auth::user();
        $post = User::where('id', $user->id)->with('postings')->get();
            return response()->json([
                    "success" => true,
                    "status"  => 200,
                    "message" => "Relationship fetched",
                    "data"    => $post
            ], 200);
        }
        catch(Exception $exception)
        {
            return response()->json([
                    "success" => false,
                    "status"  => 404,
                    "message" => "Relationship not found",
                    "track"   => $exception->getMessage()
            ], 404);
        }
    }

    public function useJoins()
    {
        try
        {
        $user       =   Auth::user();
        $userModel  =   new User();
        $records    =   $userModel->getUserPosts($user);
        return response()->json([
                    "success" => true,
                    "status"  => 200,
                    "message" => "Success",
                    "data"    => $records
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                    "success" => false,
                    "status"  => 400,
                    "message" => "Joins Failed"
            ], 400);
        }
    }

    public function storeImage(Request $request, Post_Media $media)
    {
        try
        {
        // $media_thumb_url = $request->input('media_thumb_url');
        $media_url = $request->file('file')->getClientOriginalName();
        $request->file('file')->store('apiDocs');
        $media->media_url = $media_url;
        $media->save();

            return response()->json([
                    "success" => true,
                    "status"  => 200,
                    "message" => "File uploaded Successully",
                    "data"    => $media
            ], 200);
        }

        catch(Exception $exception)
        {
            return response()->json([
                    "success" => false,
                    "status"  => 400,
                    "message" => "Upload Failed",
                    "track"   => getMessage()
            ], 400);
        }

    }


}
