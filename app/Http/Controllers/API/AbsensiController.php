<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Main\AbsensiRequest;
use App\Models\Main\Absensi;
use App\Transformers\MainResource;

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

}
