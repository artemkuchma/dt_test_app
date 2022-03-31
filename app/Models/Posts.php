<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Validator;


class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_name',
        'link',
        'date_create'
    ];

    protected $rules_update = [
        'title'=> 'min:5v',
        'author_name' => 'min:2|string',
        'link' => 'string',
        'date_create' => 'date_format:"Y-m-d"'
    ];

    protected $rules_create = [
        'title'=> 'required|min:5|string',
        'author_name' => 'required|min:2|string',
        'link' => 'required|string',
        'date_create' => 'required|date_format:"Y-m-d"'
    ];

    protected function validate($inputs, $rules) {
        $v = Validator::make($inputs, $rules);
        if($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }

    public function validateCreate($inputs) {

        return $this->validate($inputs, $this->rules_create);
    }

    public function validateUpdate($inputs) {

        return $this->validate($inputs, $this->rules_update);

    }

    public function comments()
    {
        return $this->hasMany('App\Models\PostsComments', 'post_id');
    }

    public function upvots()
    {
        return $this->hasMany('App\Models\PostsUpvote', 'post_id');
    }



/*
    public function validateCreate($inputs) {
        $v = Validator::make($inputs, $this->rules_create);
        if($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }

    public function validateUpdate($inputs) {
        $v = Validator::make($inputs, $this->rules_update);
        if($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }

*/






/*
    public function create(Posts $model, $data)
    {




        $request->  validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required'
        ]);

        $contact = new Contact([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);
        $contact->save();
        return redirect('/contacts')->with('success', 'Contact saved!');
    }*/
}
