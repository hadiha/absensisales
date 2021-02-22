<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\LaporanRequest;
use App\Models\Kehadiran\Monitoring;
use App\Models\Main\DataFile;
use App\Models\Main\Laporan;
/* Validation */
// use App\Http\Requests\Konfigurasi\LaporanRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Exception;
use Hash;

class LaporanController extends Controller
{
    protected $link = 'barang/';
    protected $perms = 'main-barang';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Barang");
        $this->setModalSize("tiny");
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
        $records = Laporan::when($name = request()->name, function ($q) use ($name) {
                        return $q->where('created_by', $name);
                    })
                    ->when($barang = request()->barang, function ($q) use ($barang) {
                        return $q->where('barang_id', $barang);
                    })
                    ->when($from = request()->from, function ($q) use ($from) {
                        return $q->whereBetween('tanggal',[Carbon::parse($from)->format('Y-m-d'), Carbon::parse(request()->to)->format('Y-m-d') ]);
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
            ->editColumn('foto', function ($record) {
                return $record->files->count() .' Foto';
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->editColumn('created_by', function ($record) {
                return $record->creator->name;
            })
            ->addColumn('action', function ($record) use ($link){
                $btn = '';
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'class'   => 'teal icon custom',
                    'label'   => '<i class="file text icon"></i>',
                    'tooltip' => 'Detail',
                    'datas' => [
                        'url'  => url($link.$record->id),
                        'modalSize' => 'small'
                    ],
                    // 'url'  => url($link.$record->id)
                ]);
                if(auth()->user()->can($this->perms.'-edit')){
                    $btn .= $this->makeButton([
                        'type' => 'modal',
                        'datas' => [
                            'id' => $record->id
                        ],
                        'id'   => $record->id
                    ]);
                }
                // Delete
                if(auth()->user()->can($this->perms.'-delete')){
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
        return $this->render('modules.main.barang.index');
    }

    public function create()
    {
        return $this->render('modules.main.barang.create');
    }

    public function store(LaporanRequest $request)
    {
        $record = new Laporan();
        $record->fill($request->all());
        $record->save();

        auth()->user()->storeLog('Laporan Barang', 'Membuat Laporan Barang', $record->id);
        return response([
            'status' => true
        ]);
    }

    public function edit(Laporan $barang)
    {
        return $this->render('modules.main.barang.edit', [
            'record' => $barang,
            ]);
        }
        
    public function show(Laporan $barang)
    {
        return $this->render('modules.main.barang.detail', [
            'record' => $barang,
        ]);
    }

    public function update(LaporanRequest $request, Laporan $barang)
    {
        // dd($request->all());
        if(isset($request->filespath)){
            if(count($request->filespath) > 0){
                        foreach ($request->filespath as $key => $value) {
                                if($request->filename[$key])
                                {
                                    $saveFile['filename'] = $request->filename[$key];
                                }

                                $saveFile['fileurl'] = $value;
                                $saveFile['barang_id'] = $barang->id;

                                $recordFile = new DataFile();
                                if(isset($request->fileid[$key]))
                                {
                                    $recordFile = DataFile::where('fileurl', $value)->where('barang_id', $barang->id)->first();
                                }
                                $recordFile->fill($saveFile);
                                $recordFile->save();

                                $fileid[] = $recordFile->id;
                        }

                        $notExist = DataFile::whereNotIn('id', $fileid)->where('barang_id', $barang->id)->get();

                        if($notExist->count() > 0)
                        {
                                foreach($notExist as $ne)
                                {
                                    if(file_exists(storage_path().'/app/public/'.$ne->fileurl))
                                    {
                                            unlink(storage_path().'/app/public/'.$ne->fileurl);
                                    }
                                    $ne->delete();
                                }
                        }
                }
        }else{
                $this->validate($request, [
                    'fileupload' => 'required',
                ],[
                    'fileupload.required' => 'References Files is required.',
                ]);
        }

        $barang->fill($request->all());
        $barang->save();

        auth()->user()->storeLog('Laporan Barang', 'Mengupdate Laporan Barang', $barang->id);

        return response([
            'status' => true
        ]);
    }

    public function destroy(Laporan $barang)
    {
        $barang->delete();
        auth()->user()->storeLog('Laporan Barang', 'Menghapus Laporan Barang');

        return response([
            'status' => true,
        ]);
    }

    public function fileUpload(Request $request)
    {
        try {
            $url = [];
            if($request->file)
            {
                $path = $request->file->storeAs('fileupload', md5($request->file->getClientOriginalName().Carbon::now()->format('Ymdhisu')).'.'.$request->file->getClientOriginalExtension(), 'public');

                return response([
                    'status' => true,
                    'filepath' => $path,
                    'filename' => $request->file->getClientOriginalName(),
                ]);
            }

        } catch (Exception $e) {
            return response([
                'status' => false,
                'errors' => $e
            ]);
        }
        return response([
            'status' => false,
        ]);
    }

    public function unlink(Request $request)
    {
        try {
            if(file_exists(storage_path().'/app/public/'.$request->path))
            {
                unlink(storage_path().'/app/public/'.$request->path);
            }
        } catch (Exception $e) {
              return response([
                'status' => false,
                'errors' => $e
            ]);
        }

        return response([
            'status' => true,
        ]);
    }
}
