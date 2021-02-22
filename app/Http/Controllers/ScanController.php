<?php

namespace App\Http\Controllers;

use App\Files;
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
        echo "正在扫描，请稍后访问";
        echo url('files');
        $this->get_dir_info($request->path);
    }

    private function get_dir_info($path)
    {
        $handle = opendir($path);//打开目录返回句柄
        while (($content = readdir($handle)) !== false) {
            if (PHP_OS_FAMILY === "Windows") {
                $new_dir = $path . '\\' . $content;
            } else {
                $new_dir = $path . '/' . $content;
            }

            if ($content == '..' || $content == '.') {
                continue;
            }
            if (is_dir($new_dir)) {
                $this->get_dir_info($new_dir); // 递归到下一层
            } else {
                if (PHP_OS_FAMILY === "Windows") {
                    $file = $path . '\\' . $content;
                } else {
                    $file = $path . '/' . $content;
                }
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
//                echo self::$num."<br>";
                Files::insert($data);
                unset($data);
            }
        }
    }
}
