<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Models\Authentication\User;
use App\Transformers\MasterResource;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    
    public function index()
    {
        $records = User::orderBy('username','asc')
        ->when($search = request()->name,function($q) use($search){
            $q->where(function($q) use($search){
                $q->where('username','like','%'.$search.'%');
                // $q->orWhere('name','like','%'.$search.'%');
            });
        })->get();

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
