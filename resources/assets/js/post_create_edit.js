/**
 * Created by bob on 2017/5/22.
 */

/**
 *  （1）活动阶段设置 （2）设置报名要收集的信息
 *
 */

function delPostPhase(id) {
    var id = '#' + id;
    var postPhaseIdDivs = $(id + ' > .post_phase_id');
    if (postPhaseIdDivs.length > 0) {  // ajax delete post phase by post_phase_id
        var postPhaseId = Number(text(postPhaseIdDivs[0]));
        delPostPhaseAjax(id, postPhaseId);
    } else {  // natively delete post phase by index
        delPostPhaseNative(id);
    }
}

function delPostPhaseWithThis(obj) {
    var id = '#' + obj.parentNode.parentNode.id;
    var postPhaseIdDivs = $(id + ' > .post_phase_id');
    if (postPhaseIdDivs.length > 0) {  // ajax delete post phase by post_phase_id
        var postPhaseId = Number(text(postPhaseIdDivs[0]));
        delPostPhaseAjax(id, postPhaseId);
    } else {  // natively delete post phase by index
        delPostPhaseNative(id);
    }
}

function delPostPhaseNative(postPhaseItemDivId) {
    $(postPhaseItemDivId).remove();
    updatePostPhaseAfterDelete();
}

function delPostPhaseAjax(postPhaseItemDivId, postPhaseId) {
    $.ajax({
        type: 'delete',
        url: '/post_phases/' + postPhaseId,
        dataType: 'json',
        contentType: false,
        processData: false,
        async: true,
        success: function (data) {
            if (data.status == 'ok') {
                delPostPhaseNative(postPhaseItemDivId);
                swal("正常に削除!", "活性相は正常に削除します!", "success");
            } else {
                swal("活性相は削除できませんでした!", "あなたは、ネットワークが不安定です！", "error");
            }
        },
        error: function (e) {
            swal("活性相は削除できませんでした!", "あなたは、ネットワークが不安定です！", "error");
        }
    });
}

function updatePostPhaseAfterDelete() {
    var phaseSerialNumDivs = document.getElementsByClassName('form_input_serial_num');
    var sumOfItems = phaseSerialNumDivs.length;
    for (i = 0; i < sumOfItems; i++) {
        phaseSerialNumDivs[i].innerHTML = i + 1;
        var id = "post_phase_item_" + (i + 1);
        phaseSerialNumDivs[i].parentNode.id = id;
    }
}

function addPostPhase() {
    var post_phase_div = $('#post_phase_list');
    var sumOfItems = computeSumOfPostPhaseItems();
    var currentIndex = sumOfItems + 1;
    var currentDivId = "post_phase_item_" + currentIndex;

    var html = '<div class="post_phase_item" id="post_phase_item_'+ currentIndex +'">';
    html += '<div class="form_input_phase form_input_serial_num">'+ currentIndex +'</div>';
    html += '<div class="form_input_phase form_input_phase_name"><input type="text" id="post_phase_1_name" class="post_phase_name" maxlength="20" placeholder="输入阶段名称" value=""></div>';
    html += '<div class="form_input_phase form_input_phase_time">' +
        '<input type="datetime-local" id="post_phase_'+ currentIndex + '_start_time" class="post_phase_time" placeholder="阶段起始时间" value="">'
        + '<i class="fa fa-minus" style="color: #666;font-size: 14px"></i>' +
        '<input type="datetime-local" id="post_phase_'+ currentIndex +'_end_time" class="post_phase_time" placeholder="阶段结束时间" value=""></div>';
    html += '<div class="form_input_phase form_input_phase_fee"><input type="text" id="post_phase_'+ currentIndex +'_fee" class="post_phase_fee" maxlength="7" placeholder="免费请填0" value="0"></div>';
    html += '<div class="form_input_phase form_input_phase_people_limit">' +
        '<input type="text" id="post_phase_'+ currentIndex
        +'_people_limit" class="post_phase_people_limit" maxlength="20" placeholder="不填则无限制"'
        + ' value="0"></div>';
    html += '<div class="form_input_phase form_input_phase_operator"><a href="javascript:void(0)"'
        +' onclick="delPostPhaseWithThis(this)"><i class="fa fa-trash" style="font-size: 16px;" aria-hidden="true"></i></a></div>';
    html += '</div>';
    post_phase_div.append(html);
}

