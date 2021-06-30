# 本地文件扫描工具 laravel+mysql 

## 安装
1. 执行php artisan migrate 生成数据表
2. 执行php artisan scan 启动扫描命令，输入要扫描的目录。开始扫描
3. 扫描完成后，执行php artisan serve
4. 访问页面 127.0.0.1:8000/files即可查看扫描好的文件
5. 访问页面 127.0.0.1:8000/repeat_files可查看名称重复的文件