<?php $this->load->view('Common/header.php');?>
<div id="tb_main">
	<div class="search_bar_row">		
		<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" onClick="newData()">新增</a>
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" onClick="editData()">编辑</a>
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" onClick="delData()">删除</a>
	</div>
</div>
<table id="MainTable"></table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
getListData();
function getListData(){
$("#MainTable").datagrid({  
    toolbar:'#tb_main',
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Content/Training')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'TrainingID',align:'left',title:'编号'},
		{field:'TrainingName',align:'left',width:'160',title:'名称'}
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
		width : 500,
		top:'50px',
		href : "<?=site_url('Content/Training?do=edit')?>&TrainingID="+row.TrainingID,
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
function newData(){
	onResetGroup();
	rebulidDialog('MainForm');
	var obj = $("#MainForm").dialog({
		title : '新增',
		resizable : true,
		method : 'post',
		width : 500,
		top:'50px',
		href : "<?=site_url('Content/Training?do=add')?>",
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
function delData(){
	onResetGroup();
	var row = $('#MainTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	
	$.messager.confirm("提示",'删除?', function (r) {
		if (r) {
			$.messager.progress({'text':'<?=lang("C_LOADING")?>', showType:'fade'});
			$.get("<?=site_url('Content/Training?do=del')?>&TrainingID="+TrainingID,function(data){
				$.messager.progress('close');
				if(data.code == 200){
					$.messager.alert('<?=lang("C_TIP")?>','<?=lang("C_SUCCESS")?>','info',function(){
						$('#MainTable').datagrid('reload');
					});
				}else{
					 $.messager.alert('<?=lang("C_TIP")?>','<?=lang("C_ERROR")?>','error');
				}
			},'json');
		}
	});
}
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('Content/Training')?>?do=save",
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
		   	 $.messager.alert('信息','<div align="center">信息已保存</div>');
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