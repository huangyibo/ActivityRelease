@extends('layouts.default')

@section('title', '个人中心' . ' | ')

@section('head-asset')
    <style type="text/css">
        .panel-default > .panel-title {
            width: 100%;
            text-align: center;
            vertical-align: middle;
            height: 50px;
            line-height: 50px;
            font-weight: bold;
            border-radius: 2px;
            background-color: rgb(91,192,222);
            color: #fff;
            font-family: '微软雅黑 Light'
        }

        th, td{
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')
    <div class="row colom-container">
        <aside class="col-md-3 main-col">
            @include('users.user_info_panel', ['user' => $user])
            @include('users.partials.user_center_menu', ['user' => $user])
        </aside>
        <main class="col-md-9 left-col">
            <div class="panel panel-default padding-md">

                <div class="panel-body ">
                    @if(Request::path() === 'users/'.$user->id.'/posts/released')
                        @include('users.partials.user_post_list', ['user' => $user, 'posts' => $posts])
                    @elseif(Auth::check() && Request::path() === 'users/'.$user->id.'/posts/apply_detail')
                        @include('posts.posts_applicants_list', ['user' => $user, 'posts' => $posts])
                    @elseif(Auth::check() && Request::path() === 'posts/'.$post->id.'/applicants')
                        @include('applicants.applicants_list_by_post_id', ['user' => $user, 'post' => $post, 'applicants' => $applicants, 'applyTemplates' => $applyTemplates])
                    @endif

                </div>
            </div>
        </main>

    </div>
@endsection