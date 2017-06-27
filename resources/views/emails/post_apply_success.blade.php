<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')活动发布平台</title>

    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>--}}
    <meta name="description" content="活动发布系统。">
    <meta name="author" content="Bob">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/images/favicon.png">

    <link rel="apple-touch-icon" sizes="57x57" href="images/touchicons/apple-touch-icon-57-precomposed"/>
    <link rel="apple-touch-icon" sizes="114x114" href="assets/touchicons/apple-touch-icon-114-precomposed"/>
    <link rel="apple-touch-icon" sizes="72x72" href="assets/touchicons/apple-touch-icon-72-precomposed"/>
    <link rel="apple-touch-icon" sizes="144x144" href="assets/touchicons/apple-touch-icon-144-precomposed"/>


    <link rel="stylesheet" href="{{ elixir('assets/css/styles.css') }}">

    <style type="text/css">
        th, td {
            vertical-align: middle;
            text-align: center;
        }

        td{
            border: solid 1px #191f23;
        }

        table{
            background-color:#a0c6e5;
            width: 100%;
            text-align: center;
        }

        .panel-title {
            width: 100%;
            font-family: 微软雅黑;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
    </style>

</head>
<body>
申し込みが完了しました！ありがとうございます！
<a href="{{ route('posts.show', $post->id) }}"> {{ $post->title }} </a>Success!

<div class="panel panel-default" style="width: 100%;text-align: center;">
    @if(isset($postPhases) && count($postPhases) > 0)
        <div class="panel-title panel-info" style="">
            Detail
        </div>
        <div class="panel-body">
            <div class="table-responsive">

                <table border="0" cellspacing="1" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>阶段名称</th>
                        <th style="width: 30%;">时间</th>
                        <th>报名费用<br>(円)</th>
                        <th>名额限制</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postPhases as $postPhase)
                        <tr>
                            <td title="{{ '第'.$postPhase->serial_num.'阶段' }}">
                                {{ '第'.$postPhase->serial_num.'部' }}
                            </td>
                            <td style="width: 30%;"
                                title="{{ format_time($postPhase->start_time).'--'.format_time($postPhase->end_time) }}">
                                {{ format_time($postPhase->start_time)}} <br>
                                至<br>
                                {{ format_time($postPhase->end_time) }}
                            </td>
                            <td title="{{ $postPhase->registration_fee.'日元' }}">
                                {{ $postPhase->registration_fee }}
                            </td>
                            <td title="{{ $postPhase->register_limit.'人' }}">
                                {{ $postPhase->register_limit.'人' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @endif
</div>
@if(isset($applyTemplates) && count($applyTemplates) > 0)
    <div class="panel panel-default" style="width: 100%;text-align: center;">

        <div class="panel-title">
            Detail
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table border="0" cellspacing="1" class="table table-bordered">
                    <thead>
                    <tr>
                        @foreach($applyTemplates as $applyTemplate)
                            <th>{{ $applyTemplate->apply_attr->attr_slug }}</th>
                        @endforeach
                        <th>报名阶段</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($applyTemplates as $applyTemplate)
                            <td>
                                <a title="{{ $applicant->applicant_details[$applyTemplate->apply_attr_id]}}">
                                    {{$applicant->applicant_details[$applyTemplate->apply_attr_id]}}
                                </a>
                            </td>
                        @endforeach
                        <td>
                            <a>
                                @foreach($applicant->applicant_phases as $phase)
                                    @foreach($postPhases as $postPhase)
                                        @if($phase->post_phase_id == $postPhase->id)
                                            {{ '第'.$postPhase->serial_num.'部' }}
                                        @endif
                                    @endforeach
                                    <br>
                                @endforeach
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endif
</body>

</html>