function computeSumOfPostPhaseItems() {
    // var post_phase_div = $('#post_phase_list');
    var sumOfItems = document.getElementsByClassName('post_phase_item').length;
    return sumOfItems;
}

function selectApplyTemplateAttrOption(obj) {
    var attrOptionElement = obj.getElementsByClassName('fa')[0];
    if (attrOptionElement.classList.contains('selected') == true) {
        attrOptionElement.classList.remove("selected");
    } else {
        attrOptionElement.classList.add('selected')
    }
}

/**
 * 活动发布与更新设置
 */
function isEmpty(str) {
    if (str === null || str === '' || str === undefined) {
        return true;
    }
    return false;
}

//兼容浏览器获取节点文本的方法
function text(e) {
    var t = "";

    //如果传入的是元素，则继续遍历其子元素
    //否则假定它是一个数组
    e = e.childNodes || e;

    //遍历所有子节点
    for (var j = 0; j < e.length; j++) {
        //如果不是元素，追加其文本值
        //否则，递归遍历所有元素的子节点
        t += e[j].nodeType != 1 ?
            e[j].nodeValue : text(e[j].childNodes);
    }
    //返回区配的文本
    return t;
}

function invalidatePostInfo() {
    if (invalidatePostCategory() == true
        && invalidatePostTitle() == true
        && invalidatePostCover() == true
        && invalidatePostExcerpt() == true
        && invalidatePostDetail() == true
        && invalidatePostPhases() == true
        && invalidateApplyTemplate() == true) {
        return true;
    }
    return false;
}

function invalidatePostCategory() {
    var category = $('#category-select option:selected').val();
    if (isEmpty(category)) {
        $('#post_category_note').removeClass('hidden');
        $('#post_category_fg').removeClass('has-success').addClass('has-error');
        return false;
    } else {
        $('#post_category_note').addClass('hidden');
        $('#post_category_fg').removeClass('has-error').addClass('has-success');
        return true;
    }
}

function invalidatePostTitle() {
    var postTitle = $('input[name=title]').val().trim();
    if (isEmpty(postTitle)) {
        $('#post_title_note').removeClass('hidden');
        $('#post_title_fg').removeClass('has-success').addClass('has-error');
        return false;
    } else {
        $('#post_title_note').addClass('hidden');
        $('#post_title_fg').removeClass('has-error').addClass('has-success');
        return true;
    }
}

function invalidatePostCover() {
    var postCover = $('input[name=cover]').val().trim();
    if (isEmpty(postCover)) {
        $('#post_cover_note').removeClass('hidden');
        $('#post_cover_fg').removeClass('has-success').addClass('has-error');
        return false;
    } else {
        $('#post_cover_note').addClass('hidden');
        $('#post_cover_fg').removeClass('has-error').addClass('has-success');
        return true;
    }
}

function invalidatePostExcerpt() {
    var postExcerpt = $('input[name=excerpt]').val().trim();
    if (isEmpty(postExcerpt)) {
        $('#post_excerpt_note').removeClass('hidden');
        $('#post_excerpt_fg').removeClass('has-success').addClass('has-error');
        return false;
    } else {
        $('#post_excerpt_note').addClass('hidden');
        $('#post_excerpt_fg').removeClass('has-error').addClass('has-success');
        return true;
    }
}

function invalidatePostDetail() {
    var postDetail = $('#body_original_textarea').val().trim();
    console.log('postDetail:' + postDetail);
    if (isEmpty(postDetail)) {
        $('#post_detail_note').removeClass('hidden');
        $('#post_detail_fg').removeClass('has-success').addClass('has-error');
        return false;
    } else {
        $('#post_detail_note').addClass('hidden');
        $('#post_detail_fg').removeClass('has-error').addClass('has-success');
        return true;
    }
}

