<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Main\DocRequest;
use App\Models\Main\Documentasi;
use App\Models\Main\Laporan;
use App\Transformers\MainResource;

class DocumentasiController extends ApiController
{
    public function index()
    {
        $records = Documentasi::forGrid()
                        ->paginate(request()->per_page ?: 10)->appends(request()->query());

        $this->loadIfExists($records);

        return MainResource::collection($records);
    }

    public function create()
    {
        return view('main::barang.create');
    }

    public function store(DocRequest $request)
    {
        return Documentasi::createByRequest($request);
    }

    public function show(Documentasi $documentasi)
    {
        $this->loadIfExists($documentasi);
        return new MainResource($documentasi);
    }

    public function edit($id)
    {
        return view('main::barang.edit');
    }

    public function update(DocRequest $request, Documentasi $documentasi)
    {
        return $documentasi->updateByRequest($request);
    }

    public function destroy(Laporan $laporan)
    {
        // return $laporan->deleteByRequest();
    }
   
}
