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

        if ($this->confirm('是否清空所有历史记录')) DB::table('files')->truncate(); //清空上次的扫描记录

        echo "正在扫描，您可以访问".url('files').PHP_EOL."查看扫描结果";
        //TODO 使用消息队列处理
        $files->scan($path);
    }
}
