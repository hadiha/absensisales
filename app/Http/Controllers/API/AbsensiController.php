<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Main\AbsensiRequest;
use App\Models\Authentication\Notification;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;
use App\Transformers\MainResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends ApiController
{
    public function index()
    {
        $records = User::withCount([
            'absensiHadir' => function($q){
                return $q->whereMonth('created_at', Carbon::createFromFormat('m', request()->month)->format('m'))
                ->whereYear('created_at', Carbon::createFromFormat('Y', request()->year)->format('Y'));
            }, 
            'absensiSakit' => function($q){
                return $q->whereMonth('created_at', Carbon::createFromFormat('m', request()->month)->format('m'))
                ->whereYear('created_at', Carbon::createFromFormat('Y', request()->year)->format('Y'));
            },
            'absensiIzin' => function($q){
                return $q->whereMonth('created_at', Carbon::createFromFormat('m', request()->month)->format('m'))
                ->whereYear('created_at', Carbon::createFromFormat('Y', request()->year)->format('Y'));
            },
            ])
            ->with(['absensi' => function($w){
                return $w->whereMonth('date_in', Carbon::createFromFormat('m', request()->month)->format('m'))
                        ->whereYear('date_in', Carbon::createFromFormat('Y', request()->year)->format('Y'));
            }])->find(auth()->id());

            return response()->json([
                'record'    => $records->append('absensi_alfa_count')
            ]);
        // return response($records->append('absensi_alfa_count'));

        // $records = Absensi::forGrid()
        //                 ->paginate(request()->per_page ?: 10)->appends(request()->query());

        // $this->loadIfExists($records);

        // return MainResource::collection($records);
    }

    public function create()
    {
        return view('main::monitoring.create');
    }

    public function store(Request $request)
    {
        return Absensi::createByRequest($request);
    }

    public function out(Request $request)
    {
        return Absensi::createOut($request);
    }

    public function storePengajuan(Request $request)
    {
        return Absensi::pengajuan($request);
    }

    public function show($id)
    {
        $absensi = Absensi::find($id);

        $this->loadIfExists($absensi);
        return new MainResource($absensi);
    }

    public function edit($id)
    {
        return view('main::monitoring.create');
    }

    public function update(Request $request, Absensi $absensi)
    {
        // return $absensi->updateByRequest($request);
    }

    public function destroy(Absensi $absensi)
    {
        // return $absensi->deleteByRequest();
    }

    public function getNotif()
    {
        if(Auth::check()){
            if(auth()->user()->roles->first()->name !== 'sales'){
                $notif = Notification::whereNull('read_at')->orderBy('created_at', 'desc')->get();
            } else {
                $notif = Notification::whereNotNull('read_at')->orderBy('created_at', 'desc')->get();
            }
        };

        return response([
            'record' => $notif->take(10),
            'lengths' => count($notif),
        ]);
    }
   
    public function getAllNotif()
    {
        if(auth()->user()->roles->first()->name !== 'sales'){
            $notif = Notification::with('user')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $notif = Notification::whereNotNull('read_at')->orderBy('created_at', 'desc')->paginate(10);
        }

        return response([
            'record' => $notif,
        ]);
    }

}
