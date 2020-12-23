<?php
namespace App\Http\Requests\Master;

use App\Http\Requests\Request;

class BarangRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'kode' => 'required|unique:ref_barang,kode,'.$this->get('id'),
            'name' => 'required|unique:ref_barang,name,'.$this->get('id'),
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


