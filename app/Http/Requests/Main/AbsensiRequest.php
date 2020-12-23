<?php
namespace App\Http\Requests\Main;

use App\Http\Requests\Request;

class AbsensiRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'tanggal' => 'required',
            // 'kode' => 'required|unique:ref_barang,kode,'.$this->get('id'),
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


