<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() || !is_null($this->user());
    }

    /**
     * validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return $rules = [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Email tidak valid.',
            'unique' => ':attribute tidak boleh sama.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'min' => ':attribute tidak boleh kurang dari :min karakter.',
            'date_format' => ':attribute tidak sesuai dengan format penanggalan.',
        ];
    }
}
