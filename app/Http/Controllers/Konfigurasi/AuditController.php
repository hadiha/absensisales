<?php

namespace App\Http\Controllers\Konfigurasi;

use DataTables;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Authentication\AuditTrail;

class AuditController extends Controller
{
    protected $link = 'audit';

    public function __construct(){
        $this->setLink($this->link);
        $this->setTitle('Audit Trail');
        // $this->setSubtitle('Catatan Penggunaan Aplikasi');
        $this->setBreadcrumb([ 'Audit Trail' => '#']);
        $this->setModalSize('#mediumModal'); // #smallModal, #mediumModal, #largeModal, #xlModal
        // $this->setPerms('settings.roles');
        // Header Grid Datatable
        $this->setTableStruct([
            [
                'data' => 'num',
                'name' => 'num',
                'label' => '#',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-color',
                'width' => '20px',
            ],
            /* --------------------------- */
            [
                'data' => 'user.name',
                'name' => 'user.name',
                'label' => 'Name',
                'sortable' => true,
                'className' => 'text-color',
            ],
            [
                'data' => 'module',
                'name' => 'module',
                'label' => 'Module',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'label' => 'Action',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
            ],
            [
                'data' => 'ip',
                'name' => 'ip',
                'label' => 'IP Address',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'browser',
                'name' => 'browser',
                'label' => 'Browser',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Time',
                'orderable' => false,
                'searchable' => false,
            ],
            // [
            //     'data' => 'act',
            //     'name' => 'act',
            //     'label' => '',
            //     'searchable' => false,
            //     'sortable' => false,
            //     'width' => '50px',
            //     'className' => 'text-right'
            // ]
        ]);
    }

    public function grid()
    {
        $record = AuditTrail::with('user')
                            ->when(!request()->has('order'), function($q){
                                $q->orderBy('created_at', 'desc');
                            })
                            ->when(request()->has('name'), function ($q) {
                                $q->whereHas('user', function($w){
                                    $w->where('name', 'like', '%' . request()->name . '%');
                                });
                            })
                            ->when(request()->has('module'), function ($q) {
                                $q->where('module', 'like', '%' . request()->module . '%');
                            })
                            ->when(request()->has('action') && request()->action != '', function ($q) {
                                $q->where('action', request()->action);
                            });
                            
        if(auth()->user()->roles()->first()->name != 'admin'){
            $record->where('created_by', auth()->user()->id)->get();
        }

        $datatables = DataTables::of($record)
            ->editColumn('num', function ($record) {
                return request()->start;
            })
            // ->editColumn('module', function ($record) {
            //     $exp = explode('.', $record->module);
            //     return ucwords(implode(' > ', $exp));
            // })
            ->editColumn('action', function ($record) {
                $maps = [
                    'login' => 'success',
                    'logout' => 'danger',
                    'access' => 'info',
                    'create' => 'success',
                    'update' => 'warning',
                    'delete' => 'danger',
                    //primary, info, success, warning, danger, secondary, light, dark
                ];

                return '<span class="badge badge-'.(array_key_exists($record->action, $maps) ? $maps[$record->action] : 'primary').' text-uppercase">
                            '.$record->action.'
                        </span>';

                return ucfirst($record->action);
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->rawColumns(['act', 'action'])
            ->make(true);

        return $datatables;
    }

    public function index(){
        return $this->render('modules.konfigurasi.audits.index');
    }

    public function show($id){
    }

    public function create(){
    }

    public function store(Request $request){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
    }

    public function destroy($id){
    }
}
