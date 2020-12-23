<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\BarangRequest;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;
/* Validation */
// use App\Http\Requests\Konfigurasi\BarangRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon;
use Hash;

class RekapController extends Controller
{
    protected $link = 'kehadiran/rekap/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Rekap Kehadiran");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Kehadiran' => '#', 'Rekap' => '#']);

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
                'data' => 'username',
                'name' => 'username',
                'label' => 'Nama',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'area',
                'name' => 'area',
                'label' => 'Area',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'hadir',
                'name' => 'hadir',
                'label' => 'Hadir',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'izin',
                'name' => 'izin',
                'label' => 'Izin',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'sakit',
                'name' => 'sakit',
                'label' => 'Sakit',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'tk',
                'name' => 'tk',
                'label' => 'Tanpa Keterangan',
                'searchable' => false,
                'sortable' => true,
            ],
        ]);
    }

    public function grid(Request $request)
    {
        $records = User::when($name = request()->name, function ($q) use ($name) {
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
            ->editColumn('area', function ($record) {
                return $record->status;
            })
            ->editColumn('hadir', function ($record) {
                return $record->hadir();
            })
            ->editColumn('sakit', function ($record) {
                return $record->sakit();
            })
            ->editColumn('izin', function ($record) {
                return $record->izin();
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
        return $this->render('modules.main.rekap.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.main.rekap.create');
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
        return $this->render('modules.main.rekap.edit', [
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
