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
    public function handle(Files $files)
    {
        $path = $this->ask('请输入要扫描的目录');
        echo "start scan".$path.PHP_EOL;
        DB::table('files')->truncate();
        echo "scanning, please click:".url('files').PHP_EOL;
        //TODO 使用消息队列处理
        echo PHP_OS_FAMILY.PHP_EOL;
        $files->scan($path);
    }
}
