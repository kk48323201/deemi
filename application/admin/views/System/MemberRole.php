<?php $this->load->view('Common/header.php');?>
<table id="MainTable"></table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
getListData();
function getListData(){
$("#MainTable").datagrid({  
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('System/MemberRole')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'RoleID',align:'left',title:'编号'},
		{field:'RoleName',align:'left',width:'130',title:'角色名称'},
		{field:'DirectRate',width:80,title:'直接佣金比例（%）'},
		{field:'DndirectRate',width:80,title:'间接佣金比例（%）'},
		{field:'IsFans',width:'60',align:'center',title:'粉丝权限',formatter:function(val,row){
			if(val=='1'){
				return '<i class="fa fa-check"></i>';
			}else{
				return '<i class="fa fa-remove"></i>';
			}
		}},
		{field:'DcAddress',width:60,align:'center',title:'优惠地址',formatter:function(val,row){
			if(val=='1'){
				return '<i class="fa fa-check"></i>';
			}else{
				return '<i class="fa fa-remove"></i>';
			}
		}},
		{field:'Manage',width:60,align:'center',title:'管理权限',formatter:function(val,row){
			if(val=='1'){
				return '<i class="fa fa-check"></i>';
			}else{
				return '<i class="fa fa-remove"></i>';
			}
		}},
		{field:'ShowMap',width:60,align:'center',title:'地图展示',formatter:function(val,row){
			if(val=='1'){
				return '<i class="fa fa-check"></i>';
			}else{
				return '<i class="fa fa-remove"></i>';
			}
		}},
		{field:'Operation',title:'操作',width:180,formatter:function(val,row){
			html = "";
			html += '<a href="javascript:editData('+row.RoleID+');" class="easyui-linkbutton l-btn l-btn-small btn-text" style="padding:3px 5px;">编辑</a>';
			return html;
		}}
	]]
});	
}

function editData(){
	onResetGroup();
	var row = $('#MainTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('MainForm');
	var obj = $("#MainForm").dialog({
		title : '编辑',
		resizable : true,
		method : 'post',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('System/MemberRole?do=edit')?>&RoleID="+row.RoleID,
		buttons:[{
			text:'保存',
			iconCls: 'icon-save',
			handler:function(){
				onSubmitGroup();
			}
		},{
			text:'取消',
			iconCls: 'icon-cancel',
			handler:function(){
				onResetGroup();
			}
		}]
	});
}
/**********常用方法**********/
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('System/MemberRole')?>?do=save",
		onSubmit : function(){
			$.messager.progress({'text':'正在保存数据,请稍后......', showType:'fade'});
			rs = $(this).form('validate');
			if(!rs){$.messager.progress('close');}
			return rs;
		},
		success : function(str) {
		   $.messager.progress('close');
		   obj = eval('(' + str + ')');
		   if(obj.code == '200'){
		   	 $.messager.alert('信息','<div align="center">操作成功</div>');
			 $('#MainTable').datagrid('reload');
			 onResetGroup();
		   }else{
		   	 $.messager.alert('error','系统发生错误','error');
		   }
		}
	});
}
function onResetGroup() {
	$("#MainForm").dialog('destroy');
}
</script>