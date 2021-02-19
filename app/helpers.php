<?php

use Illuminate\Support\Facades\Storage;

//const FILE_DATA_PATH = "/Users/chentao/Downloads/";
const FILE_DATA_PATH = "C:\Users\alexchen\Documents\Scanned\\";
/**
 * 上传图片到阿里云
 *
 * @param  string $path 要保存的路径
 * @param  string $file 上传的文件
 * @param  string $drive 要使用的驱动
 * @return string url     图片完全路径
 */
function upload_image($path, $file, $drive = 'oss')
{
    $disk = Storage::disk($drive);

    //将图片上传到OSS中，并返回图片路径信息 值如:avatar/WsH9mBklpAQUBQB4mL.jpeg
    $path = $disk->put($path, $file);

    //由于图片不在本地，所以我们应该获取图片的完整路径，
    //值如：https://test.oss-cn-hongkong.aliyuncs.com/avatar/8GdIcz1NaCZ.jpeg
    return $disk->url($path);
}


function get_dir_info($path)
{
    $handle = opendir($path);//打开目录返回句柄
    while (($content = readdir($handle)) !== false) {
        $new_dir = $path . '/' . $content;
        if ($content == '..' || $content == '.') {
            continue;
        }
        if (is_dir($new_dir)) {
//            echo "目录：".$new_dir . "\n";
            get_dir_info($new_dir); // 递归到下一层
        } else {
            $file = $path . '/' . $content;
//            $content = file_get_contents($path.'/'.$content);
            if ($content == ".DS_Store") continue; //过滤配置文件
//            file_put_contents(FILE_DATA_PATH . "file_name_2_path-".now()->toDateString().'.txt', $content . ':' . $file, FILE_APPEND);
            Storage::append("file_name_2_path-".time().'.txt', $content . ':' . $file);
        }
    }
}

function get_file_content($file_path)
{
    if (file_exists($file_path)) {
        $file_contents = file($file_path);
        for ($i = 0; $i < count($file_contents); $i++) {//逐行读取文件内容
            if (empty(trim($file_contents[$i]))) continue;                 //过滤空值
            if (strpos(trim($file_contents[$i]), '*') === 0) continue;    //过滤注释
            if (strpos($file_contents[$i], '//') !== false) continue;               //过滤注释
            if (strpos($file_contents[$i], '/*') !== false) continue;               //过滤注释
            if (strpos($file_contents[$i], '#') !== false) continue;                //过滤注释
            file_put_contents(FILE_DATA_PATH . "file_data.txt", $file_contents[$i], FILE_APPEND);
        }
    }
}


/**
 * 对象转数组
 * @param $object
 * @return array|void
 */
function object_to_array($object)
{
    $object = (array)$object;
    foreach ($object as $k => $v) {
        if (gettype($v) == 'resource') return;
        if (gettype($v) == 'object' || gettype($v) == 'array')
            $object[$k] = object_to_array($v);
    }
    return $object;
}

function objectToArray($object)
{
    $result = [];
    $object = is_object($object) ? get_object_vars($object) : $object;
    foreach ($object as $key => $value) {
        $result[$key] = (is_object($value) || is_array($value)) ? objectToArray($value) : $value;
    }
    return $result;
}
