<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\PostsUpvote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the posts (sort by desc) with upvots .
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::with(['upvots'])->get()->sortByDesc('date_create');
        return response()->json([
            "response" => 200,
            "message" => "Posts List",
            "data" => $posts
        ]);
    }

    /**
     * Display a listing of the posts (sort by desc) with upvots and with comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexComments()
    {
        $posts = Posts::with(['upvots'])->with(['comments'])->get()->sortByDesc('date_create');//with(['comments'])->
        return response()->json([
            "response" => 200,
            "message" => "Posts List with comments",
            "data" => $posts
        ]);
    }
    /**
     * Store a newly created post in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $model = new Posts();

        if(!$model->validateCreate($request->all())){
            return response()->json([
                "response" => 400,
                "message" => "Validation Error.",
                "data" => $model->errors
            ]);
        }

        $data = $model->create($request->all());

        return response()->json([
            "response" => 201,
            "message" => "Post created successfully.",
            "data" => $data
        ]);
    }
    /**
     * Display the specified post with upvots.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Posts::with(['upvots'])->find($id);//DB::table('posts')->find($id);
        if (is_null($post)) {
            return response()->json([
                "response" => 404,
                "message" => "Post not found.",

            ]);
        }
        return response()->json([
            "response" => 200,
            "message" => "Successful.",
            "data" => $post
        ]);
    }

    /**
     * Display the specified post with upvots and comments.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFromComments($id)
    {

        $post = Posts::with(['upvots'])->with(['comments'])->find($id);//DB::table('posts')->find($id);
        if (is_null($post)) {
            return response()->json([
                "response" => 404,
                "message" => "Post not found.",

            ]);
        }
        return response()->json([
            "response" => 200,
            "message" => "Successful.",
            "data" => $post
        ]);
    }










    /**
     * Update the specified post in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Posts::find($id); //DB::table('posts')->find($id);
        if(!$post){

            return response()->json([
                "response" => 404,
                "message" => "Post not found.",

            ]);


        }
        if(!$post->validateUpdate($request->all())){
            return response()->json([
                "response" => 400,
                "message" => "Validation Error.",
                "data" => $post->errors
            ]);

        }
      $data = $post->update($request->all());
        return response()->json([
            "response" => 200,
            "message" => "Post updated successfully.",
            'data' => $data

        ]);

    }
    /**
     * Remove the specified post from db.
     * Related comments and upvotes will also be removed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        if(!$post){
            return response()->json([
                "response" => 404,
                "message" => "Post not found.",

            ]);
        }
       // Posts::deleted($id);
        $post->delete();
        return response()->json([
            "response" => 204,
            "message" => "Post deleted successfully.",

        ]);
    }

    /**
     * Adding a new or increasing one unit of an existing upvote.
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function upvote($post_id)
    {

        $upvote = PostsUpvote::where('post_id', $post_id)->first();
        if (is_null($upvote)) {
            $upvote_new = new PostsUpvote();
            $input = [
                'post_id' => $post_id,
                'count' => 1
            ];
            if($upvote_new->validateCreate($input)){
                $upvote_new->post_id = $post_id;
                 $upvote_new->count = 1;
                $upvote_new->save();

                return response()->json([
                    "response" => 201,
                    "message" => "Successful upvote.",
                    //"data" => $data
                ]);
            }else{
                return response()->json([
                    "response" => 400,
                    "message" => "Validation Error.",
                    "data" => $upvote->errors
                ]);
            }
        }

        $upvote->increment('count');

        return response()->json([
            "response" => 201,
            "message" => "Successful upvote.",
        ]);
    }




}
