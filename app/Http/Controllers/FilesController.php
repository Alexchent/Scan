<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function index(Request $request)
    {
        $files = Files::when($request->has('file_name'), function ($query) use ($request) {
            return $query->where('file_name', 'like', '%' . $request['file_name'] . '%');
        })->when($request->has('file_extension'),function ($query) use ($request) {
            return $query->where('file_extension', $request['file_extension']);
        })->get();

        return View('files', compact('files'));
    }

    public function destroy(Request $request)
    {
        echo $request->file;
    }

    public function show(Request $request, $file_path)
    {
        echo $file_path;die;
    }
}
