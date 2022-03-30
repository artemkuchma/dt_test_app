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
        $posts = Posts::all();
        return response()->json([
            "success" => true,
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

        if(!$model->validate($request->all())){
            return response()->json([
                "success" => false,
                "message" => "Validation Error.",
                "data" => $model->errors
            ]);
        }
        $model->title = $request->get('title');
        $model->author_name = $request->get('author_name');
        $model->link = $request->get('link');
        $model->created_at = time();
        $model->updated_at = time();
        $model->save();


        // $data = $request->all();
        //$posts = Posts::create($data);
        return response()->json([
            "success" => true,
            "message" => "Post created successfully.",
           // "data" => $posts
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

        $post = DB::table('posts')->find($id);
        if (is_null($post)) {
            return response()->json([
                "success" => false,
                "message" => "Post not found.",

            ]);
        }
        return response()->json([
            "success" => true,
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
        $post = DB::table('posts')->find($id);
        if($post){
            $post->update($request->all(),$id);
            return response()->json([
                "success" => true,
                "message" => "Post updated successfully.",

            ]);
        }
        return response()->json([
            "success" => false,
            "message" => "Post not found.",

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
        $post = DB::table('posts')->find($id);
        if(!$post){
            return response()->json([
                "success" => false,
                "message" => "Post not found.",

            ]);
        }
        $post->delete();
        return response()->json([
            "success" => true,
            "message" => "Post deleted successfully.",

        ]);
    }
}
