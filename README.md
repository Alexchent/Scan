# 本地文件扫描工具 laravel+mysql+redis

[利用HyperLogLog估算文件总数，有0.18%的误差](/app/Console/Commands/Scan.php)

核心指令
```markdown
PFADD file_total_close_to {file_name}
```

## 安装
- 安装依赖
```
composer install
```
- 修改mysql以及redis配置

- 初始化数据表
```markdown
php artisan migrate
```
- 执行php artisan scan 启动扫描命令，输入要扫描的目录，开始扫描
- 扫描完成后，执行php artisan serve
- 访问页面 127.0.0.1:8000/files即可查看扫描好的文件
- 访问页面 127.0.0.1:8000/repeat_files可查看名称重复的文件