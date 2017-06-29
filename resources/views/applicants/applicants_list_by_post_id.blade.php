<ol class="breadcrumb">
    <li><a class="user-center-link" title="个人中心" href="{{ url('users/'.$user->id.'/posts/released') }}">个人中心</a></li>
    <li class="active">{{ $post->title.' - ( '.$post->apply_num.'人报名 )' }}</li>
</ol>

<div class="panel panel-default">
    @if(isset($postPhases) && count($postPhases) > 0)
        <div class="panel-title panel-info">
            活动阶段详情
        </div>
        <div class="panel-body">
            <div class="table-responsive">

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>阶段名称</th>
                        <th style="width: 30%;">时间</th>
                        <th>报名费用<br>(单位/日元)</th>
                        <th>名额限制</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postPhases as $postPhase)
                        <tr>
                            <td title="{{ '第'.$postPhase->serial_num.'阶段' }}">
                                {{ '第'.$postPhase->serial_num.'阶段' }}
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
    <div class="panel panel-default">

        <div class="panel-title">
            活动报名详情
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        @foreach($applyTemplates as $applyTemplate)
                            @if($applyTemplate->apply_attr->attr_name == 'email')
                                <th style="width: 30%;">{{ $applyTemplate->apply_attr->attr_slug }}</th>
                            @else
                                <th>{{ $applyTemplate->apply_attr->attr_slug }}</th>
                            @endif

                        @endforeach
                        <th>报名阶段</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applicants as $applicant)
                        <tr>
                            @foreach($applyTemplates as $applyTemplate)
                                @if($applyTemplate->apply_attr->attr_name == 'email')
                                    <td style="width:30%;">
                                @else
                                    <td>
                                @endif

                                    @if(isset($applicant->applicant_details[$applyTemplate->apply_attr_id]))
                                        <a title="{{$applicant->applicant_details[$applyTemplate->apply_attr_id]}}">
                                            {{$applicant->applicant_details[$applyTemplate->apply_attr_id]}}
                                        </a>
                                    @else
                                        <a title="">
                                            无
                                        </a>
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <a>
                                    @foreach($applicant->applicant_phases as $phase)
                                        @foreach($postPhases as $postPhase)
                                            @if($phase->post_phase_id == $postPhase->id)
                                                {{ '第'.$postPhase->serial_num.'阶段' }}
                                            @endif
                                        @endforeach
                                        <br>
                                    @endforeach
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="panel-footer" style="width: 100%;">
                <span class="pull-right">
                    {!! $applicants->render() !!}
                </span>
        </div>
    </div>
@else
    <span style="color: red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;该活动不需要线上报名。</span>
@endif
