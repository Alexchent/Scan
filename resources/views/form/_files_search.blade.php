<div class="row">
    <div class="col-lg-12">
        <form class="form-inline" action="{{ route('files.index') }}" method="get">
            <div class="form-group">
                <label class="sr-only" for="fileName">文件名</label>
                <input type="text" class="form-control" id="fileName" name="file_name" placeholder="文件名">
            </div>
            <div class="form-group">
                <label class="sr-only" for="extension">文件扩展名</label>
                <input type="text" class="form-control" id="extension" name="file_extension" placeholder="文件扩展名">
            </div>
            <button type="submit" class="btn btn-primary">确定</button>
        </form>
    </div>
</div>
