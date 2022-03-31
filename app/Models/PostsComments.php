<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PostsComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'content',
        'date_create',
        'post_id'
    ];

    protected $rules_update = [
        'post_id'=> 'integer|exists:posts,id',
        'author_name' => 'min:2|string',
        'content' => 'string',
        'date_create' => 'date_format:"Y-m-d"'
    ];

    protected $rules_create = [
        'post_id'=> 'required|integer|exists:posts,id',
        'author_name' => 'required|min:2|string',
        'content' => 'required|string',
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




    public function post()
    {
        return $this->belongsTo('App\Models\Posts', 'post_id');
    }
}
