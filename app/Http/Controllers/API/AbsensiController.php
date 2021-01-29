<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Main\AbsensiRequest;
use App\Models\Authentication\Notification;
use App\Models\Main\Absensi;
use App\Transformers\MainResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends ApiController
{
    public function index()
    {
        $records = Absensi::forGrid()
                        ->paginate(request()->per_page ?: 10)->appends(request()->query());

        $this->loadIfExists($records);

        return MainResource::collection($records);
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

    public function show(Absensi $absensi)
    {
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
