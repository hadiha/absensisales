<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Models\Authentication\User;
use App\Models\Master\Barang;
use App\Transformers\MasterResource;
use Illuminate\Http\Request;

class BarangController extends ApiController
{
    
    public function index()
    {
        $records = Barang::orderBy('name','asc')
        ->when($kode = request()->kode,function($q) use($kode){
            $q->where(function($q) use($kode){
                $q->where('kode','like','%'.$kode.'%');
                // $q->orWhere('name','like','%'.$search.'%');
            });
        })
        ->when($search = request()->name,function($q) use($search){
            $q->where(function($q) use($search){
                $q->where('name','like','%'.$search.'%');
                // $q->orWhere('name','like','%'.$search.'%');
            });
        })
        ->get();

        // if ($parent = request()->parent) {
        //     $records->appends($parent);
        // };
        $this->loadIfExists($records);
        return MasterResource::collection($records);
    }

    public function create()
    {
        // return view('master::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        // return view('master::show');
    }

    public function edit($id)
    {
        // return view('master::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
