<?php
namespace App\Http\Requests\Master;

use App\Http\Requests\Request;

class AreaRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'kode' => 'required|unique:ref_area,kode,'.$this->get('id'),
            'name' => 'required|unique:ref_area,name,'.$this->get('id'),
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['kode']    = 'Kode';
        $attributes['name']    = 'Nama';
        return $attributes;
    }

}


