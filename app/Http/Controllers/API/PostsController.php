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
     * Display a listing of the posts.
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
     * Display a listing of the posts.
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

*/
        $model = new Posts();
        //$data = $request->all(); //json_decode($request->all());

        if(!$model->validateCreate($request->all())){
            return response()->json([
                "response" => 400,
                "message" => "Validation Error.",
                "data" => $model->errors
            ]);
        }
        /*
        $model->title = $data['title'];//$request->get('title');
        $model->author_name = $data['author_name'];//$request->get('author_name');
        $model->link = $data['link'];// $request->get('link');

        $model->save();*/
       // $model->created_at = time();
       // $model->updated_at = time();
        $data = $model->create($request->all());


        // $data = $request->all();
        //$posts = Posts::create($data);
        return response()->json([
            "response" => 201,
            "message" => "Post created successfully.",
            "data" => $data
        ]);
    }
    /**
     * Display the specified resource.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFromComments($id)
    {

        $post = Posts::with(['comments'])->find($id);//DB::table('posts')->find($id);
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upvote($post_id)
    {

        $upvote = PostsUpvote::where('post_id', $post_id)->first();// Posts::find($id);//DB::table('posts')->find($id);
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
               // $upvote_new->created($input);

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
