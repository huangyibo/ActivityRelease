<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')八雲社</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="活动发布系统。">
    <meta name="author" content="Bob">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/images/favicon.png">

    <link rel="apple-touch-icon" sizes="57x57" href="images/touchicons/apple-touch-icon-57-precomposed"/>
    <link rel="apple-touch-icon" sizes="114x114" href="assets/touchicons/apple-touch-icon-114-precomposed"/>
    <link rel="apple-touch-icon" sizes="72x72" href="assets/touchicons/apple-touch-icon-72-precomposed"/>
    <link rel="apple-touch-icon" sizes="144x144" href="assets/touchicons/apple-touch-icon-144-precomposed"/>

    <link rel="stylesheet" href="{{ elixir('assets/css/styles.css') }}">

    @yield('head-asset')

</head>
{{--onLoad="Resize()" onResize="Resize()"--}}
<body class="{{ route_class() }}-page">
<div class="alert"></div>
@include('layouts.partials.topnav')

<section class="mastwrap">

    <div class="container">

        @yield('content')
    </div>

</section>

@include('layouts.partials.footer')

<script src="{{ elixir('assets/js/scripts.js') }}" charset="utf-8"></script>

@yield('scripts')

@if (App::environment() == 'production')
    <script>
        ga('create', '{{ getenv('GA_Tracking_ID') }}', 'auto');
        ga('send', 'pageview');
    </script>

    <script>
        // Baidu link submit
        (function () {
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
@endif


</body>

</html>
