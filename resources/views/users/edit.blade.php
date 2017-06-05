@extends('layouts.default')

@section('title', '编辑个人资料' . ' | ')

@section('content')
    <div class="row colom-container">
        <aside class="col-md-3 main-col">
            @include('users.partials.setting_nav', ['currentUser' => $currentUser])
        </aside>
        <main class="col-md-9 left-col">
            <div class="panel panel-default padding-md">

                <div class="panel-body ">

                    <h2><i class="fa fa-cog" aria-hidden="true"></i> &nbsp;&nbsp;编辑个人资料</h2>
                    <hr>

                    <div id="update-user-alert-success" class="alert alert-success alert-dismissible hidden" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="update-user-alert-success-content">Hello World</span>
                    </div>

                    <div id="update-user-alert-danger" class="alert alert-danger alert-dismissible hidden" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="update-user-alert-danger-content">Error</span>
                    </div>

                    {{--method="POST" action="{{ route('users.update', Auth::user()->id) }}"--}}
                    <form id="update-form" class="form-horizontal"  method="put" action="{{ route('users.update', Auth::user()->id) }}"  accept-charset="UTF-8" enctype="multipart/form-data">
                        {{--<input id="_method" name="_method" type="hidden" value="PATCH">--}}
                        {!! csrf_field() !!}

                        <input type="hidden" id="user_id" name="id" value="{{ Auth::user()->id}}">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">性别</label>
                            <div class="col-sm-6">
                                <select class="form-control " id="gender" name="gender">
                                    <option value="unselected"
                                            {{ gender_selected('unselected', $currentUser->gender) }}>未选择
                                    </option>
                                    <option value="male" {{ gender_selected('male', $currentUser->gender) }}>
                                        男
                                    </option>
                                    <option value="female"
                                            {{ gender_selected('female', $currentUser->gender) }}>女
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-4 help-block"></div>
                        </div>


                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">邮 箱</label>
                            <div class="col-sm-6">
                                <input class="form-control" id="email" name="email" type="email" value="{{ $currentUser->email }}" disabled>
                            </div>
                            <div class="col-sm-4 help-block">
                                如：name@website.com
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">真实姓名</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="real_name" type="text" id="real_name"
                                       value="{{ $currentUser->real_name }}">
                            </div>
                            <div class="col-sm-4 help-block">
                                如：李小明
                            </div>
                        </div>

                        {{--<div class="form-group">
                            <label for="" class="col-sm-2 control-label">城市</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="city" type="text" value="">
                            </div>
                            <div class="col-sm-4 help-block">
                                如：北京、广州
                            </div>
                        </div>--}}

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">公司</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="company" type="text" id="company"
                                       value="{{ $currentUser->company }}">
                            </div>
                            <div class="col-sm-4 help-block">
                                如：阿里巴巴
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">微博用户名</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="weibo_id" type="text" id="weibo_id"
                                       value="{{ $currentUser->weibo_id }}">
                            </div>
                            <div class="col-sm-4 help-block">
                                如：Overtrue
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">个人网站</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="personal_website" type="text" id="personal_website"
                                       value="{{ $currentUser->personal_website }}">
                            </div>
                            <div class="col-sm-4 help-block">
                                如：example.com，不需要加前缀 https://
                            </div>
                        </div>

                        {{--<div class="form-group">
                            <label for="wechat_qrcode" class="col-sm-2 control-label">微信账号二维码</label>
                            <div class="col-sm-6">
                                <input type="file" name="wechat_qrcode">
                            </div>
                            <div class="col-sm-4 help-block">
                                你的微信个人账号，或者订阅号
                            </div>
                        </div>--}}


                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">个人简介</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" rows="3" name="introduction" cols="50" id="introduction">
                                    {{ !isset($currentUser)? '': trim($currentUser->introduction) }}
                                </textarea>
                            </div>
                            <div class="col-sm-4 help-block">
                                请一句话介绍你自己，大部分情况下会在你的头像和名字旁边显示
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button class="btn btn-primary" id="user-edit-submit" title="应用修改">
                                    应用修改
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/vendor/user-update.js') }}"></script>--}}

@endsection