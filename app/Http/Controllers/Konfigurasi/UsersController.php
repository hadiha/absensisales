<?php

namespace App\Http\Controllers\Konfigurasi;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\Konfigurasi\UsersRequest;

/* Models */
use App\Models\Authentication\User;
use App\Models\Master\SalesArea;
/* Libraries */
use DataTables;
use Entrust;
use Carbon;
use Hash;

class UsersController extends Controller
{
    protected $link = 'konfigurasi/users/';
    protected $perms = 'konfigurasi-users';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Manajemen Pengguna");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Konfigurasi' => '#', 'Manajemen Pengguna' => '#']);

        // Header Grid Datatable
        $this->setTableStruct([
            [
                'data' => 'num',
                'name' => 'num',
                'label' => '#',
                'orderable' => false,
                'searchable' => false,
                'className' => "center aligned",
                'width' => '40px',
            ],
            /* --------------------------- */
            [
                'data' => 'name',
                'name' => 'name',
                'label' => 'Nama Lengkap',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'phone',
                'name' => 'phone',
                'label' => 'Phone',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'username',
                'name' => 'username',
                'label' => 'Username',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'label' => 'Email',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'roles',
                'name' => 'roles',
                'label' => 'Hak Akses',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'last_login',
                'name' => 'last_login',
                'label' => 'Login Terakhir',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Dibuat Pada',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'label' => 'Aksi',
                'searchable' => false,
                'sortable' => false,
                'className' => "center aligned",
                'width' => '150px',
            ]
        ]);
    }

    public function grid(Request $request)
    {
        if(!is_null(auth()->user()->client_id)){
            $records = User::where('client_id', auth()->user()->client_id)->select('*');
        } else {
            $records = User::select('*');
        }
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        //Filters
        if ($username = $request->username) {
            $records->where('username', 'like', '%' . $username . '%');
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->addColumn('roles', function ($record) {
                $roles = '';
                foreach ($record->roles as $i => $role) {
                    $roles .= $role->display_name;
                    if($i < $record->roles->count() - 1){
                        $roles .= ', ';
                    }
                }
                return $roles;
            })
            ->editColumn('last_login', function ($record) {
                // return $record->last_login->formatLocalized("%d %B");
                return $record->last_login->diffForHumans();
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->addColumn('action', function ($record) use ($link){
                $btn = '';
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-edit'),
                    'id'   => $record->id
                ]);
                // Delete
                if(auth()->user()->id != $record->id){
                    $btn .= $this->makeButton([
                        'type' => 'delete',
                        'id'   => $record->id,
                        'url'   => url($link.$record->id)
                    ]);
                }
                return $btn;
            })
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.konfigurasi.users.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.konfigurasi.users.create');
    }

    public function store(UsersRequest $request)
    {
        // return response($request->all(), 422);
        $record = new User;
        $record->fill($request->all());
        $record->password = bcrypt($request->password);
        $record->last_login = Carbon::now();
        $record->save();

        if($request->roles[0] == '2'){
            $sales = new SalesArea();
            $sales->user_id = $record->id;
            $sales->area_id = $request->area_id;
            $sales->save();
        }

        $record->roles()->sync($request->roles);

        auth()->user()->storeLog('User Pengguna', 'Membuat User Pengguna Baru '.$record->name, $record->id);

        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $record = User::find($id);

        return $this->render('modules.konfigurasi.users.edit', [
            'record' => $record
        ]);
    }

    public function update(UsersRequest $request, $id)
    {
        $record = User::find($id);
        $record->username = $request->username;
        $record->name = $request->name;
        $record->phone = $request->phone;
        $record->email = $request->email;
        if($request->password_lama && !Hash::check($request->password_lama, $record->password)){
            return response([
                'message' => 'Password Lama tidak sesuai',
                'errors' => [
                    'password_lama' => ['Password Lama tidak sesuai']
                ]
            ], 422);
        }elseif($pass = $request->password && $request->password == $request->confirm_password){
            $record->password = bcrypt($pass);
        }
        $record->save();

        $record->roles()->sync($request->roles);
        auth()->user()->storeLog('User Pengguna', 'Mengupdate User Pengguna '.$record->name, $record->id);

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
        $record = User::find($id);
        $record->delete();

        auth()->user()->storeLog('User Pengguna', 'Menghapus User Pengguna'.$record->name);

        return response([
            'status' => true,
        ]);
    }
}
