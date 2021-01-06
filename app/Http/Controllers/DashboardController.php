<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Authentication\User;
use App\Models\Main\Absensi;

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
                // dd($tops);
        $statistik = Absensi::select('*');
            
        return $this->render('modules.home', [
            'top' => $tops,
            'worst' => $worsts,
            'statistik' => $statistik,
        ]);
    }

    public function getData(Request $request)
    {
        $chart['periode'] = $request->year;
        $chart['hadir'] = [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175, 100233];
        $chart['izin'] = [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434];
        $chart['sakit'] = [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]; 
        $chart['cuti'] = [null, null, 7988, 12169, 15112, 22452, 34400, 34227];
        $chart['tk'] = [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111];

        return response([
            'status' => true,
            'chart' => $chart,
        ]);
    }

}
