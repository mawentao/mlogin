/* ajax封装 */
define(function(require){
    var _cache = {};
    var o = {};

    o.getAjaxUrl = function(module) {
        return v.ajaxapi+module;
    };

    o.ajaxrequest=function(method, url, params, callbackfun, sync) {
        //if(!noanimation) show_loading();
        jQuery.ajax({
            url: url,
            type: method,
            dataType: "json",
			async: !sync,
            data: params,
            complete: function(res) {
                //if(!noanimation) hide_loading();
            },
            success: function(res) {
                callbackfun(res);
                //console.log(json2str(res));
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var errmsg = "Error("+XMLHttpRequest.readyState+") : "+textStatus;
                alert(errmsg);
            }
        });
    };

    // POST方式提交Ajax请求
	o.post = function(cachekey, params, callbackfun, noanimation) {
        var url = o.getAjaxUrl(cachekey);
        o.ajaxrequest("post", url, params, callbackfun, noanimation);
    };

    // GET方式提交Ajax请求
    o.get = function(method, cachekey, params, callbackfun, noanimation) {
        var url = o.getAjaxUrl(cachekey);
        o.ajaxrequest("get", url, params, callbackfun, noanimation);
    };

    // 读取缓存，如果缓存不存在再ajax请求
    o.loadcache = function(cachekey, callbackfun, noanimation) {
        if (_cache[cachekey]) {
	        callbackfun(_cache[cachekey]);
        } else {
            this.post(cachekey, {}, function(res){
                _cache[cachekey] = res;
                callbackfun(res);
            }, noanimation);
        }
    };

    // 根据cachekey清除缓存
    o.unsetcache = function(cachekey) {
        _cache[cachekey] = null;
    };

    // 清除所有缓存
    o.clearcache = function() {
        _cache = {};
    };

    return o;
});
