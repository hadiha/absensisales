<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\AbsensiRequest;
use App\Models\Main\Absensi;
/* Validation */
// use App\Http\Requests\Konfigurasi\BarangRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Hash;

class MonitoringController extends Controller
{
    protected $link = 'kehadiran/monitoring/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Monitoring Kehadiran");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Kehadiran' => '#', 'Monitoring' => '#']);

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
                'data' => 'user.username',
                'name' => 'pegawai_id',
                'label' => 'Nama',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'koordinat',
                'name' => 'kode',
                'label' => 'Area',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'tanggal',
                'name' => 'tanggal',
                'label' => 'Tanggal',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'time_in',
                'name' => 'time_in',
                'label' => 'Jam Masuk',
                'searchable' => false,
                'className' => 'text-center',
                'sortable' => true,
            ],
            [
                'data' => 'time_out',
                'name' => 'time_out',
                'label' => 'Jam Keluar',
                'searchable' => false,
                'className' => 'text-center',
                'sortable' => true,
            ],
            [
                'data' => 'koordinat',
                'name' => 'koordinat',
                'label' => 'Koordinat',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'label' => 'Status',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'keterangan',
                'name' => 'keterangan',
                'label' => 'Keterangan',
                'searchable' => false,
                'sortable' => true,
            ],
            // [
            //     'data' => 'created_at',
            //     'name' => 'created_at',
            //     'label' => 'Dibuat Pada',
            //     'searchable' => false,
            //     'sortable' => true,
            //     'width' => '120px',
            // ],
            // [
            //     'data' => 'created_by',
            //     'name' => 'created_by',
            //     'label' => 'Dibuat Oleh',
            //     'searchable' => false,
            //     'sortable' => true,
            //     'width' => '120px',
            // ],
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
        $records = Absensi::with('user')->forGrid()->select('*');
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->editColumn('tanggal', function ($record) {
                return Carbon::parse($record->date_in)->format('d/m/Y');
            })
            ->editColumn('time_in', function ($record) {
                return Carbon::parse($record->date_in)->format('H:i');
            })
            ->editColumn('time_out', function ($record) {
                return Carbon::parse($record->date_out)->format('H:i');
            })
            ->editColumn('status', function ($record) {
                return $record->statusLabel();
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
            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.main.monitoring.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.main.monitoring.create');
    }

    public function store(AbsensiRequest $request)
    {
        $record = new Absensi();
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function edit(Absensi $monitoring)
    {
        return $this->render('modules.main.monitoring.edit', [
            'record' => $monitoring        
        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(AbsensiRequest $request, Absensi $monitoring)
    {
        $monitoring->fill($request->all());
        $monitoring->save();

        return response([
            'status' => true
        ]);
    }


    public function destroy(Absensi $monitoring)
    {
        $monitoring->delete();

        return response([
            'status' => true,
        ]);
    }
}
