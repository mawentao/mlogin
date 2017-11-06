define(function(require){
    /* resetpass page */
    var ajax=require('common/ajax');
    var o={};
    var logtxt = '';

    o.execute=function() {
        // 换一个验证码
        jQuery('#scodebtn').unbind('click').click(function(){
            jQuery(this).attr('src',dz.seccodeurl+'&tm='+time());
        });
        // 点击提交按钮
        jQuery('#subbtn').unbind('click').click(submit);
    };

    function submit() {
        var data = {
            oldpass  : mwt.get_text_value('fm-oldpass'),
            newpass  : mwt.get_text_value('fm-newpass1'),
            newpass2 : mwt.get_text_value('fm-newpass2')
        };
        if (data.newpass!=data.newpass2) {
            jQuery('#errmsgdiv').html('两次输入的密码不一致').show();
            return;
        }
        if (data.newpass==data.oldpass) {
            jQuery('#errmsgdiv').html('新密码与旧密码相同').show();
            return;
        }
        if (data.newpass.length<6) {
            jQuery('#errmsgdiv').html('密码不能少于6位').show();
            return;
        }
        if (logtxt=='') { logtxt = jQuery('#subbtn').html(); }
        jQuery('#errmsgdiv').html('').hide();
        jQuery('#subbtn').html('提交中...').attr('disabled','disabled');
        //print_r(data);
        ajax.post('uc&action=changepass',data,function(res){
            jQuery('#subbtn').html(logtxt).removeAttr('disabled');
            if (res.retcode!=0) {
                jQuery('#errmsgdiv').html(res.retmsg).show();
                jQuery('#subbtn').html('提交').click(submit);
            } else {
                MWT.alert('密码已修改，请使用新密码重新登录', function(){
                    window.location = dz.siteurl+'/member.php?mod=logging&action=login';
                }); 
            }   
        });
    }

    return o;
});
