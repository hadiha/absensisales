<?php
namespace App\Http\Requests\Master;

use App\Http\Requests\Request;

class SalesAreaRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'user_id' => 'required|unique:ref_sales_area,user_id,'.$this->get('id'),
            'area_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'koordinator_id' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['user_id']    = 'Sales';
        $attributes['area_id']    = 'Area';
        $attributes['start_date']    = 'Mulai';
        $attributes['end_date']    = 'Sampai';
        $attributes['koordinator_id']    = 'Koordinator';
        return $attributes;
    }

}


