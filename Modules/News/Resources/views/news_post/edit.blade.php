@extends('layouts.admin_default')
@section('title', 'Cập nhật thông tin ')
@section('content')
    <section class="content-header">
        <h1>
            Quản lý tin tức
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('news.news_post.index') }}"> Danh sách tin</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            {!! Form::open(['method' => 'PUT','id'=>'form-edit-post', 'route' => ['news.news_post.update', $post->id]]) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Cập nhật tin tức</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('news::includes.message')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề</label>
                                    <input name="title" type="text" value="{{ $post->title }}" class="form-control" placeholder="Nhập tiêu đề danh mục" onchange="changeInput(this.value)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input id="slug" name="slug" type="text" value="{{ $post->slug }}" class="form-control" placeholder="Nhập đường dẫn URL">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả bài viết">{{ $post->summary }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung</label>
                                    <textarea id="post-data" name="data" class="form-control">{{ $post->data }}</textarea>
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
                                    <div class="list-categories" style="height: 120px; overflow-y: scroll">
                                        @if (isset($categories) && !empty($categories))
                                            <?php $postCategories = $post->categories()->pluck('category_id')->toArray(); ?>
                                            @foreach($categories as $category)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="category[]" @if (in_array($category->id, $postCategories)) checked @endif value="{{ $category->id }}">
                                                        {{ $category->prefix }} {{ $category->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <br>
                                    <button id="load-cat-parent" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCat">Thêm danh mục</button>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tags</label><br>
                                    <input type="text" value="@foreach($tag as $val){{$val->name}},@endforeach
                                    " name="tags" data-role="tagsinput" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select name="post_status" class="form-control">
                                        <option value="0" {{$post->post_status == 0 ?'selected':''}}>Draft</option>
                                        <option value="1" {{$post->post_status == 1 ?'selected':''}}>Public</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh đại diện</label>
                                    <input type="file" name="thumbnail" class="form-control preview-upload-image"/>
                                    <img src="{{ asset('img/posts/thumbnail').'/'.$post->thumbnail}}" @if (empty($post->thumbnail)) style="display: none;" @endif class="preview-feature-image preview-image"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thời gian publish</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="published_at" value="{{ \Carbon\Carbon::parse($post->published_at)->format('d-m-Y H:m') }}" />
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
                        <div class="col-md-6 text-right"><button type="submit" class="btn btn-primary">Cập nhật</button></div>
                        <div class="col-md-6 text-left"><a href="{{ route('news.news_post.index') }}" class="btn btn-default">Hủy</a></div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- Modal -->
        <div id="addCat" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div id="alert-cat-add"></div>
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
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_flat'
        });
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
                    },
                    error: function (data) {
                        if(data.responseText.name != ''){
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Vui lòng nhập vào tên</div>')
                        }else {
                            $('#alert-cat-add').append('<div class="alert alert-danger" >Có lỗi xảy ra vui lòng thử lại</div>')
                        }
                    }
                })
                return false;
            });
            $('#form-edit-post').bind("keypress", function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });

        })
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
            $('#slug').val(slug)
        }
    </script>
@endsection
