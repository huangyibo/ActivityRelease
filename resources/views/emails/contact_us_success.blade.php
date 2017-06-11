<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')八雲社活动发布平台</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="description" content="八雲社活动发布平台。">
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
尊敬的用户{{ $contactInfo->name }}通过 八雲社活动发布平台 向您咨询！

<div class="panel panel-default" style="width: 100%;text-align: center;">
    @if(isset($contactInfo))
        <div class="panel-title panel-info" style="">
            咨询内容详情
        </div>
        <div class="panel-body">
            <div class="table-responsive">

                <table border="0" cellspacing="1" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>名字</th>
                        <th>公司名称</th>
                        <th>邮箱地址</th>
                        <th>电话号码</th>
                        <th>联系范畴</th>
                        <th style="width: 30%;">询问内容</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td title="{{ $contactInfo->name }}">
                                {{ $contactInfo->name }}
                            </td>
                            <td
                                title="{{ $contactInfo->company_name }}">
                                {{ $contactInfo->company_name }}
                            </td>
                            <td title="{{ $contactInfo->email }}">
                                {{ $contactInfo->email }}
                            </td>
                            <td title="{{ $contactInfo->phone }}">
                                {{ $contactInfo->phone }}
                            </td>
                            <td title="{{ $contactInfo->contact_type }}">
                                {{ $contactInfo->contact_type }}
                            </td>
                            <td style="width: 30%;" title="{{ $contactInfo->contact_content }}">
                                {{ $contactInfo->contact_content }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    @endif
</div>

</body>

</html>