function invalidatePostPhases() {
    var postPhaseItems = $('.post_phase_item');
    var result = true;
    for (i = 0; i < postPhaseItems.length; i++) {
        var postPhaseTimeDiv = postPhaseItems[i].getElementsByClassName('form_input_phase_time')[0];
        var phaseTimeInputs = postPhaseTimeDiv.getElementsByTagName('input');
        var phaseStartTime = $.trim(phaseTimeInputs[0].value);
        var phaseEndTime = $.trim(phaseTimeInputs[1].value);
        if (isEmpty(phaseStartTime) || isEmpty(phaseEndTime)) {
            result = false;
            $('#post_detail_note').removeClass('hidden');
            $('#post_detail_note>span').text('活动阶段的起始时间或结束时间不能为空');
            break;
        }
        var phaseFeeDiv = postPhaseItems[i].getElementsByClassName('form_input_phase_fee')[0];
        var phaseFeeInput = phaseFeeDiv.getElementsByTagName('input')[0];
        var phaseFee = $.trim(phaseFeeInput.value);
        if (isEmpty(phaseFee)) {
            result = false;
            $('#post_detail_note').removeClass('hidden');
            $('#post_detail_note>span').text('活动阶段的报名费用不能为空，免费请填0');
            break;
        }

    }
    if (result == true) {
        $('#post_detail_note').addClass('hidden');
    }
    return result;
}

function invalidateApplyTemplate() {
    var result = false;
    var postApplyTemplateItems = $('.post_apply_template>.post_apply_template_item');
    for (i = 0; i < postApplyTemplateItems.length; i++) {
        var applyAttrOption = postApplyTemplateItems[i].getElementsByClassName('apply_template_attr_option')[0]
            .getElementsByClassName('fa')[0];
        if (applyAttrOption.classList.contains('selected')) {
            result = true;
            $('#post_detail_note').addClass('hidden');
            break;
        }
    }
    if (result == false) {
        $('#post_detail_note').removeClass('hidden');
    }
    return result;

}

function getPostPhases() {
    var postPhaseItems = $('#post_phase_list>.post_phase_item');
    var postPhases = [];
    for (i = 0; i < postPhaseItems.length; i++) {
        var postPhase = {};
        var postPhaseIdDivs = postPhaseItems[i].getElementsByClassName('post_phase_id');
        if (!isEmpty(postPhaseIdDivs) && postPhaseIdDivs.length > 0) {
            postPhase['id'] = text(postPhaseIdDivs[0]);
        }
        var serial_num_div = postPhaseItems[i].getElementsByClassName('form_input_serial_num')[0];
        var serial_num = text(serial_num_div);
        console.log('serial_num:' + serial_num);
        var phase_name_div = postPhaseItems[i].getElementsByClassName('form_input_phase_name')[0];
        var phase_name_input = phase_name_div.getElementsByTagName('input')[0];
        var phase_name = phase_name_input.value;

        var postPhaseTimeDiv = postPhaseItems[i].getElementsByClassName('form_input_phase_time')[0];
        var postPhaseTimeInputs = postPhaseTimeDiv.getElementsByTagName('input');
        var startTime = postPhaseTimeInputs[0].value;
        var endTime = postPhaseTimeInputs[1].value;
        var phaseFee = postPhaseItems[i].getElementsByClassName('form_input_phase_fee')[0]
            .getElementsByTagName('input')[0].value;
        phaseFee = isEmpty(phaseFee) ? 0 : phaseFee;
        var phaseLimit = postPhaseItems[i].getElementsByClassName('form_input_phase_people_limit')[0]
            .getElementsByTagName('input')[0].value;
        phaseLimit = isEmpty(phaseLimit) ? 0 : phaseLimit;

        postPhase['serial_num'] = isEmpty(serial_num) ? i + 1 : serial_num;
        postPhase['phase_name'] = phase_name;
        postPhase['registration_fee'] = phaseFee;
        postPhase['register_limit'] = phaseLimit;
        postPhase['start_time'] = startTime;
        postPhase['end_time'] = endTime;
        postPhases.push(postPhase);
    }
    return postPhases;
}

