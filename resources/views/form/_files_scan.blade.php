<div class="row">
    <div class="col-lg-12">
        <form class="form-inline" action="{{ route('scan') }}" method="get">
            <div class="form-group">
                <label class="sr-only" for="fileName">扫描目录</label>
                <input type="text" class="form-control" id="fileName" name="file_name" placeholder="扫描目录">
            </div>
            <button type="submit" class="btn btn-primary">确定</button>
        </form>
    </div>
</div>
