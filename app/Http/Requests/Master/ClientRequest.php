<?php
namespace App\Http\Requests\Master;

use App\Http\Requests\Request;

class ClientRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'code' => 'required|unique:ref_client,code,'.$this->get('id'),
            'name' => 'required|unique:ref_client,name,'.$this->get('id'),
            'file' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['code']    = 'Kode';
        $attributes['name']    = 'Nama';
        $attributes['file']    = 'Logo';
        return $attributes;
    }

}


