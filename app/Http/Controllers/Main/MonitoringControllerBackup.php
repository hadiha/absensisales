<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\AbsensiRequest;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;
/* Validation */
// use App\Http\Requests\Konfigurasi\BarangRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Hash;
use PDF;

class MonitoringController extends Controller
{
    protected $link = 'kehadiran/monitoring/';
    protected $perms = 'main-monitoring';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
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
                'data' => 'name',
                'name' => 'pegawai_id',
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
                'data' => 'absen.keterangan',
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
        $records = User::when($name = request()->name, function ($q) use ($name) {
                        $q->where('name', 'like', '%' . $name . '%');
                    })
                    ->when($area = request()->area, function ($q) use ($area) {
                        $q->whereHas('salesarea', function($w) use ($area){
                            return $w->where('area_id', $area);
                        });
                    })
                    ->with(['absen' => function($q){
                        $q->whereDate('date_in', Carbon::parse(request()->date)->format('Y-m-d'));        
                    }])
                    ->whereHas('roles', function($r){
                        $r->where('name', 'sales');
                    })
                    ->whereHas('salesarea', function($r){
                        $r->whereNotNull('area_id');
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
            // ->editColumn('area', function ($record) {
            //     return $record->user->area;
            // })
            ->editColumn('tanggal', function ($record) {
                return Carbon::parse(request()->date)->format('d/m/Y');
                // return $record->absen ? Carbon::parse($record->absen->date_in)->format('d/m/Y') : '-';
            })
            ->editColumn('time_in', function ($record) {
                return $record->absen ? Carbon::parse($record->absen->date_in)->format('H:i') : '-';
            })
            ->editColumn('time_out', function ($record) {
                return $record->absen ? ($record->absen->date_out != null ? Carbon::parse($record->absen->date_out)->format('H:i') : '-') : '-';
            })
            ->editColumn('status', function ($record) {
                return $record->absen ? $record->absen->statusLabel() : '<a class="ui small teal tag label">Belum Absen</a>' ;
            })
            ->editColumn('koordinat', function ($record) {
                return $record->absen ? ($record->absen->latitude ? $record->absen->latitude .' , '.$record->absen->longitude : '-') : '-';
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

                if(auth()->user()->can($this->perms.'-edit')){
                    if($record->absen == null){
                        $date = Carbon::parse(request()->date)->format('d/m/Y');
                        $btn .= $this->makeButton([
                            'type' => 'modal',
                            'class'   => 'teal icon custom',
                            'label'   => '<i class="edit outline icon"></i>',
                            'tooltip' => 'Tambah',
                            'id'    => $record->id,
                            'datas' => [
                                'url'  => url($link.'add/'.$record->id.'?date='.$date),
                            ],
                        ]);
                    } else {                    
                        $btn .= $this->makeButton([
                            'type' => 'modal',
                            'datas' => [
                                'id' => $record->absen->id
                            ],
                            'id'   => $record->absen->id
                        ]);
                    }
                }
                // if(auth()->user()->can($this->perms.'-delete')){
                    // Delete
                    // $btn .= $this->makeButton([
                    //     'type' => 'delete',
                    //     'id'   => $record->id,
                    //     'url'   => url($link.$record->id)
                    // ]);
                // }

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

    public function add($id)
    {
        // dd(request()->date);
        $user = User::find($id);

        return $this->render('modules.main.monitoring.edit', [
            'record'    => $user,
            'type'      => 'add',
            'tanggal'   => request()->date   
        ]);
    }

    public function store(Request $request)
    {
        if($request->status = 'hadir'){
            $request->validate([
                'time_in' => 'required'
            ], [
                'time_in.required' => 'Jam Masuk Harus diisi'
            ]);
        }
        
        $record = new Absensi();
        $record->fill($request->except(['date_in', 'date_out']));
        if($request->time_in != null){
            $in = Carbon::createFromFormat('d/m/Y G:i', $request->tanggal.' '.$request->time_in);
            $record->date_in = $in;
        }
        if($request->time_out != null){
            $out = Carbon::createFromFormat('d/m/Y G:i', $request->tanggal.' '.$request->time_out);
            $record->date_out = $out;
        }

        $record->save();

        auth()->user()->storeLog('Monitoring', 'Membuat Data Absensi di Monitoring', $record->id);

        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $absen = Absensi::find($id);
        return $this->render('modules.main.monitoring.edit', [
            'record' => $absen,
            'type'   => 'edit'       
        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(AbsensiRequest $request, Absensi $monitoring)
    {
       return $monitoring->updateByRequest($request);
    }


    public function destroy(Absensi $monitoring)
    {
        $monitoring->delete();

        auth()->user()->storeLog('Monitoring', 'Menghapus data Monitoring', $this->id);

        return response([
            'status' => true,
        ]);
    }

    public function export(Request $request)
    {
        // return response($request->all(), 422);
        $records = User::when($name = request()->name, function ($q) use ($name) {
                        $q->where('name', 'like', '%' . $name . '%');
                    })
                    ->when($area = request()->area, function ($q) use ($area) {
                        $q->whereHas('salesarea', function($w) use ($area){
                            return $w->where('area_id', $area);
                        });
                    })
                    ->with(['absen' => function($q){
                        $q->whereDate('date_in', Carbon::parse(request()->date)->format('Y-m-d'));        
                    }])->get();
        $tanggal = Carbon::parse(request()->date)->format('d F Y');

        $pdf = PDF::loadView('modules.main.monitoring.export-pdf', ['record'=>$records, 'tanggal' => $tanggal])
        ->setPaper('a4', 'potrait')->setOptions(
            [
                'defaultFont' => 'times-roman',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true
            ]
        );
        return $pdf->stream(str_replace('/','-','Monitoring').'.pdf');
    }
}
