<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePostRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        /*if (Request::ajax()){
            return [];
        }*/
        return [
            'title'            => 'string|required',
            'category_id'     => 'alpha_num|required',
            'body_original'   => 'required',
            'excerpt'   => 'required',
//            'cover_image' => 'image',
        ];
    }
}
