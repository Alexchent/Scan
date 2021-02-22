<?php

namespace App\Console\Commands;

use App\Files;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Scan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '扫描目录记录所有文件与位置的映射关系';

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->ask('请输入要扫描的目录');
        echo "start scan".$path.PHP_EOL;
        DB::table('files')->truncate();
        echo "scanning, please click:".url('files').PHP_EOL;
        //TODO 使用消息队列处理
        echo PHP_OS_FAMILY.PHP_EOL;
        $this->get_dir_info($path);
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
            echo "DIR----",$new_dir.PHP_EOL;
            if ($content == '..' || $content == '.') continue;
            if (strpos('.', $new_dir) !== false) continue;

            if (is_dir($new_dir)) {
                $this->get_dir_info($new_dir); // 递归到下一层
            } else {

                if (PHP_OS_FAMILY === "Windows") {
                    $file = $path . '\\' . $content;
                } else {
                    $file = $path . '/' . $content;
                }
//                Storage::append("file_name_2_path-".time().'.txt', $content . ':' . $file);
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                if (!in_array($extension, self::EXTENSION)) continue;

                $data[] = [
                    'file_name' => $content,
                    'file_path' => $path,
                    'file_extension' => $extension,
                    'file_size' => filesize($file),
                ];
            }
            if (isset($data)) {
                self::$num += count($data);
                echo "have scanned files:".self::$num.PHP_EOL;
                Files::insert($data);
                unset($data);
            }
        }
    }
}
