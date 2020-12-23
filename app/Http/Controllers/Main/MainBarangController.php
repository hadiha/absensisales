<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\LaporanRequest;
use App\Models\Kehadiran\Monitoring;
use App\Models\Main\MainBarang;
/* Validation */
// use App\Http\Requests\Konfigurasi\LaporanRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Hash;

class MainBarangController extends Controller
{
    protected $link = 'barang/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Barang");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Barang' => '#']);

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
                'data' => 'barang_id',
                'name' => 'barang_id',
                'label' => 'Nama Barang',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'kode',
                'name' => 'kode',
                'label' => 'Kode Barang',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'tanggal',
                'name' => 'tanggal',
                'label' => 'Tanggal Laporan',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'stock',
                'name' => 'stock',
                'label' => 'Stock',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'sale_in',
                'name' => 'sale_in',
                'label' => 'Sale In',
                'searchable' => false,
                'className' => 'text-center',
                'sortable' => true,
            ],
            [
                'data' => 'sale_out',
                'name' => 'sale_out',
                'label' => 'Sale Out',
                'searchable' => false,
                'className' => 'text-center',
                'sortable' => true,
            ],
            [
                'data' => 'foto',
                'name' => 'foto',
                'label' => 'Foto',
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
        $records = MainBarang::when($name = request()->name, function ($q) use ($name) {
                        return $q->where('pegawai_id', $name);
                    })
                    ->when($area = request()->area, function ($q) use ($area) {
                        return $q->where('pegawai_id', $area);
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
            ->editColumn('barang_id', function ($record) {
                return $record->item->name;
            })
            ->editColumn('kode', function ($record) {
                return $record->item->kode;
            })
            ->editColumn('sale_in', function ($record) {
                return $record->sale_in;
            })
            ->editColumn('time_out', function ($record) {
                return $record->sale_out;
            })
            ->editColumn('tanggal', function ($record) {
                return Carbon::parse($record->tanggal)->format('d/m/Y');
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
        return $this->render('modules.main.barang.index');
    }

    public function create()
    {
        return $this->render('modules.main.barang.create');
    }

    public function store(LaporanRequest $request)
    {
        $record = new MainBarang();
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function edit(MainBarang $barang)
    {
        return $this->render('modules.main.barang.edit', [
            'record' => $barang,
        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(LaporanRequest $request, MainBarang $barang)
    {
        $barang->fill($request->all());
        $barang->save();

        return response([
            'status' => true
        ]);
    }


    public function destroy(MainBarang $barang)
    {
        $barang->delete();

        return response([
            'status' => true,
        ]);
    }
}
