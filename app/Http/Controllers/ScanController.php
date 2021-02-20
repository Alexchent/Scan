<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ScanController extends Controller
{
    static $num;
    public function index(Request $request)
    {
        if (!$request->has('path')) die("请输入文件路径");
        DB::table('files')->truncate();
        $this->get_dir_info($request->path);
        echo "success";
    }

    private function get_dir_info($path)
    {
        $handle = opendir($path);//打开目录返回句柄
        while (($content = readdir($handle)) !== false) {
            $new_dir = $path . '/' . $content;
            if ($content == '..' || $content == '.') {
                continue;
            }
            if (is_dir($new_dir)) {
                $this->get_dir_info($new_dir); // 递归到下一层
            } else {
                $file = $path . '/' . $content;
                if ($content == ".DS_Store") continue; //过滤配置文件
//                Storage::append("file_name_2_path-".time().'.txt', $content . ':' . $file);
                $data[] = [
                    'file_name' => $content,
                    'file_path' => $path,
                    'file_extension' => pathinfo($file, PATHINFO_EXTENSION),
                    'file_size' => filesize($file),
                ];
            }
            if (isset($data)) {
                self::$num += count($data);
                echo self::$num."<br>";

                DB::table('files')->insert($data);
//                Files::insert($data);
                unset($data);
            }
        }
    }
}
