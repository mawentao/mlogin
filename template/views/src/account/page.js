define(function(require){
	/* 权限控制 */
    var o={};
    o.execute = function(){
		require("./grid").init();
    };
    return o;
});
