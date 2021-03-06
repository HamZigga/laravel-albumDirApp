<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist' => 'required|min:1|max:255',
            'album' => 'required|min:1|max:255',
            'img' => 'image|max:1990',
            'info' => 'required|min:1|max:2500'
        ];
    }

    public function messages(){
        return [
            'artist.required' => 'Поле исполнителя является обязательным',
            'album.required' => 'Поле альбома является обязательным',
            'img.image' => 'Поле картинки не является изображением',
            'info.required' => 'Поле информации является обязательным',


        ];
    }
}
