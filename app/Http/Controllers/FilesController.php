<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function index(Request $request)
    {
        $files = Files::when($request->has('file_name') && !empty($request['file_name']) , function ($query) use ($request) {
            return $query->where('file_name', 'like', '%' . $request['file_name'] . '%');
        })->when($request->has('file_extension') && !empty($request['file_extension']), function ($query) use ($request) {
            return $query->where('file_extension', $request['file_extension']);
        })->paginate(6);
        foreach ($files  as $same) {
            //字节转MB
            $same->file_size_f = round($same->file_size / 1048576, 2);
        }
        return View('files', compact('files'));
    }

    public function repeat()
    {
        $files =  Files::with('sames')->has('sames', '>', 1)->paginate(6);
        foreach ($files as $sames) {
            foreach ($sames['sames']  as $same) {
                //字节转MB
                $same->file_size_f = round($same->file_size / 1048576,2);
            }
        }
        return View('repeat_files', compact('files'));
    }

    /**
     * @param Files $file 注意 变量名与模型名的约定，否则无法自动查找对象
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Files $file)
    {
        //原始
        if (PHP_OS_FAMILY === "Windows") {
            $original_file = $file->file_path.'\\'.$file->file_name;
            $shell = "del ".$original_file; //win
        } else {
            $original_file = $file->file_path.'/'.$file->file_name;

            $original_file = str_replace('[', '\[', $original_file);
            $original_file = str_replace(']', '\]', $original_file);
            $original_file = str_replace(' ', '\ ', $original_file);
            $shell = "rm ".$original_file; //macOS
        }

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
        if (PHP_OS_FAMILY === 'Windows') {
//            $path = str_replace('/','\\', $file->file_path);
            $shell = "explorer ".$file->file_path;
        } else {
            $shell = "open ".$file->file_path; //macOS
        }
        exec($shell, $result,$status);
//        echo $shell;
        return redirect()->back();
    }
}
