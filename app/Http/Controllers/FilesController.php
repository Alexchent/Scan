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
        $shell = "explorer ".$file_path;
        exec($shell, $result,$status);
        return redirect()->back();
//        echo "<pre>";
//        if( $status ){
//            echo "shell命令{$shell}执行失败";
//        } else {
//            echo "shell命令{$shell}成功执行, 结果如下<hr>";
//            print_r( $result );
//        }
//        echo "</pre>";
    }
}
