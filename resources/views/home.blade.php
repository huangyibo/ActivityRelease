@extends('layouts.default')

@section('content')
@if($big_banner != null and count($side_banner) >0)
    <div class="row add-top">
        <article class="col-md-9 pic-block big-block">
            <a class="shodow-box" href="{{ route('posts.show', [$big_banner->id]) }}">
                <img class="img-responsive" alt="{{ $big_banner->title }}" src="{{ img_crop($big_banner->cover, 1024, 546) }}" />
                <div class="pic-header">
                    <h2>{{ $big_banner->title }}</h2>
                    <p>{{ $big_banner->excerpt }}<p>
                </div>
            </a>
        </article>

        @foreach ($side_banner as $post)
            <article class="col-md-3 pic-block side-banner">
                <a class="shodow-box" href="{{ route('posts.show', [$post->id]) }}">
                    <img class="img-responsive" src="{{ img_crop($post->cover, 720, 376) }}" alt="{{ $post->title }}"/>
                    <h4>{{ $post->title }}</h4>
                </a>
            </article>
        @endforeach

    </div>
@endif
    @if (count($posts['recent_posts']) > 0)
        @include('_home_cell', ['section_title' => 'おすすめ', 'posts' => $posts['recent_posts'], 'category_id' => -1])
    @endif
    @if (count($posts['film_club_posts']) > 0)
        @include('_home_cell', ['section_title' => '撮影会', 'posts' => $posts['film_club_posts'], 'category_id' => 1])
    @endif
    @if (count($posts['others_posts']) > 0)
        @include('_home_cell', ['section_title' => 'その他', 'posts' => $posts['others_posts'], 'category_id' => 2])
    @endif
    {{--@if (count($posts['resources_posts']) > 0)
        @include('_home_cell', ['section_title' => '讲座推荐', 'posts' => $posts['resources_posts'], 'category_id' => 4, 'extra_class' => 'add-margin-bottom'])
    @endif--}}
    {{--@if (count($posts['meetup']) > 0)
        @include('_home_cell', ['section_title' => '线下聚会', 'posts' => $posts['meetup'], 'category_id' => 6])
    @endif--}}

@endsection
