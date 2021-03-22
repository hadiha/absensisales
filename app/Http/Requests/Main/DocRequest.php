<?php
namespace App\Http\Requests\Main;

use App\Http\Requests\Request;

class DocRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'date' => 'required',
            'area_id' => 'required',
            'keterangan' => 'required',
            'filespath' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['date']          = 'Tanggal';
        $attributes['area_id']       = 'Area';
        $attributes['keterangan']    = 'Keterangan';
        $attributes['filespath']     = 'Foto';
        return $attributes;
    }

}


