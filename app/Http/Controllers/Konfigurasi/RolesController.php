<?php

namespace App\Http\Controllers\Konfigurasi;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\Konfigurasi\RolesRequest;

/* Models */
use App\Models\Authentication\Role;

/* Libraries */
use DataTables;
use Carbon;
use Hash;

class RolesController extends Controller
{
    protected $link = 'konfigurasi/roles/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Hak Akses");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Konfigurasi' => '#', 'Hak Akses' => '#']);

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
                'data' => 'display_name',
                'name' => 'display_name',
                'label' => 'Nama Hak Akses',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'label' => 'Kode',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'users',
                'name' => 'users',
                'label' => 'Jumlah Pengguna',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
                'width' => '120px',
            ],
            [
                'data' => 'perms',
                'name' => 'perms',
                'label' => 'Jumlah Akses',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
                'width' => '120px',
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Dibuat Pada',
                'searchable' => false,
                'sortable' => true,
                'width' => '120px',
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'label' => 'Aksi',
                'searchable' => false,
                'sortable' => false,
                'className' => "center aligned",
                'width' => '100px',
            ]
        ]);
    }

    public function grid(Request $request)
    {
        $records = Role::with('users', 'perms')
                       //Filters
                       ->when($display_name = $request->display_name, function($q) use ($display_name){
                            return $q->where('display_name', 'like', '%' . $display_name . '%');
                       })
                       ->when($name = $request->name, function($q) use ($name){
                            return $q->where('name', 'like', '%' . $name . '%');
                       })
                       ->select('*');
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->addColumn('users', function ($record) {
                return $record->users()->count();
            })
            ->addColumn('perms', function ($record) {
                return $record->perms()->count();
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->addColumn('action', function ($record) use ($link){
                $btn = '';
                
                $btn .= $this->makeButton([
                    'type' => 'url',
                    'class'   => 'teal icon detail',
                    'label'   => '<i class="file text icon"></i>',
                    'tooltip' => 'Detail',
                    'url'  => url($link.$record->id)
                ]);
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'id'   => $record->id
                ]);
                // Delete
                if($record->users()->count() == 0){
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
        return $this->render('modules.konfigurasi.roles.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.konfigurasi.roles.create');
    }

    public function store(RolesRequest $request)
    {
        $record = new Role;
        $record->fill($request->all());
        $record->save();

        auth()->user()->storeLog('Hak Akses', 'Membuat Hak Akses '.$record->name, $record->id);

        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $record = Role::find($id);

        return $this->render('modules.konfigurasi.roles.edit', [
            'record' => $record
        ]);
    }

    public function show($id)
    {
        $record = Role::find($id);

        return $this->render('modules.konfigurasi.roles.detail', [
            'record' => $record
        ]);
    }

    public function update(RolesRequest $request, $id)
    {
        $record = Role::find($id);
        $record->fill($request->all());
        $record->save();

        auth()->user()->storeLog('Hak Akses', 'Mengubah Hak Akses '.$record->name, $record->id);

        return response([
            'status' => true
        ]);
    }

    public function grant(Request $request, $id)
    {
        $record = Role::find($id);
        $record->perms()->sync($request->check);

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
        $record = Role::find($id);
        $record->delete();

        auth()->user()->storeLog('Hak Akses', 'Menghapus Hak Akses '.$record->name);

        return response([
            'status' => true,
        ]);
    }
}
