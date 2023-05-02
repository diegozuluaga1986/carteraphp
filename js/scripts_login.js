$(document).on('click', '.login_button', function(e){
    //xajax_dologin(xajax.getFormValues('login_form'));
    var params = '';
    queue_global('&controlador=login&accion=sing_up&', $( "#login_form" ).serialize(), '', after_request_login);
    $('.btn').button('loading');
    return false;

});
$(document).on('click', '#forgot_button', function(e){
    //xajax_forgot(xajax.getFormValues('forgot_form'));
    $('.btn').button('loading');
    return false;
});
function after_request_login(JSON){
    if(JSON.validacion == 'ok'){
        document.location.href ="";
    }else{
        $('.login_button').removeAttr('disabled');
        $('.login_button').removeClass('disabled');
        $('.login_button').html('Sign In');

        $('.msn').html('<div class="alert alert-block alert-danger fade in"><a class="close" data-dismiss="alert" href="#" style="margin-top: -3px;">×</a><p><strong id="label_login_error_legend">'+JSON.msn+'</strong></p></div>');
    }
}
function queue_global(target,params,file,funct){
    jQuery.ajaxQueue({
        url: file+'?target='+target+params,
        type: "POST",
        async: true,
        cache: false,
        dataType: 'json',
        success: function( result ) {
           funct(result);
        }
    });
}

$(document).on('keyup','.field_username',function(e) {
    if (e.which == 13) {
        $('.login_button').click();
    }
    $('.msn').html('');
});

$(document).on('keyup','.field_password',function(e) {
    if (e.which == 13) {
        $('.login_button').click();
    }
    $('.msn').html('');
});