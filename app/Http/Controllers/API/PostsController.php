<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
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
        $posts = Posts::all()->sortByDesc('date_create');
        return response()->json([
            "response" => 200,
            "message" => "Posts List",
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

        $post = Posts::find($id);//DB::table('posts')->find($id);
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
}
