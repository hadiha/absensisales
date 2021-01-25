<?php

namespace App\Http\Controllers\Konfigurasi;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\Konfigurasi\UsersRequest;

/* Models */
use App\Models\Authentication\User;

/* Libraries */
use DataTables;
use Entrust;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

// use Hash;

class SettingController extends Controller
{
    protected $link = 'konfigurasi/profile/';
    // protected $perms = 'konfigurasi-users';

    function __construct()
    {
        $this->setLink($this->link);
        // $this->setPerms($this->perms);
        $this->setTitle("Profile Pengguna");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Konfigurasi' => '#', 'Profile Pengguna' => '#']);
    }

    public function index()
    {
        return $this->render('modules.konfigurasi.profile.index');
    }

    public function create()
    {
        return $this->render('modules.konfigurasi.users.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
        ],[
            'name.required' => 'Nama harap diisi',
            'gender.required' => 'Gender harap diisi',
            'phone.min' => 'No Telepon harap diisi',
            'birth_place.required' => 'Tempat Lahir harap diisi',
            'birth_date.required' => 'Tanggal Lahir harap diisi',
        ]);

        // return response($record, 422);
        $record = User::find($request->id);
        $record->name = $request->name;
        $record->phone = $request->phone;
        // $record->email = $request->email;
        $record->gender = $request->gender;
        $record->birth_place = $request->birth_place;
        $record->birth_date = Carbon::createFromFormat('F j, Y', $request->birth_date);
        $record->save();

        return response([
            'status' => true,
            'data' => $record
        ]);
    }

    public function edit($id)
    {
        $record = User::find($id);

        return $this->render('modules.konfigurasi.users.edit', [
            'record' => $record
        ]);
    }

    public function update(Request $request, $id)
    {
        // return response($request->password_lama, 422);
        $request->validate([
            'password_lama' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required',
        ],[
            'password_lama.required' => 'Password Lama Harus diisi',
            'password.required' => 'Password Harus diisi',
            'password.min' => 'Password Minimal 8 Karakter',
            'confirm_password.required' => 'Konfirmasi Password Harus diisi'
        ]);
        $record = User::find($id);
        if($request->password_lama && !Hash::check($request->password_lama, $record->password)){
            return response([
                'message' => 'Password Lama tidak sesuai',
                'errors' => [
                    'password_lama' => ['Password Lama tidak sesuai']
                ]
            ], 422);
        }elseif($pass = $request->password && $request->password != $request->confirm_password){
            return response([
                'message' => 'Password tidak sama',
                'errors' => [
                    'confirm_password' => ['Password tidak sama']
                ]
            ], 422);
        } elseif($pass = $request->password && $request->password == $request->confirm_password){
            $record->password = bcrypt($pass);
        }
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
       //
    }

    public function setFoto(Request $request)
    {
        try{
            $record = User::find($request->id);
            $url = $record->picUpload($request->picture);

            return response([
                'status' => true,
                'url' => asset('storage/'.$url)
            ]);

        } catch (Exception $e) {
              return response([
                'status' => false,
                'errors' => $e
            ]);
        }
    }
}
