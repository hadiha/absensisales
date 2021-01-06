<?php
namespace App\Http\Requests\Main;

use App\Http\Requests\Request;

class LaporanRequest extends Request
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
            'stock' => 'required',
            'sale_in' => 'required',
            'sale_out' => 'required',
            'filespath' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['tanggal']      = 'Tanggal';
        $attributes['stock']        = 'Stok';
        $attributes['sale_in']      = 'Sale In';
        $attributes['sale_out']     = 'Sale Out';
        $attributes['filespath']    = 'Foto';
        return $attributes;
    }

}