function getApplyTemplate() {
    var postApplyAttrItems = $('.post_apply_template>.post_apply_template_item');
    var postApplyAttrs = [];
    for (i = 0; i < postApplyAttrItems.length; i++) {
        var applyAttrOption = postApplyAttrItems[i].getElementsByClassName('apply_template_attr_option')[0]
            .getElementsByClassName('fa')[0];
        if (applyAttrOption.classList.contains('selected')) {
            var applyAttr = {};
            applyAttr['id'] = postApplyAttrItems[i].id;
            postApplyAttrs.push(applyAttr);
        }
    }
    return postApplyAttrs;
}

function getPostInfo() {
    var post = {
        // '_token':$('input[name=_token]').val(),
        'category_id': $('#category-select option:selected').val(),
        'title': $('input[name=title]').val(),
        'cover': $('input[name=cover]').val(),
        'excerpt': $('input[name=excerpt]').val(),
        'body_original': $('#body_original_textarea').val().trim(),
        'post_phases': getPostPhases(),
        'apply_templates': getApplyTemplate(),
        'cover_image': $('input[name=cover_image]').files[0]
    };
    return post;
}

function getPostFormDataForCreate() {
    var formData = new FormData();
    formData.append('category_id', $('#category-select option:selected').val());
    formData.append('title', $.trim($('input[name=title]').val()));
    formData.append('cover', $.trim($('input[name=cover]').val()));
    formData.append('excerpt', $.trim($('input[name=excerpt]').val()));
    formData.append('body_original', $('#body_original_textarea').val().trim());
    formData.append('post_phases', JSON.stringify(getPostPhases()));
    formData.append('apply_templates', JSON.stringify(getApplyTemplate()));
    formData.append('cover_image', document.getElementById("cover_image").files[0]);
    return formData;
}

function ajaxCreatePost(url) {
    var postFormData = getPostFormDataForCreate();

    $.ajax({
        type: 'post',
        url: url,
        enctype: 'multipart/form-data',
        dataType: "json",
        contentType: false,
        processData: false,
        /*headers: {
         'X-CSRF-Token': $('meta[name="_token"]').attr('content')
         },*/
        data: postFormData,
        async: true,
        success: function (data) {
            $('#post-create-submit').removeClass('disabled');
            if (data.status == 'ok') {
                var post = data.post;
                // var redirectUrl = "{{ route('posts.show', ["+ post['id'] + "]) }}";
                var redirectUrl = '/posts/' + post.id;
                window.location.href = redirectUrl;
            } else {
                $('#post-alert-danger').text('活動では、ネットワークが不安定であり、公開することができませんでした！！');
                $('#post-alert-danger').removeClass('hidden');
            }
        },
        error: function (e) {
            $('#post-create-submit').removeClass('disabled');
            $('#post-alert-danger').text('ネットワークが不安定でございいます！');
            $('#post-alert-danger').removeClass('hidden');
        }
    });
}

function getPostPhasesForUpdate() {
    return getPostPhases();
}

function getApplyTempalteForUpdate() {
    var postApplyAttrItems = $('.post_apply_template>.post_apply_template_item');
    var selectedPostApplyAttrs = [];
    var submitedApplyTemplates = [];
    for (i = 0; i < postApplyAttrItems.length; i++) {
        var applyAttrOption = postApplyAttrItems[i].getElementsByClassName('apply_template_attr_option')[0]
            .getElementsByClassName('fa')[0];
        if (applyAttrOption.classList.contains('selected')) {
            var applyAttr = {};
            applyAttr['id'] = postApplyAttrItems[i].id;
            selectedPostApplyAttrs.push(applyAttr);
        }
        var applyTemplateIdDivs = postApplyAttrItems[i].getElementsByClassName('apply_template_id');
        if (!isEmpty(applyTemplateIdDivs) && applyTemplateIdDivs.length > 0) {
            var applyTemplateId = Number(text(applyTemplateIdDivs[0]));
            var applyAttrId = Number(postApplyAttrItems[i].id);
            var applyTemplate = {};
            applyTemplate['id'] = applyTemplateId;
            applyTemplate['apply_attr_id'] = applyAttrId;
            submitedApplyTemplates.push(applyTemplate);
        }
    }
    var addedApplyAttrs = [];
    var deletedApplyTemplates = [];
    if (submitedApplyTemplates.length > 0) {
        for (i = 0; i < submitedApplyTemplates.length; i++) {
            var result = true;
            for (j = 0; j < selectedPostApplyAttrs.length; j++) {
                if(selectedPostApplyAttrs[j]['id'] == submitedApplyTemplates[i]['apply_attr_id']){
                    result = false;
                    break;
                }
            }
            if(result){
                deletedApplyTemplates.push(submitedApplyTemplates[i]);
            }
        }
        for (j = 0; j < selectedPostApplyAttrs.length; j++){
            var result = true;
            for (i = 0; i < submitedApplyTemplates.length; i++){
                if(selectedPostApplyAttrs[j]['id'] == submitedApplyTemplates[i]['apply_attr_id']){
                    result = false;
                    break;
                }
            }
            if(result){
                addedApplyAttrs.push(selectedPostApplyAttrs[j]);
            }
        }
    }
    var applyTemplates = {
        'addApplyAttrs': addedApplyAttrs,
        'deleteApplyTemplates': deletedApplyTemplates
    };

    return applyTemplates;
}

