/**
 * 弹出式提示框，默认1.2秒自动消失
 * @param message 提示信息
 * @param style 提示样式，有alert-success、alert-danger、alert-warning、alert-info
 * @param time 消失时间
 */
var prompt = function (message, style, time) {
    style = (style === undefined) ? 'alert-success' : style;
    time = (time === undefined) ? 1200 : time;
    $('<div>')
        .appendTo('body')
        .addClass('alert ' + style)
        .html(message)
        .show()
        .delay(time)
        .fadeOut();
};

// 成功提示
var success_prompt = function (message, time) {
    prompt(message, 'alert-success', time);
};

// 失败提示
var fail_prompt = function (message, time) {
    prompt(message, 'alert-danger', time);
};

// 提醒
var warning_prompt = function (message, time) {
    prompt(message, 'alert-warning', time);
};

// 信息提示
var info_prompt = function (message, time) {
    prompt(message, 'alert-info', time);
};

function isEmpty(str) {
    if (str === null || str === '' || str === undefined) {
        return true;
    }
    return false;
}

//兼容浏览器获取节点文本的方法
function text(e)
{
    var t="";

    //如果传入的是元素，则继续遍历其子元素
    //否则假定它是一个数组
    e=e.childNodes||e;

    //遍历所有子节点
    for(var j=0;j<e.length;j++){
        //如果不是元素，追加其文本值
        //否则，递归遍历所有元素的子节点
        t+=e[j].nodeType!=1?
            e[j].nodeValue:text(e[j].childNodes);
    }
    //返回区配的文本
    return t;
}

(function () {

    /*var window_width = $(window).width();
     var window_height = $(window).height();
     $('body').css({
     "width":window_width,
     "height":window_height,
     "overflow":"scroll"
     });

     Resize = function () {
     window_width = $(window).width();
     if(window_width<=1000){
     $("body").css({
     "overflow":"auto"
     });
     }

     }*/
    iziToast.settings({
        timeout: 10000,
        resetOnHover: true,
        icon: 'material-icons',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        position: 'center',
        onOpen: function(){
            console.log('callback abriu!');
        },
        onClose: function(){
            console.log("callback fechou!");
        }
    });


    /* 吸顶条Javascript代码片段 */
    function scrollside() {
        var scrollHeight = $(window).scrollTop();
        var navbarHeight = 100;
        return (scrollHeight > navbarHeight) ? true : false;
    }

    window.onscroll = function () {
        var $navbar = $("#top-navbar");

        if (scrollside()) {
            $navbar.addClass("nav_scroll");
        } else {
            $navbar.removeClass("nav_scroll");
        }
    }

    window.onload = function () {
        var $navbar = $("#top-navbar");
        $navbar.removeClass("nav_scroll");
    }

    function promptRegister() {
        swal({
                title: "订阅 Laravel 资讯",
                text: "请前往「Laravel China 社区」注册账号，即可自动订阅「Laravel 资讯」。",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#21BA45",
                confirmButtonText: "前往注册",
                cancelButtonText: "已注册",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = 'https://laravel-china.org/login-required';
                } else {
                    swal.close();
                    // fixing body wont scroll
                    document.body.style.overflow = "scroll";
                }
            });
    }

    // 订阅按钮点击
    $('#subscrib-btn').click(function () {
        promptRegister();
    });

    $('#subscribe-input').focus(function () {
        promptRegister();
    });



    // update user info
    /*$('#user-edit-submit').click(function (e) {
     var token = $('#_token').val();
     e.preventDefault();
     var form_action = $('#update-form').attr('action');

     var formData = {
     _token: token,
     // _method: $('#_method').val(),
     gender: $('#gender option:selected').val(),
     // email: $('#email').val(),
     real_name: $('#real_name').val(),
     company: $('#company').val(),
     weibo_id: $('#weibo_id').val(),
     personal_website: $('#personal_website').val(),
     introduction: $('#introduction').val()
     };

     $.ajax({
     type: 'PUT',
     url: form_action,
     data: formData,
     dataType: 'json',
     success: function (data) {
     console.log('success');
     $('#update-user-alert-success-content').innerHTML = '用户资料更新成功!';
     // $('#update-user-alert-success').show().delay(2000).hide();
     },
     error: function (data) {
     console.log('error');
     var error = data.responseText;
     var content;
     if (error) {
     var index;
     for (index in error) {
     content = error[index];
     break;
     }
     } else {
     content = '系统内部错误!'
     }


     $('#update-user-alert-danger-content').innerHTML = content;
     $('#update-user-alert-success').show().delay(2000).hide();
     }
     });

     });*/

})();
