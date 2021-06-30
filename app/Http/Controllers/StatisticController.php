<?php

namespace App\Http\Controllers;

use App\Consts\CachePrefix;
use Illuminate\Support\Facades\Redis;

class StatisticController extends Controller
{
    public function show()
    {
        // 估计文件个数
        echo "估计文件个数：".Redis::PFCOUNT(CachePrefix::FILE_TOTAL_CLOSE_TO);
    }
}
