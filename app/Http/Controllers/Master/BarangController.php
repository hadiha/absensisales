<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\BarangRequest;
/* Validation */
// use App\Http\Requests\Konfigurasi\BarangRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon;
use Hash;

class BarangController extends Controller
{
    protected $link = 'master/barang/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Data Barang");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Data Barang' => '#']);

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
                'label' => 'Nama Barang',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'kode',
                'name' => 'kode',
                'label' => 'Kode',
                'searchable' => false,
                'sortable' => true,
            ],
            // [
            //     'data' => 'jumlah',
            //     'name' => 'jumlah',
            //     'label' => 'Jumlah',
            //     'searchable' => false,
            //     'sortable' => true,
            //     'className' => "center aligned",
            //     'width' => '120px',
            // ],
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
        $records = Barang::when($kode = request()->kode, function ($q) use ($kode) {
                        return $q->where('kode', 'like', '%' . $kode . '%');
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
        return $this->render('modules.master.barang.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.master.barang.create');
    }

    public function store(BarangRequest $request)
    {
        $record = new Barang();
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function edit(Barang $barang)
    {
        return $this->render('modules.master.barang.edit', [
            'record' => $barang        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(Request $request, Barang $barang)
    {
        $barang->fill($request->all());
        $barang->save();

        return response([
            'status' => true
        ]);
    }


    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response([
            'status' => true,
        ]);
    }
}
