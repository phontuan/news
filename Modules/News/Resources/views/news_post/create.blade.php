@extends('layouts.admin_default')
@section('title', 'Thêm bài viết')
@section('content')
    <section class="content-header">
        <h1>
            Thêm bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('news.news_post.index') }}"> Danh sách bài viết</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <form id="form-add-post" class="form-add-insurance-company" method="post" action="{{ route('news.news_post.index') }}" enctype="multipart/form-data">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm bài viết</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('news::includes.message')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input name="title" type="text" value="{{ old('title') }}" class="form-control" placeholder="Nhập tiêu đề bài viết">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả bài viết">{{ old('summary') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea id="post-data" name="data" class="form-control">{{ old('data') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại bài viết</label>
                                <select name="post_type" class="form-control">
                                    <option value="news">Tin tức</option>
                                    <option value="image">Tin ảnh</option>
                                    <option value="video">Tin video</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục tin</label>
                                <div class="list-categories">
                                    @if (isset($categories) && !empty($categories))
                                        @foreach($categories as $category)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="category[]" value="{{ $category->id }}"/>
                                                    {{ $category->prefix }} {{ $category->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button id="load-cat-parent" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCat">Thêm danh mục</button>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags</label><br>
                                <input type="text" value="" name="tags" data-role="tagsinput" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select name="post_status" class="form-control">
                                    <option value="0">Draft</option>
                                    <option value="1">Public</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh đại diện</label>
                                <input type="file" name="thumbnail" class="form-control preview-upload-image"/>
                                <img src="" class="preview-feature-image preview-image"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thời gian xuất bản</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="published_at" value="{{ old('published_at') }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="box-footer">
                    <div class="row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-6 text-right"><button type="submit" class="btn btn-primary">Thêm mới</button></div>
                        <div class="col-md-6 text-left"><a href="{{ route('news.news_post.index') }}" class="btn btn-default">Hủy</a></div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Modal -->
        <div id="addCat" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form class="form-horizontal" id="form-add-cat">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Thêm danh mục</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Tên danh mục</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="Nhập vào tên danh mục">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Danh muc cha</label>
                                <div class="col-sm-10">
                                    <select id="parent_cat" name="parent_id" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Ảnh cover</label>
                                <div class="col-sm-10">
                                    <input name="cover" value="{{ old('cover') }}" type="text" class="form-control" placeholder="Nhập vào link ảnh cover">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Mô tả</label>
                                <div class="col-sm-10">
                                    <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả">{{ old('summary') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Vị trí</label>
                                <div class="col-sm-10">
                                    <input name="position" type="number" value="{{ old('position') }}" class="form-control" placeholder="Nhập vào thứ tự hiển thị">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#post-data',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc responsivefilemanager'
            ],
            toolbar1: 'undo redo styleselect bold italic underline blockquote forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent link table',
            toolbar2: 'responsivefilemanager media emoticons preview fullscreen',
            imagetools_toolbar: 'alignleft aligncenter alignright rotateleft rotateright flipv fliph editimage imageoptions',
            image_advtab: true,
            external_filemanager_path: "/admin-lte/plugins/filemanager/",
            filemanager_title: "Công cụ quản lý file",
            external_plugins: {"filemanager": "plugins/responsivefilemanager/plugin.min.js"}
        });
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format :"DD-MM-YYYY HH:mm"
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#load-cat-parent').click(function () {
                $.ajax({
                    url : '{{route('news.news_category.create')}}?action=get',
                    type: 'GET',
                    success: function (data) {
                        $.each(data, function( index, val ) {
                            $('#parent_cat').append('<option value="'+val.id+'">'+val.prefix+val.name+'</option>');
                        });
                    }
                });
            })
            $('#form-add-cat').submit(function () {
                var data = $(this).serialize();
                $.ajax({
                    url : '{{route('news.news_category.store')}}',
                    type: 'POST',
                    data: data,
                    success : function (data) {
                        $('.list-categories').append('<div class="checkbox">'+
                            '<label> <input type="checkbox" name="category[]" value="'+data.id+'"/>'+data.name +'</label></div>');
                        $('#addCat').modal('hide');
                    }
                })
                return false;
            });
            $('#form-add-post').bind("keypress", function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });

        })
    </script>
@endsection
