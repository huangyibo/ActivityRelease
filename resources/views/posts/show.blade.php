@extends('layouts.default')

@section('title', $post->title . ' | ')

@section('content')
    <div class="modal fade" id="apply_join" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">活动报名</h4>
                </div>
                <form method="POST" action="{{ route('applicants.store') }}" accept-charset="UTF-8"
                      id="applicants-create-form">
                    <div class="modal-body">
                        @include('error')

                        {!! csrf_field() !!}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label"><span
                                        style="color: red;">*</span>姓名:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="输入姓名" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label"><span
                                        style="color: red;">*</span>手机号:</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号码" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label"><span
                                        style="color: red;">*</span>邮箱:</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="常用邮箱" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">&nbsp;单位:</label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">&nbsp;职位:</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">&nbsp;备注:</label>
                            <textarea class="form-control" id="message-text" name="message_text" rows="3"
                                      placeholder="其它事项请在此备注"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">提交
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row colom-container">
        {{--margin-left: 4.16666666%;--}}
        @if(isset($apply_status))
            <div class="alert alert-success" role="alert">
                活动报名信息已经发送到您的邮箱，请查收！
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
                        <span class='label label-success' style="margin-right: 15px;padding: 8px 5px">已报名 <span
                                    style="font-size: 18px">{{ $post->apply_num }}</span>人</span>
                        <a href="#" data-toggle="modal" data-target="#apply_join" class="btn btn-primary"
                           style="color:white">我要报名</a>
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
                        <div class="social-share-cs "></div>
                    </div>

                </footer>


            </article>

            <div class="about-author clearfix">
                <a href="{{ route('users.show', $post->user->id) }}">
                    <img src="{{ $post->user->avatar ? $post->user->present()->gravatar(150):'https://dn-phphub.qbox.me/uploads/avatars/12985_1489306555.jpeg?imageView2/1/w/100/h/100' }}"
                         alt="{{ $post->user->name }}"
                         class="avatar pull-left"></a>

                <div class="details">
                    <div class="author">
                        作者 <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
                    </div>
                    <div class="meta-info">
                        <div class="website"><i class="fa fa-globe"></i><a href="{{ $post->user->personal_website }}"
                                                                           targer="_blank"> 个人中心</a></div>
                        <div class="introduction"><i class="fa fa-paint-brush"></i>
                            {{ $post->user->introduction }}
                        </div>
                    </div>
                </div>
            </div>

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

        $(document).ready(function () {
            var $config = {
                title: '{{ $post->title }} from 活动发布平台',
                wechatQrcodeTitle: "微信扫一扫：分享", // 微信二维码提示文字
                wechatQrcodeHelper: '<p>微信里点“发现”，扫一下</p><p>二维码便可将本文分享至朋友圈。</p>',
                sites: ['weibo', 'facebook', 'twitter', 'google', 'qzone', 'qq', 'douban'],
            };

            socialShare('.social-share-cs', $config);
        });

    </script>
@stop
