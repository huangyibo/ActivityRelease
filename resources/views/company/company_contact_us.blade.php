@extends('layouts.default')

@section('title', 'お問い合わせ' . ' | ')

@section('content')
    <div class="row colom-container">
        {{--<aside class="col-md-3 main-col">
            @include('company.partials._introduction_menu')
        </aside>--}}
        <main class="main-col">
            <div class="panel panel-default padding-md">

                <div class="panel-body">

                    <div class="block-header">
                        <h2>お問い合わせ </h2>
                    </div>

                    <div class="content-body">
                        <!-- 公司介绍：图片轮播 -->
                        @include('company.partials._contact_us')
                    </div>
                </div>
            </div>
        </main>

    </div>
@endsection