define(function(require){
	var ajax=require("ajax");
	var store,grid;

	function query() {
		store.baseParams = {
            key: mwt.get_value("so-key")
        };
        grid.load();
	}

    var o={};
    o.init = function(){
		store = new MWT.Store({
			proxy: new mwt.HttpProxy({
            	url: ajax.getAjaxUrl("admin&action=ucQuery")
			})
        });
		grid = new MWT.Grid({
            render      : "grid-div",
            store       : store,
            pagebar     : true, //!< false 表示不分页
            pageSize    : 50,
            multiSelect : false, 
            bordered    : false,
			striped     : true,
			tbarStyle   : 'margin-bottom:10px;',
			emptyMsg    : '查询为空',
			position    : 'fixed',
			bodyStyle: 'top:92px;bottom:37px;',
			tbar: [
				{type:'search',id:'so-key',width:300,handler:query,placeholder:'输入用户名'},
				'->',
				{label:'<i class="fa fa-plus"></i> 添加用户',class:'mwt-btn mwt-btn-success', handler:function(){
					window.open('admin.php?frames=yes&action=members&operation=add');
				}}
			],
            cm: new MWT.Grid.ColumnModel([
              {head:"用户ID", dataIndex:"uid", width:100, sort:true},
              {head:"用户名", dataIndex:"username", width:120, sort:true},
              {head:"用户组", dataIndex:"groupname", width:100, sort:true},
              {head:"用户邮箱", dataIndex:"email", width:300, sort:true, render:function(v){
				return '<a href="mailto:'+v+'">'+v+'</a>';
			  }},
              {head:"注册时间", dataIndex:"regdate", width:130, align:'center', sort:true, render:function(v){
                return date("Y-m-d H:i",v);
              }},
              {head:"操作", dataIndex:"status",align:'right',render:function(v,item){
				var rstpassbtn = '<a name="resetbtn" data-id="'+item.uid+'" class="mwt-btn mwt-btn-danger mwt-btn-xs" href="javascript:;">重置密码</a>';
				var btns = [rstpassbtn];
                return btns.join("&nbsp;&nbsp;");
              }}
            ])
        });
        grid.create();
		store.on('load',function(){
			// 重置密码
			jQuery('[name=resetbtn]').unbind('click').click(function(){
				var uid = jQuery(this).data('id');
				resetPass(uid);
			});
		});
		query();
    };

    // 重置用户密码
	function resetPass(uid) {
		if (mwt.confirm('确定要重置Ta的帐号密码吗？',function(confirmed){
			if (!confirmed) { return; }
			ajax.post("admin&action=ucResetPass",{uid:uid},function(res){
				if (res.retcode!=0) {
					mwt.notify(res.retmsg,1500,'danger');
				} else {
					MWT.alert(res.data);
				}
			});
		}));
	};

    return o;
});
