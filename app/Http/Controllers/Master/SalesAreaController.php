<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\Master\AreaRequest;
use App\Http\Requests\Master\SalesAreaRequest;
use App\Models\Authentication\User;
/* Models */
use App\Models\Master\Area;
use App\Models\Master\SalesArea;
/* Libraries */
use DataTables;
use Carbon;
use Hash;

class SalesAreaController extends Controller
{
    protected $link = 'master/sales-area/';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Data Sales Area");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Data Sales Area' => '#']);

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
                'name' => 'user_id',
                'label' => 'Nama Sales',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'area.name',
                'name' => 'area_id',
                'label' => 'Nama Area',
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
        $records = SalesArea::with('user','area')
        ->when($sales = request()->sales, function ($q) use ($sales) {
            return $q->whereHas('user', function($w) use ($sales){
                $w->where('username', 'like', '%'.$sales.'%');
            });
        })
        ->when($area = request()->area, function ($q) use ($area) {
            return $q->whereHas('area', function($w) use ($area){
                $w->where('name', 'like', '%'.$area.'%');
            });
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
        return $this->render('modules.master.salesarea.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.master.salesarea.create');
    }

    public function store(SalesAreaRequest $request)
    {
        $record = new SalesArea();
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function edit(SalesArea $sales_area)
    {
        $user = User::all();
        $area = Area::all();

        return $this->render('modules.master.salesarea.edit', [
            'record' => $sales_area,
            'user' => $user,
            'area' => $area
        ]);
    }

    public function show($id)
    {
    //   
    }

    public function update(Request $request, SalesArea $sales_area)
    {
        $sales_area->fill($request->all());
        $sales_area->save();

        return response([
            'status' => true
        ]);
    }


    public function destroy(Salesarea $sales_area)
    {
        $sales_area->delete();

        return response([
            'status' => true,
        ]);
    }
}
