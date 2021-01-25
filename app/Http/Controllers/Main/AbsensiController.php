<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Authentication\Notification;
use App\Models\Authentication\User;
/* Validation */
// use App\Http\Requests\Konfigurasi\Request;

/* Models */
use App\Models\Main\Absensi;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    protected $link = 'absensi/';
    // protected $perms = 'main-absensi';

    function __construct()
    {
        $this->setLink($this->link);
        // $this->setPerms($this->perms);
        $this->setTitle("Absensi");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Absensi' => '#']);

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
                'data' => 'user.name',
                'name' => 'pegawai_id',
                'label' => 'Nama',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'user.area',
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
            // [
            //     'data' => 'action',
            //     'name' => 'action',
            //     'label' => 'Aksi',
            //     'searchable' => false,
            //     'sortable' => false,
            //     'className' => "center aligned",
            //     'width' => '100px',
            // ]
        ]);
    }

    public function grid(Request $request)
    {
        $records = Absensi::with('user')
                ->when($date = request()->date, function ($q) use ($date) {
                    $q->whereDate('created_at', Carbon::parse($date)->format('Y-m-d'));
                })
                ->where('pegawai_id', auth()->user()->id)->select('*');
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
                return $record->date_in != null ? Carbon::parse($record->date_in)->format('d/m/Y') : Carbon::parse($record->created_at)->format('d/m/Y');
            })
            ->editColumn('time_in', function ($record) {
                return $record->date_in != null ? Carbon::parse($record->date_in)->format('H:i') : '-';
            })
            ->editColumn('time_out', function ($record) {
                return $record->date_out != null ? Carbon::parse($record->date_out)->format('H:i') : '-';
            })
            ->editColumn('status', function ($record) {
                return $record->statusLabel();
            })
            ->editColumn('koordinat', function ($record) {
                return $record->latitude ? $record->latitude .' , '.$record->longitude : '-';
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

                // if(auth()->user()->can($this->perms.'-edit')){
                                    
                        $btn .= $this->makeButton([
                            'type' => 'modal',
                            'datas' => [
                                'id' => $record->id
                            ],
                            'id'   => $record->id
                        ]);
                // }
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
        $record = Absensi::where('pegawai_id', auth()->user()->id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
        // dd($record);
        return $this->render('modules.main.absensi.index',['record' => $record]);
    }

    public function create()
    {
        return $this->render('modules.main.absensi.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $record = new Absensi();
            $record->pegawai_id = $request->user_id;
            $record->date_in = Carbon::now();
            $record->status = $request->status;
            $record->save();

            auth()->user()->storeLog('Absensi', 'Menginput Jam Masuk', $record->id);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal Menyimpan data',
                // 'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data'    => $record
        ]);
    }

    public function storeOut(Request $request)
    {
        return Absensi::createOut($request);
    }

    public function storePengajuan(Request $request)
    {
        return Absensi::pengajuan($request);
    }

    public function edit(Absensi $absensi)
    {
        return $this->render('modules.main.absensi.edit', [
            'record' => $absensi,
            ]);
        }
        
    public function show(Absensi $absensi)
    {
        $notif = Notification::where('notifiable_id', $absensi->id)->first();
        $notif->read_at = Carbon::now();
        $notif->save();

        return $this->render('modules.main.absensi.detail', [
            'record' => $absensi,
        ]);
    }

    public function update(Request $request, Absensi $absensi)
    {
        
    }

    public function destroy(Absensi $absensi)
    {
       
    }
    
    public function getNotif()
    {
        if(Auth::check()){
            if(auth()->user()->roles->first()->name !== 'sales'){
                $notif = Notification::whereNull('read_at')->get();
            } else {
                $notif = Notification::whereNotNull('read_at')->get();
            }
        };

        return response([
            'record' => $notif,
            'lengths' => count($notif),
        ]);
    }
   
    public function getAllNotif()
    {
        if(auth()->user()->roles->first()->name !== 'sales'){
            $notif = Notification::with('user')->get();
        } else {
            $notif = Notification::whereNotNull('read_at')->get();
        }
        $this->setTitle("All Notification");

        return $this->render('modules.main.absensi.allnotif', [
            'record' => $notif,
        ]);
    }



}
