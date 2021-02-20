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
        })->paginate(10);

        return View('files', compact('files'));
    }

    public function destroy(Request $request)
    {
//        $file = quotemeta($request->file);
        $file = $request->file;
        $file = str_replace('[', '\[', $file);
        $file = str_replace(']', '\]', $file);
        $file = str_replace(' ', '\ ', $file);
//        $file = preg_replace('/\s+/', '\ ', $file);
        $shell = "rm ".$file; //macOS

        exec($shell, $result,$status);

        if( $status ){
            echo "shell命令{$shell}执行失败";
        } else {
            echo "shell命令{$shell}成功执行";
        }
        return redirect()->back();
    }

    public function show(Request $request, Files $file)
    {
//        $shell = "explorer ".$file_path; //win
        $shell = "open ".$file->file_path; //macOS
        exec($shell, $result,$status);
        return redirect()->back();
    }
}
