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
use Carbon\Carbon;
use Hash;
use PDF;

class RekapController extends Controller
{
    protected $link = 'kehadiran/rekap/';
    protected $perms = 'main-rekap';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
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
                'data' => 'name',
                'name' => 'name',
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
            // [
            //     'data' => 'cuti',
            //     'name' => 'cuti',
            //     'label' => 'Cuti',
            //     'searchable' => false,
            //     'sortable' => true,
            // ],
            // [
            //     'data' => 'tk',
            //     'name' => 'tk',
            //     'label' => 'Tanpa Keterangan',
            //     'searchable' => false,
            //     'sortable' => true,
            // ],
        ]);
    }

    public function grid(Request $request)
    {
        $records = User::when($area = request()->area, function ($q) use ($area) {
                        $q->whereHas('salesarea', function($w) use ($area){
                            return $w->where('area_id', $area);
                        });
                    })
                    ->when($from = request()->from, function ($q) use ($from){
                        $q->with(['absensi' => function($w) use ($from){
                            return $w->whereMonth('date_in', Carbon::parse($from)->format('n'))
                                    ->whereYear('date_in', Carbon::parse($from)->format('Y'));
                        }]);
                    })
                    ->when(!is_null(auth()->user()->client_id), function($e){
                        return $e->where('client_id', auth()->user()->client_id);
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
                return $record->area;
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
            ->editColumn('cuti', function ($record) {
                return $record->cuti();
            })
            // ->editColumn('tk', function ($record) {
            //     return $record->alfa(request()->from);
            // })
            
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

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
    //    
    }

    public function show($id)
    {
    //   
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    
    public function export(Request $request)
    {
        // return response($request->all(), 422);
       

        if(auth()->user()->client_id != null){
            $records = User::where('client_id', auth()->user()->client_id)->when($area = request()->area, function ($q) use ($area) {
                        $q->whereHas('salesarea', function($w) use ($area){
                            return $w->where('area_id', $area);
                        });
                    })
                    ->when($from = request()->from, function ($q) use ($from){
                        $q->with(['absensi' => function($w) use ($from){
                            return $w->whereMonth('date_in', Carbon::parse($from)->format('n'))
                                    ->whereYear('date_in', Carbon::parse($from)->format('Y'));
                        }]);
                    })
                    ->get();
        } else {
            $records = User::when($area = request()->area, function ($q) use ($area) {
                $q->whereHas('salesarea', function($w) use ($area){
                    return $w->where('area_id', $area);
                });
            })
            ->when($from = request()->from, function ($q) use ($from){
                $q->with(['absensi' => function($w) use ($from){
                    return $w->whereMonth('date_in', Carbon::parse($from)->format('n'))
                            ->whereYear('date_in', Carbon::parse($from)->format('Y'));
                }]);
            })
            ->get();
        }

        $tanggal = Carbon::parse(request()->from)->format('F Y');

        $pdf = PDF::loadView('modules.main.rekap.export-pdf', ['record' => $records, 'tanggal'=>$tanggal])
        ->setPaper('a4', 'potrait')->setOptions(
            [
                'defaultFont' => 'times-roman',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true
            ]
        );
        return $pdf->stream(str_replace('/','-','Rekap').'.pdf');
    }
}
