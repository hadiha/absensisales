<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Main\LaporanRequest;
use App\Models\Main\Laporan;
use App\Transformers\MainResource;

class LaporanController extends ApiController
{
    public function index()
    {
        $records = Laporan::forGrid()
                        ->paginate(request()->per_page ?: 10)->appends(request()->query());

        $this->loadIfExists($records);

        return MainResource::collection($records);
    }

    public function create()
    {
        return view('main::barang.create');
    }

    public function store(LaporanRequest $request)
    {
        return Laporan::createByRequest($request);
    }

    public function show(Laporan $laporan)
    {
        $this->loadIfExists($laporan);
        return new MainResource($laporan);
    }

    public function edit($id)
    {
        return view('main::barang.edit');
    }

    public function update(Request $request, Laporan $laporan)
    {
        return $laporan->updateByRequest($request);
    }

    public function destroy(Laporan $laporan)
    {
        // return $laporan->deleteByRequest();
    }
   
}
