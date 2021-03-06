<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\Master\ClientRequest;
/* Models */
use App\Models\Master\Client;
/* Libraries */
use DataTables;
use Carbon\Carbon;
use Hash;

class ClientController extends Controller
{
    protected $link = 'master/client/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Data Klien");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Data Klien' => '#']);

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
                'data' => 'code',
                'name' => 'code',
                'label' => 'Kode Klien',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'label' => 'Nama Klien',
                'searchable' => false,
                'sortable' => true,
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
                'data' => 'created_by',
                'name' => 'created_by',
                'label' => 'Dibuat Oleh',
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
        $records = Client::when($kode = request()->code, function ($q) use ($kode) {
            return $q->where('code', 'like', '%' . $kode . '%');
        })
        ->when($name = request()->name, function ($q) use ($name) {
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
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->editColumn('created_by', function ($record) {
                return $record->creator->username;
            })
            ->addColumn('action', function ($record) use ($link){
                $btn = '';
                
                // $btn .= $this->makeButton([
                //     'type' => 'url',
                //     'class'   => 'teal icon detail',
                //     'label'   => '<i class="file text icon"></i>',
                //     'tooltip' => 'Detail',
                //     'url'  => url($link.$record->id)
                // ]);
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'id'   => $record->id
                ]);
                // Delete
                $btn .= $this->makeButton([
                    'type' => 'delete',
                    'id'   => $record->id,
                    'url'   => url($link.$record->id)
                ]);

                return $btn;
            })
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.master.client.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.master.client.create');
    }

    public function store(ClientRequest $request)
    {
        // return response($request->file(), 422);
        $record = new Client();
        if(isset($request->file)){
            $temp = $request->logo->storeAs('logo', md5($request->logo->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$request->logo->getClientOriginalExtension(), 'public');
            $record->filename = $request->logo->getClientOriginalName();
            $record->fileurl = $temp;
        }
        $record->fill($request->all());
        $record->save();

        auth()->user()->storeLog('Master Klien', 'Menginput Data Klien '.$record->name, $record->id);

        return response([
            'status' => true
        ]);
    }

    public function edit(Client $client)
    {
        return $this->render('modules.master.client.edit', [
            'record' => $client        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(Request $request, Client $client)
    {
        if(isset($request->file)){
            // if(file_exists(storage_path().'/app/public/'.$client->fileurl))
            // {
            //     unlink(storage_path().'/app/public/'.$client->fileurl);
            // }
            
            $temp = $request->logo->storeAs('logo', md5($request->logo->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$request->logo->getClientOriginalExtension(), 'public');
            $client->filename = $request->logo->getClientOriginalName();
            $client->fileurl = $temp;
        }
        $client->fill($request->all());
        $client->save();

        auth()->user()->storeLog('Master Klien', 'Mengedit Client '.$client->name, $client->id);
        return response([
            'status' => true
        ]);
    }


    public function destroy(Client $client)
    {
        $client->delete();
        auth()->user()->storeLog('Master Klien', 'Menghapus Client '.$client->name);

        return response([
            'status' => true,
        ]);
    }
}
