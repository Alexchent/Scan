<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * @param Files $file 注意 变量名与模型名的约定，否则无法自动查找对象
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Files $file)
    {
        //原始
        $original_file = $file->file_path.'\\'.$file->file_name;
        $original_file = str_replace('[', '\[', $original_file);
        $original_file = str_replace(']', '\]', $original_file);
        $original_file = str_replace(' ', '\ ', $original_file);
//        $file = preg_replace('/\s+/', '\ ', $file);
        $shell = "del ".$original_file; //win
//        $shell = "rm ".$file; //macOS
        exec($shell, $result,$status);
        if( $status ){
            echo "shell命令{$shell}执行失败";die;
        } else {
            Files::destroy($file->id);
            echo "shell命令{$shell}成功执行";
        }
        return redirect()->back();
    }

    public function show(Files $file)
    {
        $shell = "explorer ".$file->file_path; //win
//        $shell = "open ".$file->file_path; //macOS
        exec($shell, $result,$status);
        return redirect()->back();
    }
}
