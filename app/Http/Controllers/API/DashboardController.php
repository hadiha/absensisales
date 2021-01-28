<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;
use App\Transformers\MainResource;
use Carbon\CarbonPeriod;

class DashboardController extends ApiController
{
    public function index(Request $request)
    {
        $set = Carbon::createFromFormat('Y',$request->year);
        // $set = Carbon::now()->format('Y');
        $startMonth = $set->copy()->startOfYear();
        $lastMonth = $set->copy()->endOfYear();
        
        foreach (CarbonPeriod::create($startMonth, '1 month',$lastMonth) as $key => $value) {
            $period[$key] = $value->format('Y');
            $chart['hadir'][$key] = Absensi::getDash('hadir', $value);
            $chart['izin'][$key] = Absensi::getDash('izin', $value);
            $chart['sakit'][$key] = Absensi::getDash('sakit', $value);
            $chart['cuti'][$key] = Absensi::getDash('cuti', $value);
        }
        // $chart['periode'] = '2021';
        $chart['periode'] = $request->year;

        $tops = User::withCount(['absensi' => function($q){
            $q->where('status', 'hadir');        
        }])
        ->orderBy('absensi_count', 'desc')
        ->take(5)->get();
        
        $worsts = User::withCount(['absensi' => function($q){
            $q->where('status', 'hadir');        
        }])
        ->orderBy('absensi_count', 'asc')
        ->take(5)->get();
    

        $this->loadIfExists($chart);

        return response([
            'top'   => $tops,
            'worst'   => $worsts,
            'status' => true,
            'chart' => $chart,
        ]);
    }

    public function create()
    {
        // return view('main::monitoring.create');
    }

    public function store(Request $request)
    {

    }

    public function show(Absensi $absensi)
    {

    }

    public function edit($id)
    {
    }

    public function update(Request $request, Absensi $absensi)
    {
        // return $absensi->updateByRequest($request);
    }

    public function destroy(Absensi $absensi)
    {
        // return $absensi->deleteByRequest();
    }

}
