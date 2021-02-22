<div class="mt-5">
    {!! $files->render() !!}
</div>

<table class="table table-bordered">
    <tr>
        <td>文件名</td>
        <td>文件路径</td>
        <td>文件扩展名</td>
        <td>文件大小</td>
        <td>操作</td>
    </tr>
    @foreach($files as $file)
        <tr>
            <td>{{ $file->file_name }}</td>
            <td>{{ $file->file_path }}</td>
            <td>{{ $file->file_extension }}</td>
            <td>{{ $file->file_size_f }}mb</td>
            <td>
                <form action="{{ route('files.show', $file) }}" method="get">
                    <button type="submit" class="btn btn-primary">打开</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<div class="mt-5">
    {!! $files->render() !!}
</div>