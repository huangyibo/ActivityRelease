@extends('layouts.default')

@section('title', $post->title . ' | ')

@section('content')
    @if(isset($applyTemplates) && count($applyTemplates)>0)
        <div class="modal fade" id="apply_join" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">申し込み</h4>
                    </div>
                    <form method="POST" action="{{ route('applicants.store') }}" accept-charset="UTF-8"
                          id="applicants-create-form">
                        <div class="modal-body">
                           {{-- @include('error')--}}
                            <div id="apply-post-alert-danger" class="alert alert-danger alert-dismissible hidden" style="height: 40px;padding-left: 20px" role="alert">
                            </div>

                            {!! csrf_field() !!}
                            <input id="post_id" type="hidden" name="post_id" value="{{ $post->id }}">

                            @if(isset($postPhases) && count($postPhases)>0)
                                <div class="form-group">
                                    <label class="control-label">
                                        <span style="color: red;">*</span>
                                        ご参加ご希望の部:
                                    </label>
                                </div>
                                <div id="post_phase_options" style="margin-top: 30px;padding-left:30px; padding-right:20px;">
                                @foreach($postPhases as $postPhase)
                                    <div class="checkbox">
                                        <input type="checkbox" name="post_phase" value="{{$postPhase->id}}" />
                                        <span>phase{{$postPhase->serial_num}}</span>&nbsp;&nbsp;
                                        <span>参加料:{{$postPhase->registration_fee}}　</span>&nbsp;&nbsp;
                                        <span>時間:{{format_post_phase_time($postPhase->start_time)}}
                                            --{{format_post_phase_time($postPhase->end_time)}}</span>
                                    </div>
                                @endforeach
                                </div>
                            @endif
                            <div id="help_block_post_phase" class="help-block hidden">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span>選択してください</span>
                            </div>

                            <div id="apply_attr_info">
                            @foreach($applyTemplates as $applyTemplate)
                                <div id="form_group_{{ $applyTemplate->apply_attr->attr_name }}" class="form-group">
                                    <label for="{{ $applyTemplate->apply_attr_id }}" class="control-label">
                                        @if($applyTemplate->is_required)
                                            <span class="required_item" style="color: red;">*</span>
                                        @endif
                                        {{ $applyTemplate->apply_attr->attr_slug }}:
                                    </label>
                                    <input type="{{ is_null($applyTemplate->apply_attr->attr_type)? 'text': $applyTemplate->apply_attr->apply_type }}"
                                           class="form-control" id="{{ $applyTemplate->apply_attr_id }}"
                                           name="{{ $applyTemplate->apply_attr->attr_name }}"
                                           placeholder="{{ $applyTemplate->apply_attr->attr_slug }}"
                                            {{ $applyTemplate->is_required ? 'required' : ''}}>
                                    <div id="help_block_{{ $applyTemplate->apply_attr->attr_name }}" class="help-block hidden">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <span>{{ $applyTemplate->apply_attr->attr_slug }}は必要項目です</span>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            {{--<div class="form-group">
                                <label for="recipient-name" class="control-label"><span
                                            style="color: red;">*</span>お振込名義:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="输入姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label"><span
                                            style="color: red;">*</span>携帯電話番号:</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号码" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label"><span
                                            style="color: red;">*</span>メールアドレス:</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="常用邮箱" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">&nbsp;所属:</label>
                                <input type="text" class="form-control" id="company_name" name="company_name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">&nbsp;ハンドルネーム:</label>
                                <input type="text" class="form-control" id="position" name="position">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">&nbsp;備考:</label>
                                <textarea class="form-control" id="message-text" name="message_text" rows="3"
                                          placeholder="其它事项请在此备注"></textarea>
                            </div>--}}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                            <button id="btn_apply_post_submit" type="button" class="btn btn-primary">確定
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="row colom-container">

        {{--margin-left: 4.16666666%;--}}
        @if(isset($apply_status))
            <div class="alert alert-success" role="alert">
                お手続きが完了いたしますた！ありがとうございました！
            </div>
        @endif
        <main class="col-md-9 main-content">

            <article id="70" class="post">

                <section class="featured-media">
                    <img src="{{ img_crop($post->cover, 1024, 546) }}" alt="{{ $post->title }}">
                </section>

                <header class="post-head">
                    <h1 class="post-title">{{ $post->title }}</h1>
                    <section class="post-meta">
                        <time class="post-date" title="{{ $post->created_at }}"><i class="fa fa-clock-o"
                                                                                   aria-hidden="true"></i> {{ $post->created_at }}
                        </time>
                    </section>

                    <div class="pull-right">
                        @if(isset($applyTemplates) && count($applyTemplates)>0)
                            {{--<span class='label label-success' style="margin-right: 15px;padding: 8px 5px">已报名 <span
                                       id="apply_num" style="font-size: 18px">{{ $post->apply_num }}</span>人</span>--}}

                            <a href="#" data-toggle="modal" data-target="#apply_join" class="btn btn-primary"
                               style="color:white">申し込み</a>
                        @endif

                    </div>
                </header>

                <section class="post-content">

                    {!! $post->body !!}

                </section>

                <footer class="post-footer clearfix">
                    <div class="pull-left tag-list">
                        <a href="{{ route('categories.show', [$post->category->id]) }}"><i
                                    class="fa fa-folder-open-o"></i> {{ $post->category->name }}</a>

                        @if (Auth::check() && (Auth::user()->can('visit_admin') || Auth::user()->id === $post->user_id))
                            | <a href="{{ route('posts.edit', [$post->id]) }}"><i class="fa fa-edit"></i> 修改活动</a>
                        @endif

                        @if (Auth::check() && Auth::user()->can('visit_admin'))
                            | <a href="/admin/posts/{{ $post->id }}" target="_blank"><i class="fa fa-eye"></i> 后台查看</a>
                        @endif

                    </div>

                    <div class="pull-right share">
                        <div class="social-share-cs"></div>
                    </div>

                </footer>


            </article>

            {{--@if($post->user)
                <div class="about-author clearfix">
                    <a href="{{ route('users.show', $post->user->id) }}">
                        <img src="{{ $post->user->avatar ? $post->user->present()->gravatar(150):'https://dn-phphub.qbox.me/uploads/avatars/1_1479342408.png?imageView2/1/w/200/h/200' }}"
                             alt="{{ $post->user->name }}"
                             class="avatar pull-left"></a>

                    <div class="details">
                        <div class="author">
                            作者 <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
                        </div>
                        <div class="meta-info">
                            <div class="website"><i class="fa fa-globe"></i><a
                                        href="{{ $post->user->personal_website }}"
                                        targer="_blank"> 个人中心</a></div>
                            <div class="introduction"><i class="fa fa-paint-brush"></i>
                                {{ $post->user->introduction }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif--}}

            <div class="bg-white recomanded-box">
                @include('_home_cell', ['section_title' => '近期活动', 'posts' => $posts])
            </div>


        </main>

        <aside class="col-md-3 sidebar">
            @include('layouts.partials.sidebar', ['posts' => $posts])
        </aside>

    </div>

@endsection


@section('scripts')
    <script type="text/javascript">
        /*, 'qzone', 'qq', 'douban'*/
        $(document).ready(function () {
            var $config = {
                title: '{{ $post->title }} from 活动发布平台',
                wechatQrcodeTitle: "微信扫一扫：分享", // 微信二维码提示文字
                wechatQrcodeHelper: '<p>微信里点“发现”，扫一下</p><p>二维码便可将本文分享至朋友圈。</p>',
                sites: ['weibo', 'facebook', 'twitter', 'google'],
            };

            socialShare('.social-share-cs', $config);
        });

    </script>
@stop
