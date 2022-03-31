<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Validator;


class Posts extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author_name',
        'link',
        'date_create'
    ];

    /**
     * Post update validation rules.
     *
     * @var array<int, string>
     */
    protected $rules_update = [
        'title'=> 'min:5v',
        'author_name' => 'min:2|string',
        'link' => 'string',
        'date_create' => 'date_format:"Y-m-d"'
    ];

    /**
     * Post create validation rules.
     *
     * @var array<int, string>
     */
    protected $rules_create = [
        'title'=> 'required|min:5|string',
        'author_name' => 'required|min:2|string',
        'link' => 'required|string',
        'date_create' => 'required|date_format:"Y-m-d"'
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
     * Validation post create function.
     *
     * @param  object $inputs
     * @return bool
     */
    public function validateCreate($inputs) {

        return $this->validate($inputs, $this->rules_create);
    }

    /**
     * Validation post update function.
     *
     * @param  object $inputs
     * @return bool
     */
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


}
