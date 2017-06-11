
    {{--<div class="widget rm-padding grid-item">
        <div class="grid-wrap subscribe-wrap">
            @include('layouts.partials.weekly_card', ['size' => 'small'])
        </div>
    </div>--}}

    <div class="widget grid-item links">
        <div class="grid-wrap">
            <h4 class="title">推荐活动</h4>
            @foreach ($posts as $post)
                <article class="pic-block" style="width: inherit;padding: 0px;">
                    <a class="shodow-box" href="{{ route('posts.show', [$post->id]) }}">
                        <img class="img-responsive" alt="{{ $post->title }}" style="text-align: center;" src="{{ img_crop($post->cover, 1000, 460) }}"/>
                        <h4>{{ $post->title }}</h4>
                    </a>
                </article>
            @endforeach
        </div>
    </div>

    <div class="widget grid-item links">
        <div class="grid-wrap">
            <h4 class="title">友情链接</h4>
            <a href="http://172.104.67.21" class="btn btn-default btn-block" target="_blank">株式会社YAKUMO主页</a>
            {{--<a href="#" class="btn btn-default btn-block" target="_blank"><i class="fa fa-wechat" aria-hidden="true" style="margin-right: 10px"></i>B站点</a>--}}
        </div>
    </div>


    {{--<div class="widget grid-item">
        <div class="grid-wrap">
            <h4 class="title">关注订阅号</h4>
            <div class="content">
                <img src="/assets/images/qrcode_new.png" alt="" style="width:100%"/>
            </div>
        </div>
    </div>--}}
