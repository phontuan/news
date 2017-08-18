@extends('layouts.admin_default')
@section('title', 'Cập nhật danh mục tin')
@section('content')
    <section class="content-header">
        <h1>Quản lý danh mục tin</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('news.news_category.index') }}"> Danh mục tin</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            {!! Form::open(['method' => 'PUT', 'route' => ['news.news_category.update', $category->id]]) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Cập nhật danh mục tin</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('news::includes.message')
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input name="name" type="text" value="{{ $category->name }}" class="form-control" placeholder="Nhập vào tên danh mục" onchange="changeInput(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link</label>
                                <input name="slug" id="prefix" type="text" value="{{ $category->prefix }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục cha</label>
                                <select name="parent_id" class="form-control">
                                    @if (isset($categories) && !empty($categories))
                                        @foreach($categories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}" @if($category->parent_id == $parentCategory->id) selected @endif>{{ $parentCategory->prefix }} {{ $parentCategory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh cover</label>
                                <input name="cover" value="{{ $category->cover }}" type="text" class="form-control" placeholder="Nhập vào link ảnh cover">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả">{{ $category->summary }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thứ tự hiển thị</label>
                                <input name="position" type="number" value="{{ $category->position }}" class="form-control" placeholder="Nhập vào thứ tự hiển thị">
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="box-footer">
                    <div class="row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-6 text-right"><button type="submit" class="btn btn-primary">Cập nhật</button></div>
                        <div class="col-md-6 text-left"><a href="{{ route('news.news_category.index') }}" class="btn btn-default">Hủy</a></div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function changeInput(val) {
            slug = val.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            console.log(slug)
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@'+slug+'@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            slug = slug.trim();
            $('#prefix').val(slug)
        }
    </script>
@endsection
