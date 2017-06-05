<ol class="breadcrumb">
    <li><a class="user-center-link" title="个人中心" href="{{ url('users/'.Auth::user()->id.'/posts/released') }}">个人中心</a>
    </li>
    <li class="active">{{ '活动报名详情'.' ( '.count($posts).' ) ' }}</li>
</ol>

<div class="panel panel-default">
    <div class="panel-title">活动报名详情</div>

    <div class="panel-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>活动名称</th>
                <th>分类</th>
                <th>发起时间</th>
                <th>报名人数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td class="text-overflow" style="text-align: left">
                        <a type="button" style="width: 30px;" href="{{ route('posts.show', $post->id) }}"
                           title="{{ $post->title }}">
                            {{ $post->title }}
                        </a>

                    </td>
                    <td>
                        <a href="{{ route('categories.show', $post->category->id) }}"
                           title="{{ $post->category->name }}">
                            {{ $post->category->name }}
                        </a>
                    </td>
                    <td>
                        <a>
                            {{ time_show($post->created_at) }}
                        </a>
                    </td>
                    <td>
                        <a href="#" title="{{ '报名人数为'.$post->apply_num.'人' }}">
                            {{ $post->apply_num }}
                        </a>
                    </td>
                    <td>
                        @if(isset($post->apply_templates) && count($post->apply_templates) > 0)
                            <a type="button" role="button" class="btn btn-success"
                               href="{{ url('posts/'.$post->id.'/applicants') }}">
                                <span class="fa fa-edit"></span> 报名详情</a>
                        @else
                            <a type="button" role="button" class="btn btn-success disabled"
                               href="{{ url('posts/'.$post->id.'/applicants') }}">
                                <span class="fa fa-edit"></span> 无需报名</a>
                        @endif


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="panel-footer" style="width: 100%;padding-bottom: 30px;padding-top:0px;">
            <span class="pull-right">
            {!! $posts->render() !!}
            </span>
        </div>
    </div>


</div>