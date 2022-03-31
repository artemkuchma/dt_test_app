<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PostsUpvote extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'post_id'
    ];

    protected $rules_update = [
        'post_id'=> 'integer|exists:posts,id',
        'count' => 'required|integer',

    ];

    protected $rules_create = [
        'post_id'=> 'required|integer|exists:posts,id',
        'count' => 'required|integer',
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
