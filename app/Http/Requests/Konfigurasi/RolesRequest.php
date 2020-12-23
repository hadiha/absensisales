<?php
namespace App\Http\Requests\Konfigurasi;

use App\Http\Requests\Request;

class RolesRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'display_name' => 'required|unique:sys_roles,display_name,'.$this->get('id'),
            'name' => 'required|unique:sys_roles,name,'.$this->get('id'),
        ];

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        $attributes['display_name']    = 'Nama Hak Akses';
        $attributes['name']    = 'Kode Hak Akses';
        return $attributes;
    }

}