function getPostFormDataForUpdate() {
    var formData = new FormData();
    formData.append('category_id', $('#category-select option:selected').val());
    formData.append('title', $.trim($('input[name=title]').val()));
    var cover = $.trim($('input[name=cover]').val());
    if (!isEmpty(cover)) {
        formData.append('cover', cover);
        // formData.append('cover_image', document.getElementById("cover_image").files[0]);
    }
    var cover_image = document.getElementById("cover_image").files[0];
    if(!isEmpty(cover_image)){
        formData.append('cover_image', document.getElementById("cover_image").files[0]);
    }
    formData.append('excerpt', $.trim($('input[name=excerpt]').val()));
    formData.append('body_original', $('#body_original_textarea').val().trim());
    formData.append('post_phases', JSON.stringify(getPostPhasesForUpdate()));
    formData.append('apply_templates', JSON.stringify(getApplyTempalteForUpdate()));
    return formData;
}

function ajaxUpdatePost(url) {
    var postFormData = getPostFormDataForUpdate();
    postFormData.append('_method', $.trim($('input[name=_method]').val()));

    $.ajax({
        type: 'post',
        url: url,
        enctype: 'multipart/form-data',
        dataType: "json",
        contentType: false,
        processData: false,
        data: postFormData,
        async: true,
        success: function (data) {
            $('#post-create-submit').removeClass('disabled');
            if(data.status == 'ok'){
                var post = data.post;
                swal("Success!", "正常に更新活性プロフィール!", "success");
                var redirectUrl = '/posts/' + post.id;
                window.location.href = redirectUrl;
            }else {
                swal("更新に失敗しました!", "あなたは、ネットワークが不安定です!", "error");
            }
        },
        error: function (e) {
            $('#post-create-submit').removeClass('disabled');
            $('#post-alert-danger').text('あなたは、ネットワークが不安定です！');
            $('#post-alert-danger').removeClass('hidden');
            swal("更新に失敗しました!", "あなたは、ネットワークが不安定です!", "error");
        }
    });
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#category-select').focusout(function () {
        invalidatePostCategory();
    });

    $('input[name=title]').focusout(function () {
        invalidatePostTitle();
    });

    $('input[name=cover]').change(function () {
        invalidatePostCover();
    });

    $('input[name=excerpt]').focusout(function () {
        invalidatePostExcerpt();
    });

    $('input[name=body_original]').focusout(function () {
        invalidatePostDetail();
    });

    $('#body_original_textarea').change(function () {
        invalidatePostDetail();
    });


    $('#post-create-submit').click(function () {
        if ($('#post-alert-danger').hasClass('hidden') == false) {
            $('#post-alert-danger').addClass('hidden');
        }
        var isValid = invalidatePostInfo();
        if (isValid === false) {
            return;
        } else {
            $('#post-create-submit').addClass('disabled');
            var formId = $('form')[0].id;
            var url = $('form')[0].action;
            // var url = document.getElementsByTagName('form')[0].action;
            if (formId.indexOf('create') != -1) { // create
                ajaxCreatePost(url);
            } else {   // update
                ajaxUpdatePost(url);
            }
        }
    });

});

