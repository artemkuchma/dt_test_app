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
        'created_at',
        'updated_at',
    ];

    protected $rules = array(
        'title'=> 'required|min:5',
        'author_name' => 'required',
        'link' => 'required'
    );

    public function validate($inputs) {
        $v = Validator::make($inputs, $this->rules);
        if($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }







    public function create(Request $request)
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
    }
}
