<?php

namespace App\Http\Controllers\Main;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\DocRequest;
use App\Models\Main\DocFile;
use App\Models\Main\Documentasi;
/* Validation */
// use App\Http\Requests\Konfigurasi\DocRequest;

/* Models */
use App\Models\Master\Barang;

/* Libraries */
use DataTables;
use Carbon\Carbon;
use Exception;
use Hash;

class DocumentasiController extends Controller
{
    protected $link = 'documentasi/';
    protected $perms = 'main-documentasi';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Dokumentasi");
        $this->setModalSize("tiny");
        $this->setBreadcrumb(['Dokumentasi' => '#']);

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
                'data' => 'area_id',
                'name' => 'area_id',
                'label' => 'Area',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'date',
                'name' => 'date',
                'label' => 'Tanggal',
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
        $records = Documentasi::when($date = request()->date, function ($q) use ($date) {
                        return $q->where('date', $date);
                    })
                    ->when($area = request()->area, function ($q) use ($area) {
                        $q->whereHas('area', function($w) use ($area){
                                return $w->where('id', $area);
                        });
                    })
                    ->select('*');
        if(auth()->user()->client_id != null){
                return $records->where('client_id', auth()->user()->client_id);
        }
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->editColumn('area_id', function ($record) {
                return $record->area->name;
            })
            ->editColumn('date', function ($record) {
                return Carbon::parse($record->date)->format('d/m/Y');
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
                        'modalSize' => 'medium'
                    ],
                    // 'url'  => url($link.$record->id)
                ]);
                // if(auth()->user()->can($this->perms.'-edit')){
                    // $btn .= $this->makeButton([
                    //     'type' => 'modal',
                    //     'datas' => [
                    //         'id' => $record->id
                    //     ],
                    //     'id'   => $record->id
                    // ]);
                // }
                // Delete
                // if(auth()->user()->can($this->perms.'-delete')){
                    // $btn .= $this->makeButton([
                    //     'type' => 'delete',
                    //     'id'   => $record->id,
                    //     'url'   => url($link.$record->id)
                    // ]);
                // }
                return $btn;
            })
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.main.dokumentasi.index');
    }

    public function create()
    {
        return $this->render('modules.main.dokumentasi.create');
    }

    public function store(DocRequest $request)
    {
        $record = new Documentasi();
        $record->fill($request->all());
        $record->save();

        auth()->user()->storeLog('Dokumentasi Barang', 'Membuat Dokumentasi Barang', $record->id);
        return response([
            'status' => true
        ]);
    }

    public function edit(Documentasi $documentasi)
    {
        return $this->render('modules.main.dokumentasi.edit', [
            'record' => $documentasi,
            ]);
        }
        
    public function show(Documentasi $documentasi)
    {
        return $this->render('modules.main.dokumentasi.detail', [
            'record' => $documentasi,
        ]);
    }

    public function update(DocRequest $request, Documentasi $documentasi)
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
                                $saveFile['barang_id'] = $documentasi->id;

                                $recordFile = new DocFile();
                                if(isset($request->fileid[$key]))
                                {
                                    $recordFile = DocFile::where('fileurl', $value)->where('barang_id', $documentasi->id)->first();
                                }
                                $recordFile->fill($saveFile);
                                $recordFile->save();

                                $fileid[] = $recordFile->id;
                        }

                        $notExist = DocFile::whereNotIn('id', $fileid)->where('barang_id', $documentasi->id)->get();

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
        // }else{
        //         $this->validate($request, [
        //             'fileupload' => 'required',
        //         ],[
        //             'fileupload.required' => 'References Files is required.',
        //         ]);
        }

        $documentasi->fill($request->all());
        $documentasi->save();

        auth()->user()->storeLog('Dokumentasi Barang', 'Mengupdate Dokumentasi Barang', $documentasi->id);

        return response([
            'status' => true
        ]);
    }

    public function destroy(Documentasi $documentasi)
    {
        $documentasi->delete();
        auth()->user()->storeLog('Dokumentasi Barang', 'Menghapus Dokumentasi Barang');

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
