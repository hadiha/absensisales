<?php
namespace App\Http\Requests\Konfigurasi;

use App\Http\Requests\Request;

class UsersRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        // ambil validasi dasar
        $rules = [
            // 'password_lama'    => 'required',
            'username' => 'required|unique:sys_users,username,'.$this->get('id'),
            'email' => 'required|unique:sys_users,email,'.$this->get('id'),
            'roles' => 'required'
            
        ];

        if($this->roles[0] == '2'){
            $rules['area_id'] = 'required';
        }
        
        if(!$this->get('id') || $this->password_lama){
            $rules['password'] = 'min:8|required_with:confirm_password|same:confirm_password';
            $rules['confirm_password'] = 'min:8';
        }

        return $rules;
    }

    public function attributes()
    {
        // ambil validasi dasar
        // $attributes = $this->attr;

        // validasi tambahan
        // $attributes['password_lama']    = 'Password Lama';
        $attributes['username']         = 'Username';
        $attributes['email']            = 'E-Mail';
        $attributes['area_id']          = 'Area';
        $attributes['password']         = 'Password Baru';
        $attributes['confirm_password'] = 'Konfirmasi Password';
        return $attributes;
    }

}


