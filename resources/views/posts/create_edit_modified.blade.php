@extends('layouts.default')

@section('title')
    {{ isset($post) ? '编辑活动' : '发起活动' }}_@parent
@stop

@section('head-asset')
    {!! we_css() !!}
    <style type="text/css">
        .fa {
            color: #aaa;
            cusor: pointer;
        }

        .fa:hover {
            color: #0099e9;
        }

        .required_item {
            color: red;
            size: 20px;
            text-align: center;
            vertical-align: middle;
            margin-left: 7px;
        }

        .form-group .control-label {
            float: left;
            padding-right: 15px;
            width: 130px;
        }

        #post-create-submit {
            width: 210px;
            height: 45px;
            padding-top: 10px;
            font-size: 18px;
            /*margin-left: 115px;*/
        }

        .post_phase {
            background-color: #fcfcfc;
            position: relative;
            width: 910px;
            min-width: 910px;
            overflow-x: auto;
        }

        .post_phase .post_phase_item_head {
            height: 40px;
            background-color: #edeeef;
            border: 1px solid #d9d9d9;
        }

        .post_phase .post_phase_item_head span {
            display: inline-block;
            line-height: 14px;
            font-size: 14px;
            color: #aaa;
            text-align: center;
            float: left;
            border-left: 1px solid #cecece;
            margin: 13px 0;
        }

        .post_phase .post_phase_item_head span.title01 {
            width: 80px;
            border: none;
        }

        .post_phase .post_phase_item_head span.title02 {
            width: 100px;
        }

        .post_phase .post_phase_item_head span.title03 {
            width: 522px;
        }

        .post_phase .post_phase_item_head span.title04 {
            width: 99px;
        }

        .post_phase #post_phase_list .post_phase_item {
            min-height: 48px;
            line-height: 48px;
            /*padding: 10px 0 0;*/
            border: 1px solid #d9d9d9;
            border-top: none;
            position: relative;
            text-align: center;
            vertical-align: middle;
            width: 100%;
            font-size: 14px;
            color: #000;
            background-color: #FFF;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_serial_num {
            height: 38px;
            width: 80px;
            float: left;
            text-align: center;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_name {
            height: 38px;
            width: 100px;
            float: left;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_name input {
            height: 38px;
            width: 80px;
            border: 1px solid #d9d9d9;
            text-align: center;
            font-size: 14px;
            color: #000;
            background-color: #FFF;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_time {
            height: 38px;
            width: 522px;
            float: left;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_time input {
            height: 38px;
            line-height: 38px;
            width: 196px;
            border: 1px solid #d9d9d9;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            color: #000;
            background-color: #FFF;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_fee {
            height: 38px;
            width: 99px;
            float: left;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_fee input {
            height: 38px;
            width: 78px;
            border: 1px solid #d9d9d9;
            text-align: center;
            font-size: 14px;
            color: #000;
            background-color: #FFF;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_people_limit {
            height: 38px;
            width: 99px;
            float: left;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_people_limit input {
            height: 38px;
            width: 78px;
            border: 1px solid #d9d9d9;
            text-align: center;
            font-size: 14px;
            color: #000;
            background-color: #FFF;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_operator {
            height: 38px;
            width: 99px;
            float: left;
        }

        .post_phase #post_phase_list .post_phase_item .form_input_phase_operator a {
            height: 18px;
            width: 18px;
            color: #d9d9d9;
        }

        .add_post_phase {
            margin-top: 10px;
        }

        #add_new_post_phase {
            color: #0099e9;
        }

        #add_new_post_phase:hover {
            border: 1px solid #0099e9;
            background-color: #fff;
        }

        .post_apply_template {
            background-color: #fcfcfc;
            width: 100%;
            border: 1px solid #c6c6c6;
            position: relative;
        }

        .post_apply_template .post_apply_template_title {
            font-size: 14px;
            display: block;
            color: #555;
            padding-left: 20px;
            padding-top: 20px;
        }

        .post_apply_template .post_apply_template_item {
            min-height: 52px;
            line-height: 52px;
            padding: 10px 30px;
            padding-left: 40px;
            /*border: 1px solid #d9d9d9;*/
            border-top: none;
            position: relative;
            vertical-align: middle;
            font-size: 14px;
            color: #000;
            background-color: #fcfcfc;
            overflow: hidden;
        }

        .post_apply_template_item_bound {
            background-color: #fff;
            float: left;
            padding: 1px 10px;
            padding-left: 30px;
            border: 1px solid #c6c6c6;
            display: block;
            width: 88%;
        }

        .post_apply_template_item_bound .apply_attr_icon {
            font-size: 16px;
            color: #555;
        }

        .post_apply_template_item_bound .apply_attr_name {
            color: #555;
            font-size: 16px;
            margin-left: 10px;
        }

        .post_apply_template .apply_template_attr_option {
            float: left;
            height: 20px;
            width: 20px;
            font-size: 30px;
            margin-left: 3%;
        }

        .post_apply_template .apply_template_attr_option > .fa {
            color: #aaa;
            cursor: pointer;
        }

        .post_apply_template .apply_template_attr_option > .fa:hover {
            color: #0099e9;
        }

        .post_apply_template .apply_template_attr_option > .fa.selected {
            color: #0099e9;
        }

        /* 发起活动：提交验证 */
        .help-block {
            color: red;
            font-size: 14px;
        }

        .help-block > .fa,
        .help-block > .fa:hover {
            color: red;
            font-size: 14px;
        }

    </style>
@stop

@section('content')

    <div class="post-composing-box">
        <div class="text-center header">
            <h1>{{ isset($post) ? '编辑活动' : '发起活动' }}</h1>
        </div>

        <div id="validation-errors"></div>
        <div id="post-alert-danger" class="alert alert-danger alert-dismissible hidden"
             style="height: 40px;padding-left: 20px" role="alert">
        </div>

        @if(isset($post))
            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                  action="{{ route('posts.update', $post->id) }}"
                  accept-charset="UTF-8"
                  id="post-update-form">
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

                        <div id="post_category_fg" class="form-group">
                            <label class="control-label" for="cover">活动分类<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px">
                                <select class="selectpicker form-control" name="category_id" id="category-select">

                                    <option value="" disabled selected="{{ count($category) != 0 ? '': 'selected' }}">
                                        请选择分类
                                    </option>
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}"
                                                selected="{{ (count($category) != 0 && $value->id == $category->id) ? 'selected' : '' }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <div id="post_category_note" class="help-block hidden">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请选择活动分类</span>
                                </div>
                            </div>
                        </div>

                        <div id="post_title_fg" class="form-group">
                            <label class="control-label" for="cover">活动标题<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px">
                                <input class="form-control" placeholder="活动标题" name="title" type="text"
                                       value="{{ old('title') ?: (isset($post) ? $post->title : '') }}">
                                <div id="post_title_note" class="help-block hidden">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请填写活动标题</span>
                                </div>
                            </div>
                        </div>

                        <div id="post_cover_fg" class="form-group">
                            <label class="control-label" for="cover">活动封面<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 row">
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="padding-left: 0px">
                                    <input id="cover" class="form-control" placeholder="活动封面，请输入相关图片的链接（如七牛云、CDN） ！"
                                           name="cover"
                                           type="text" value="{{ old('cover') ?: (isset($post) ? $post->cover : '') }}">
                                </div>
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-primary"
                                       for="cover_image">上传</label>
                                <input name="cover_image" class="form-control" id="cover_image" type="file"
                                       style="position:absolute;clip:rect(0 0 0 0);" placeholder="上传活动封面">
                            </div>
                            <div class="row">
                                <div id="post_cover_note" class="help-block hidden" style="margin-left:145px;">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请上传活动封面</span>
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group">
                            <label for="cover_image" class="btn btn-primary col-md-2">上传活动封面</label>
                            <div class="col-md-6" style="padding-left: 0px">
                            <input name="cover_image" class="form-control" id="cover_image" type="file"  placeholder="上传活动封面">
                            </div>
                        </div>--}}

                        <div id="post_excerpt_fg" class="form-group">
                            <label class="control-label" for="cover">活动概述<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px">
                                <input class="form-control" placeholder="100 字概述，在列表页面和邮件中会用到，请认真填写。" name="excerpt"
                                       type="text" value="{{ old('excerpt') ?: (isset($post) ? $post->excerpt : '') }}"
                                       required="required">
                                <div id="post_excerpt_note" class="help-block hidden">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请填写活动概述</span>
                                </div>
                            </div>
                        </div>

                        {{--<div class="form-group">
                            <textarea class="form-control" placeholder="活动内容" name="body_original"
                                      cols="50">{{ old('body_original') ?: (!isset($post) ? '' : $post->body_original) }}</textarea>
                        </div>--}}

                        <div id="post_detail_fg" class="form-group">
                            <label class="control-label" for="cover">活动详情<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px">
                <textarea id="body_original_textarea" class="form-control" placeholder="活动内容" name="body_original"
                          cols="60" style="height:400px;">
                    {{ old('body_original') ?: (!isset($post) ? '' : $post->body_original) }}
                </textarea>
                                <div id="post_detail_note" class="help-block hidden">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请输入活动详情</span>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group" style="position: relative">
                               <textarea id="ue-container" style="margin-top: 40px;width: inherit;margin-left: 0;" name="body_original" placeholder="活动内容" class="form-control"
                                         type="text/plain">
                                 </textarea>
                         </div>--}}

                        <div class="form-group">
                            <label class="control-label" for="cover">活动阶段<span class="required_item">&nbsp;&nbsp;</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px;overflow: scroll;">
                                <div id="post_phase" class="post_phase">
                                    <div class="post_phase_item_head">
                                        <span class="title01">序号</span>
                                        {{--<span class="title02">阶段名称</span>--}}
                                        <span class="title03">时间</span>
                                        <span class="title04">报名费用</span>
                                        <span class="title04">名额限制</span>
                                        <span class="title04">操作</span>
                                    </div>
                                    <div id="post_phase_list">
                                        @if(isset($postPhases) && count($postPhases)>0)
                                            @foreach($postPhases as $postPhase)
                                                <div class="post_phase_item"
                                                     id="{{'post_phase_item_'.$postPhase->serial_num}}" busid
                                                     mrmfx="mrmfx">
                                                    <span class="post_phase_id hidden">{{ $postPhase->id }}</span>

                                                    <div class="form_input_phase form_input_serial_num">{{ $postPhase->serial_num }}</div>

                                                    {{--<div class="form_input_phase form_input_phase_name">
                                                        <input type="text" id="post_phase_1_name" class="post_phase_name"
                                                               maxlength="20" placeholder="输入阶段名称" oninput="" onpropertychange=""
                                                               onchange="" value="第一阶段">
                                                    </div>--}}

                                                    <div class="form_input_phase form_input_phase_time">
                                                        <input type="datetime-local"
                                                               id="{{ 'post_phase_'.$postPhase->serial_num.'_start_time' }}"
                                                               class="post_phase_time"
                                                               placeholder="阶段起始时间"
                                                               value="{{ format_datetime_local($postPhase->start_time) }}">
                                                        <i class="fa fa-minus" style="color: #666;font-size: 14px"></i>
                                                        <input type="datetime-local"
                                                               id="{{ 'post_phase_'.$postPhase->serial_num.'_end_time' }}"
                                                               class="post_phase_time"
                                                               placeholder="阶段结束时间"
                                                               value="{{ format_datetime_local($postPhase->end_time) }}">
                                                    </div>

                                                    <div class="form_input_phase form_input_phase_fee">
                                                        <input type="text"
                                                               id="{{ 'post_phase_'.$postPhase->serial_num.'_fee' }}"
                                                               class="post_phase_fee"
                                                               maxlength="7" placeholder="免费请填0" oninput=""
                                                               onpropertychange=""
                                                               onchange=""
                                                               value="{{ isset($postPhase->registration_fee) ? $postPhase->registration_fee:0}}">
                                                    </div>

                                                    <div class="form_input_phase form_input_phase_people_limit">
                                                        <input type="text"
                                                               id="{{'post_phase_'.$postPhase->serial_num.'_people_limit'}}"
                                                               class="post_phase_people_limit"
                                                               maxlength="20" placeholder="不填则无限制" oninput=""
                                                               onpropertychange=""
                                                               onchange=""
                                                               value="{{ isset($postPhase->register_limit) ? $postPhase->register_limit : 0 }}">
                                                    </div>

                                                    <div class="form_input_phase form_input_phase_operator">
                                                        <a href="javascript:void(0)"
                                                           onclick="delPostPhase('{{ 'post_phase_item_'.$postPhase->serial_num }}')">
                                                            <i class="fa fa-trash" style="font-size: 16px;"
                                                               aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                                {{--<div class="add_post_phase">
                                    <a id="add_new_post_phase" href="javascript:void(0)" onclick="addPostPhase()"
                                       class="btn btn-default">+添加活动阶段</a>
                                </div>--}}


                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="cover"></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px">
                                <a id="add_new_post_phase" href="javascript:void(0)" onclick="addPostPhase()"
                                   class="btn btn-default">+添加活动阶段</a>
                            </div>
                            <div id="post_detail_note" class="help-block hidden">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span>请设置</span>
                            </div>
                        </div>

                        <div id="post_apply_template" class="form-group">
                            <label class="control-label" for="cover">报名填写信息<span class="required_item">*</span></label>
                            <div class="col-xs-10 col-md-10 col-lg-10" style="padding-left: 0px;overflow: scroll;">
                                <div class="post_apply_template" style="min-width: 300px;">
                                    <div class="post_apply_template_title">设置要收集的信息</div>

                                    @if(count($applyAttrs) > 0)
                                        @foreach($applyAttrs as $applyAttr)
                                            <?php
                                            $result = false;
                                            $applyTemplateId = '';
                                            ?>
                                            {{--*/ $result = false /*--}}
                                            @if(isset($applyTemplates) && count($applyTemplates)>0)
                                                @foreach($applyTemplates as $applyTemplate)
                                                    @if($applyTemplate->apply_attr_id == $applyAttr->id)
                                                        <?php
                                                        $result = true;
                                                        $applyTemplateId = $applyTemplate->id;
                                                        ?>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <div id="{{$applyAttr->id}}" class="post_apply_template_item">
                                                @if($result == true)
                                                    <span class="hidden apply_template_id">{{ $result ? $applyTemplateId:'' }}</span>
                                                @endif
                                                <div class="post_apply_template_item_bound">
                                                    <i class="fa fa-{{$applyAttr->attr_icon ? $applyAttr->attr_icon:'file-text'}} apply_attr_icon"></i>
                                                    <span class="apply_attr_name"
                                                          title="{{ $applyAttr->attr_name }}">{{$applyAttr->attr_slug}}</span>
                                                </div>
                                                <a type="button" class="apply_template_attr_option"
                                                   href="javascript:void(0)"
                                                   onclick="selectApplyTemplateAttrOption(this)">
                                                    <i class="fa fa-check-circle {{ $result ? 'selected':'' }}"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif

                                    {{--<div class="post_apply_template_item">
                                        <div class="post_apply_template_item_bound">
                                            <i class="fa fa-user apply_attr_icon"></i>
                                            <span class="apply_attr_name">姓名</span>
                                        </div>
                                        <a type="button" class="apply_template_attr_option"
                                           href="javascript:void(0)" onclick="selectApplyTemplateAttrOption(this)">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                    </div>--}}

                                </div>

                                <div id="post_detail_note" class="help-block hidden">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span>请设置活动报名要填写的信息</span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group status-post-submit">
                            <label class="control-label" for="post-create-submit"></label>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <a class="btn btn-primary" id="post-create-submit" type="button" title="发布活动">发布</a>
                            </div>

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

@stop
