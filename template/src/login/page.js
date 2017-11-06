define(function(require){
    /* login page */
    var ajax=require('common/ajax');
    var o={};
    var logtxt = '';

    o.execute=function() {
        // 换一个验证码
        jQuery('#scodebtn').unbind('click').click(function(){
            jQuery(this).attr('src',dz.seccodeurl+'&tm='+time());
        });
        // 点击登录按钮
        jQuery('#loginbtn').unbind('click').click(loginSubmit);
    };

    function loginSubmit() {
        jQuery('#errmsgdiv').html('').hide();
        var data = {
            username : mwt.get_text_value('fm-username'),
            userpass : mwt.get_text_value('fm-userpass'),
            seccode  : mwt.get_text_value('fm-scode')
        };
        if (logtxt=='') { logtxt = jQuery('#loginbtn').html(); }
        jQuery('#loginbtn').html('登录中...').attr('disabled','disabled');
        //print_r(data);
        ajax.post('uc&action=login',data,function(res){
            jQuery('#loginbtn').html(logtxt).removeAttr('disabled');
            if (res.retcode!=0) {
                jQuery('#errmsgdiv').html(res.retmsg).show();
            } else {
                window.location = dz.siteurl;
            }   
        }); 
    }

    return o;
});
