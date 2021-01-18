<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    protected $link = 'home';
    
    public function __construct()
    {
        $this->setLink($this->link);
        $this->setTitle("Dashboard");
        $this->setBreadcrumb(['Dashboard' => '#']);
    }

    public function index()
    {
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
            
        return $this->render('modules.home', [
            'top' => $tops,
            'worst' => $worsts,
        ]);
    }

    public function getData(Request $request)
    {
        $set = Carbon::createFromFormat('Y',$request->year);
        $startMonth = $set->copy()->startOfYear();
        $lastMonth = $set->copy()->endOfYear();
        
        foreach (CarbonPeriod::create($startMonth, '1 month',$lastMonth) as $key => $value) {
            $period[$key] = $value->format('Y');
            $chart['hadir'][$key] = Absensi::getDash('hadir', $value);
            $chart['izin'][$key] = Absensi::getDash('izin', $value);
            $chart['sakit'][$key] = Absensi::getDash('sakit', $value);
            $chart['cuti'][$key] = Absensi::getDash('cuti', $value);
        }
        $chart['periode'] = $request->year;
        
        return response([
            'status' => true,
            'chart' => $chart,
        ]);
    }

}
