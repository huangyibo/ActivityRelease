/**
 * Created by bob on 2017/5/24.
 */

/**
 *
 * (1) 活动报名信息
 * (2) 活动展示信息
 * (3) 活动提交
 *
 */
function isEmpty(str) {
    if (str === null || str === '' || str === undefined) {
        return true;
    }
    return false;
}

function getApplicants() {
    var result = true;
    
}

function getPostId() {
    return $('input[name=post_id]').val();
}

function getSelectedPostPhases() {
    var postPhases = [];
    $("input[name='post_phase']:checkbox").each(function () {
        if (this.checked){
            var postPhase = {};
            postPhase['id'] = $(this).val();
            postPhases.push(postPhase);
        }
    });
    return postPhases;
}

function getPostPhaseSum() {
    return $("input[name='post_phase']:checkbox").length;
}

function getApplyAttrs() {
    var applyAttrs = [];
    var result = true;
    $('#apply_attr_info .form-group input').each(function () {
        var applyAttr = {};
        applyAttr['id'] = $(this).attr('id');
        applyAttr['name'] = $(this).attr('name');
        applyAttr['value'] = $.trim($(this).val());
        applyAttr['is_required'] = !isEmpty($(this).attr('required'));
        if(applyAttr['is_required'] == true && isEmpty(applyAttr['value'])){
            result = false;
            $('#form_group_'+applyAttr['name']).removeClass('has-success').addClass('has-error');
            $('#help_block_'+applyAttr['name']).removeClass('hidden');
        }else {
            $('#form_group_'+applyAttr['name']).removeClass('has-error').addClass('has-success');
            $('#help_block_'+applyAttr['name']).addClass('hidden');
        }
        applyAttrs.push(applyAttr);
    });
    if(!result){
        return false;
    }
    return applyAttrs;
}

function getApplicantFormData(postPhases,applyAttrs) {
    var formData = new FormData();
    formData.append('post_id', getPostId());
    formData.append('post_phases', JSON.stringify(postPhases));
    formData.append('apply_attrs', JSON.stringify(applyAttrs));
    return formData;
}

function clearApplyModal() {
    $('input[type=checkbox]:checked').each(function () {
       $(this).attr('checked', false);
    });

    $('input.form-control').each(function () {
        $(this).val('');
    });
    $('#apply_attr_info .form-group').each(function () {
       $(this).removeClass('has-success').removeClass('has-error');
    });

}

function ajaxSubmitApplicant(url) {
    var postPhases = getSelectedPostPhases();
    var applyAttrs = getApplyAttrs();
    if((getPostPhaseSum()>0 && postPhases.length==0)
        || applyAttrs == false){
        return;
    }else {
        $('#btn_apply_post_submit').addClass('disabled');
        var formData = getApplicantFormData(postPhases, applyAttrs);

        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $('#btn_apply_post_submit').removeClass('disabled');
                if (data.status == 'ok'){
                    var apply_num = text($('#apply_num'));
                    var apply_num = Number(apply_num) + Number(1);
                    $('#apply_num').text(apply_num);
                    $('#apply_join').modal('hide');
                    clearApplyModal();
                    console.log('flag:'+data.flag);
                    swal("报名成功!", "报名信息已经发送到您的邮箱，请查收!", "success");
                    // success_prompt('报名成功！<br/>活动报名信息已经发送到您的邮箱，请查收！', 1500);
                    // window.location.reload();
                }else{
                    $('#apply-post-alert-danger').text('活动报名失败，您所处的网络不稳定！');
                    fail_prompt('活动报名失败，您所处的网络不稳定！', 1500);
                    $('#apply-post-alert-danger').removeClass('hidden');
                    // window.location.reload();
                }
            },
            error: function () {
                $('#btn_apply_post_submit').removeClass('disabled');
                $('#apply-post-alert-danger').text('您所处的网络不稳定！');
                $('#apply-post-alert-danger').removeClass('hidden');
                fail_prompt('活动报名失败，您所处的网络不稳定！', 1500);
            }
        });
    }

}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 验证报名表单必选项
    $('#apply_attr_info .form-group input').each(function () {
        $(this).focusout(function () {
            var value = $.trim($(this).val());
            var name = $(this).attr('name');
            var isRequired = $(this).attr('required');
            if(!isEmpty(isRequired) && isEmpty(value)){
                $('#form_group_'+name).removeClass('has-success').addClass('has-error');
                $('#help_block_'+name).removeClass('hidden');
            }else{
                $('#form_group_'+name).removeClass('has-error').addClass('has-success');
                $('#help_block_'+name).addClass('hidden');
            }
        });
    });

    $('#btn_apply_post_submit').click(function () {
        if($('#apply-post-alert-danger').hasClass('hidden')==false){
            $('#apply-post-alert-danger').addClass('hidden');
        }
        var url = $('form')[0].action;
        console.log(url);
        ajaxSubmitApplicant(url);
    });

});
