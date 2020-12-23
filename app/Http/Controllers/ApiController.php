<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class ApiController extends BaseController
{
    public function loadIfExists($records)
    {
        if (request()->has('includes')) {
            $includes = explode(',', request()->includes);

            try {
                $records->load($includes);
            } catch (RelationNotFoundException $e) {
                return response()->json([
                    'success' => 'false',
                    'message' => 'One of the relation is not found'
                ], 500);
            }
        }
    }
}
