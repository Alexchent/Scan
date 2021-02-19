<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function show(Request $request)
    {
        return Files::when($request->has('file_name'), function ($query) use ($request) {
            return $query->where('file_name', 'like', '%' . $request['file_name'] . '%');
        })->when($request->has('file_extension'),function ($query) use ($request) {
            return $query->where('file_extension', $request['file_extension']);
        })->get();
    }
}
