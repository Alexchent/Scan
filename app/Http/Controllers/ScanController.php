<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
//        echo 1;die;
        get_dir_info("/Users/chentao/Downloads");
    }
}
