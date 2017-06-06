<div id="top-navbar" class="navbar navbar-default nav_scroll" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="main-color text-bold">活动发布</span> 平台</a>
        </div>

        <div class="navbar-collapse collapse">

            <!-- Left nav -->
            <ul class="nav navbar-nav" data-smartmenus-id="14739838239025269">
                <li><a href="{{ route('categories.show', [0]) }}">全部活动</a></li>
                <li><a href="{{ route('categories.show', [2]) }}">线上活动</a></li>
                <li><a href="{{ route('categories.show', [3]) }}">线下活动</a></li>

            </ul>

            <!-- Right nav -->
            <div class="navbar-right">
                <ul class="nav navbar-nav">

                    @if (Auth::check())
                        <li>
                            <a class="button" href="{{ route('posts.create') }}">
                                <i class="fa fa-paint-brush" style="margin-right: 5px"></i>发起活动</a>
                        </li>

                        <li class="">
                            <a id="posts-dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fa fa-plus text-md"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="posts-dropdown">
                                <li>
                                    <a class="button" href="{{ route('posts.create') }}">
                                        <i class="fa fa-paint-brush" style="margin-right: 5px"></i>发起活动</a>
                                </li>
                                <li>
                                    <a class="button" href="{{ url('users/'.Auth::user()->id.'/posts/apply_detail') }}">
                                        <i class="fa fa-list-ul" style="margin-right: 5px"></i>活动报名情况</a>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a id="dLabel" role="button" class="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <img class="avatar-topnav" alt="{{Auth::user()->name}}"
                                     src="{{ Auth::user()->avatar ? Auth::user()->present()->gravatar(150):'https://dn-phphub.qbox.me/uploads/avatars/1_1479342408.png?imageView2/1/w/200/h/200' }}">
                                @if (Auth::user()->real_name)
                                    {{ Auth::user()->real_name }}
                                @elseif(Auth::user()->name)
                                    {{ Auth::user()->name }}
                                @endif
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li>
                                    <a class="button" href="{{ url('users/'.Auth::user()->id.'/posts/released') }}">
                                        <i class="fa fa-user text-md" style="margin-right: 5px"></i> 个人中心
                                    </a>
                                </li>
                                <li>
                                    <a class="button" href="{{ route('users.edit', Auth::user()->id) }}">
                                        <i class="fa fa-cog text-md" style="margin-right: 5px"></i> 编辑资料
                                    </a>
                                </li>
                                <li>
                                    <a id="login-out" class="button" href="{{ url('/logout') }}"
                                       data-lang-loginout="你确定要退出吗?" style="margin-right: 5px">
                                        <i class="fa fa-sign-out text-md"></i> 退出
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{--@else
                        <li>
                            <a href="{{ url('/login') }}" class="button">
                                <i class="fa fa-sign-in" aria-hidden="true">&nbsp;&nbsp;登录</i>
                            </a>
                        </li>--}}
                    @endif
                </ul>


                {{--<form method="GET" action="{{ route('search') }}" accept-charset="UTF-8" class="navbar-form navbar-left" target="_blank">
                    <div class="form-group">
                        <input class="form-control search-input mac-style" placeholder="搜索" name="q" type="text">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="search-btn">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>

                </form>--}}
            </div>


        </div><!--/.nav-collapse -->


    </div><!--/.container -->
</div>


