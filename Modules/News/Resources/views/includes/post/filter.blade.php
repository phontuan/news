<div class="row">
    <div class="col-md-4">
        <div class="form-group no-margin remove-date">
            <label>Tiêu đề bài viết</label>
            <input name="name" type="text" class="form-control" value="{{ Request::get('name') }}" >
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group no-margin remove-date">
            <label>Ngày tạo</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" name="published_at" value="{{ Request::get('published_at') }}" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group no-margin remove-date">
            <label>Trạng thái</label>
            <select class="form-control select2" name="post_status" data-placeholder="Trạng thái">
                <option value="0" {{(Request::get('post_status') == 0 ? 'selected':'')}}>Nháp</option>
                <option value="1" {{(Request::get('post_status') == 1 ? 'selected':'')}}>Hoạt động</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label style="visibility: hidden">TK</label>
            <button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Tìm kiếm</button>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group no-margin remove-date">
            <label>Danh mục</label>
            <select class="form-control select2" name="category" data-placeholder="Trạng thái">
                <option value="">Chọn danh mục</option>
                @foreach($categories as $val)
                    @if($val->id > 0)
                    <option value="{{$val->slug}}" {{(Request::get('category') == $val->slug ? 'selected':'')}}>{{$val->prefix.' '.$val->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group no-margin remove-date">
            <label>Tag</label>
            <select class="form-control select2" name="tag" data-placeholder="Trạng thái">
                <option value="">Chọn tag</option>
            @foreach($tags as $val)
                <option value="{{$val->name}}" {{(Request::get('tag') == $val->name ? 'selected':'')}}>{{$val->name}}</option>
            @endforeach
            </select>
        </div>
    </div>

</div>