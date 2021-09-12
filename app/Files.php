<?php

namespace App;

use App\Consts\CachePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class Files extends Model
{
    protected $table = "files";

    public $guarded = [];

    static $num;

    const EXTENSION = [
        'mp4',
        'mov',
        'flv',

        'png',
        'gif',
        'jpg',

        '7z',
        'rar',

        'txt',
        'html',
    ];

    public function scan($path)
    {
        $handle = opendir($path);//打开目录返回句柄
        while (($content = readdir($handle)) !== false) {
            if (PHP_OS_FAMILY === "Windows") {
                $new_dir = $path . '\\' . $content;
            } else {
                $new_dir = $path . '/' . $content;
            }

            if ($content == '..' || $content == '.') continue;
//            if (strpos($content,'.') !== false) continue;

            if (is_dir($new_dir)) {
                echo "DIR----", $new_dir . PHP_EOL;
                $this->scan($new_dir); // 递归到下一层
            } else {
//                echo "FILE----",$new_dir.PHP_EOL;
                if (PHP_OS_FAMILY === "Windows") {
                    $file = $path . '\\' . $content;
                } else {
                    $file = $path . '/' . $content;
                }
                Storage::append("file_name_2_path-".time().'.txt',  $file);

                //文件已存在
                $res = Redis::SADD('files', $file);
                if (!$res) continue;

                //后缀不符合
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                if (!in_array($extension, self::EXTENSION)) continue;

//                try {
                    $data[] = [
                        'file_name' => $content,
                        'file_path' => $path,
                        'file_extension' => $extension,
                        'file_size' => filesize($file),
                    ];
                    // 利用HyperLogLog估算文件数
//                    Redis::PFADD(CachePrefix::FILE_TOTAL_CLOSE_TO, [$path.'/'.$content]);
//                } catch (\Exception $exception) {
//                    continue;
//                }

            }
            if (isset($data)) {
                try {
                    //todo 批量插入，只要有一条记录不符合唯一索引的要求，就会导致一批数据插入失败
                    Files::insert($data);
                } catch (\Exception $exception) {
                    continue;
                }
                unset($data);
            }
        }
    }
}

