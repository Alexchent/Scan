<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>@yield('title','scan app')</title>
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
        <style>
            body{
                /*background-image: url("http://www.abiechina.com/images/have_img.png");*/
            }
        </style>
    </head>
    <body>

    <div class="container">

        <div class="row">

            <div class="col-lg-12">
                @include('table._repeat_files')
            </div>

        </div>

    </div>
    </body>
</html>
