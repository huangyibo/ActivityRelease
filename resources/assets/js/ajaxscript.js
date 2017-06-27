/**
 * Created by bob on 2017/5/12.
 */

var submitContactUsInfoUrl = "/company/contact-us";

function isEmail( email_address )
{
    var regex = /^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g;
    if ( regex.test( email_address ) )
    {

        var user_name = email_address.replace( regex, "$1" );
        var domain_name = email_address.replace( regex, "$2" );
        return true;
    }
    else
    {
        return false;
    }
}

function invalidateContactInfo(){
    var name = $('input[name=name]').val().trim();
    if(isEmpty(name)){
        setErrorAlert("お名前是必須項目です！");
        return false;
    }
    var email = $('input[name=email]').val().trim();
    if(isEmpty(email)){
        setErrorAlert("メールアドレス是必須項目です！");
        return false;
    }
    if(!isEmail(email)){
        setErrorAlert("入力されたメールアドレスが有効ではありません！");
        return false;
    }

    var contact_content = $('#contact_content').val().trim();
    if(isEmpty(contact_content)){
        setErrorAlert("お問い合わせ内容是必須項目です！");
        return false;
    }
    hiddenErrorAlert();
    return true;
}

function closeAlert(){
    $('#contact-us-alert-danger').addClass('hidden');
    $('#contact-us-alert-success').addClass('hidden');
}

function isEmpty(str){
    if(str === null || str === '' || str === undefined){
        return true;
    }
    return false;
}

function setErrorAlert(str){
    $('#contact-us-alert-danger').removeClass('hidden');
    $('#contact-us-alert-danger').text('Error: ' + str);
}

function hiddenErrorAlert() {
    $('#contact-us-alert-danger').addClass('hidden');
    $('#contact-us-alert-danger').text('');
}

function clearContactForm() {
    $('input[name=name]').val(null);
    $('input[name=email]').val('');
    $('input[name=phone]').val('');
    $('input[name=company_name]').val('');
    $('#contact_type').val('お選びください');
    $('#contact_content').val('');
}


$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


   $("#btn_submit_contact_info").click(function () {
       closeAlert();
       var isValid = invalidateContactInfo();
       if(isValid === false)
           return;
       else {
           $("#btn_submit_contact_info").addClass('disabled');

           $.ajax({
               type:'post',
               url: submitContactUsInfoUrl,
               headers: {
                   'X-CSRF-Token': $('meta[name="_token"]').attr('content')
               },
               data: {
                   '_token':$('input[name=_token]').val(),
                   'name': $('input[name=name]').val(),
                   'email': $('input[name=email]').val(),
                   'phone': $('input[name=phone]').val(),
                   'company_name':$('input[name=company_name]').val(),
                   'contact_type': $('#contact_type option:selected').val(),
                   'contact_content': $('#contact_content').val()
               },
               success: function (data) {

                   if(data.status == 'ok'){
                       /*$('#contact-us-alert-success').removeClass('hidden');
                       $('#contact-us-alert-success').text('Send Successfully!');*/
                       clearContactForm();
                       swal("Success!", "あなたのメッセージが正常にコンサルティング会社の顧客サービスに送信されました!", "success");
                   }else {
                       setErrorAlert("Submit Failed!");
                       swal("送信に失敗しました!", "お使いのネットワークが不安定で、後で再送信してください!", "error");
                   }
                   $("#btn_submit_contact_info").removeClass('disabled');
               },
               error: function (e) {
                   setErrorAlert("Submit Failed!");
                   $("#btn_submit_contact_info").removeClass('disabled');
                   swal("送信に失敗しました!", "お使いのネットワークが不安定で、後で再送信してください!", "error");
               }
           });
       }


   });

});