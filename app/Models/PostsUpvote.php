<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PostsUpvote extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'count',
        'post_id'
    ];

    /**
     * Upvote update validation rules.
     *
     * @var array<int, string>
     */
    protected $rules_update = [
        'post_id'=> 'integer|exists:posts,id',
        'count' => 'required|integer',

    ];

    /**
     * Upvote create validation rules.
     *
     * @var array<int, string>
     */
    protected $rules_create = [
        'post_id'=> 'required|integer|exists:posts,id',
        'count' => 'required|integer',
    ];

    /**
     * General validation function.
     *
     * @param  array $rules
     * @param  object $inputs
     * @return bool
     */
    protected function validate($inputs, $rules) {
        $v = Validator::make($inputs, $rules);
        if($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }

    /**
     * Validation upvote create function.
     *
     * @param  object $inputs
     * @return bool
     */
    public function validateCreate($inputs) {

        return $this->validate($inputs, $this->rules_create);
    }

    /**
     * Validation upvote update function.
     *
     * @param  object $inputs
     * @return bool
     */
    public function validateUpdate($inputs) {

        return $this->validate($inputs, $this->rules_update);

    }

    public function post()
    {
        return $this->belongsTo('App\Models\Posts', 'post_id');
    }


}
