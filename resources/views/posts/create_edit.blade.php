@extends('layouts.default')

@section('title')
    {{ isset($post) ? '编辑活动' : '发起活动' }}_@parent
@stop

@section('head-asset')
    {!! we_css() !!}
@stop

@section('content')

    <div class="post-composing-box">
        <div class="text-center header">
            <h1>{{ isset($post) ? '编辑活动' : '发起活动' }}</h1>
        </div>

        <div id="validation-errors"></div>

        @if(isset($post))
            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                  action="{{ route('posts.update', $post->id) }}"
                  accept-charset="UTF-8"
                  id="post-create-form">
                @else
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                          action="{{  route('posts.store') }}"
                          accept-charset="UTF-8"
                          id="post-create-form">
                        @endif

                        @if(isset($post))
                            <input name="_method" type="hidden" value="PATCH">
                        @endif


                        @include('error')

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <select class="selectpicker form-control" name="category_id" id="category-select">

                                <option value="" disabled selected="{{ count($category) != 0 ? '': 'selected' }}">
                                    请选择分类
                                </option>
                                @if(count($categories) > 0)
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}"
                                                selected="{{ (count($category) != 0 && $value->id == $category->id) ? 'selected' : '' }}">{{ $value->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control" placeholder="活动标题" name="title" type="text"
                                   value="{{ old('title') ?: (isset($post) ? $post->title : '') }}">
                        </div>

                        <div class="form-group">
                            <div class="col-md-8" style="padding-left: 0px">
                                <input id="cover" class="form-control" placeholder="活动封面，请输入相关图片的链接（如七牛云、CDN） ！"
                                       name="cover"
                                       type="text" value="{{ old('cover') ?: (isset($post) ? $post->cover : '') }}">
                            </div>
                            <label class="col-md-2 btn btn-primary" for="cover_image">上传活动封面</label>
                            <input name="cover_image" class="form-control" id="cover_image" type="file"
                                   style="position:absolute;clip:rect(0 0 0 0);" placeholder="上传活动封面">

                            {{--{!! Form::open([ 'url' => ['posts/cover/upload'], 'method' => 'POST', 'id' => 'upload_cover', 'files' => true ,  'class' => 'col-md-6']) !!}
                                <input name="cover_image" id="cover_image" type="file" placeholder="上传活动封面">
                                <span id="upload-cover-image">上传活动封面</span>
                            {!! Form::close() !!}--}}
                        </div>
                        {{--<div class="form-group">
                            <label for="cover_image" class="btn btn-primary col-md-2">上传活动封面</label>
                            <div class="col-md-6" style="padding-left: 0px">
                            <input name="cover_image" class="form-control" id="cover_image" type="file"  placeholder="上传活动封面">
                            </div>
                        </div>--}}

                        <div class="form-group">
                            <input class="form-control" placeholder="100 字概述，在列表页面和邮件中会用到，请认真填写。" name="excerpt"
                                   type="text" value="{{ old('excerpt') ?: (isset($post) ? $post->excerpt : '') }}"
                                   required="required">
                        </div>

                        {{--<div class="form-group">
                            <textarea class="form-control" placeholder="活动内容" name="body_original"
                                      cols="50">{{ old('body_original') ?: (!isset($post) ? '' : $post->body_original) }}</textarea>
                        </div>--}}

                        <div class="form-group">
                <textarea id="body_original_textarea" class="form-control" placeholder="活动内容" name="body_original"
                          cols="60" style="height:400px;">
                    {{ old('body_original') ?: (!isset($post) ? '' : $post->body_original) }}
                </textarea>
                        </div>

                        {{-- <div class="form-group" style="position: relative">
                               <textarea id="ue-container" style="margin-top: 40px;width: inherit;margin-left: 0;" name="body_original" placeholder="活动内容" class="form-control"
                                         type="text/plain">
                                 </textarea>
                         </div>--}}

                        <div class="form-group status-post-submit">
                            <input class="btn btn-primary" id="post-create-submit" type="submit" value="发布">
                        </div>
                    </form>

    </div>

@stop

@section('scripts')
    {!! we_js() !!}
    {!! we_config('body_original_textarea') !!}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#cover_image').on('change', function () {
                var cover_image = $('#cover_image').val();
                $('#cover').val(cover_image);
            });
        });
    </script>

    {{--<script type="text/javascript">
        $(document).ready(function () {
            var options = {
                beforeSubmit: showRequest,
                success: showResponse,
                dataType: 'json'
            };
            $('#cover_image').on('change', function () {
                alert('正在上传');
//               $('#upload-cover-image').html('正在上传...');
               $('#upload_cover').ajaxForm(options).submit();
            });
        });

        function showRequest() {
            $('#validation-errors').hide().empty();
            return true;
        }

        function showResponse(response) {
            if (response.success == false)
            {
                alert('error');
                var responseErrors = response.errors;
                $.each(responseErrors, function (index, value) {
                    if (value.length != 0)
                    {
                        $('#validation-errors').append('<div class="alert alert-error"><strong>'+ value +'</strong></div>')
                    }
                })
                $('#validation-errors').show();
            }else {
                alert('success:'+response.cover);
                $('#cover').val(response.cover);
            }
        }

        var editor = new wangEditor('body_original_textarea');
         editor.create();

        --}}{{--$(document).ready(function () {--}}{{--
        --}}{{--var simplemde = new SimpleMDE({--}}{{--
        --}}{{--spellChecker: false,--}}{{--
        --}}{{--autosave: {--}}{{--
        --}}{{--enabled: true,--}}{{--
        --}}{{--delay: 1,--}}{{--
        --}}{{--unique_id: "topic_content{{ isset($post) ? $post->id : '' }}"--}}{{--
        --}}{{--},--}}{{--
        --}}{{--forceSync: true--}}{{--
        --}}{{--});--}}{{--
        --}}{{--});--}}{{--

        --}}{{--var ue = UE.getEditor('ue-container', {--}}{{--
        --}}{{--initialFrameHeight : 350,--}}{{--
        --}}{{--zIndex: 'inherit',--}}{{--
        --}}{{--});--}}{{--

        --}}{{--ue.ready(function () {--}}{{--
        --}}{{--ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}{{--
        --}}{{--});--}}{{--

    </script>--}}
@stop
