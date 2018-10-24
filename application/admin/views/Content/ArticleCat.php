<?php $this->load->view('Common/header.php');?>
<div id="tb_articlecat">
	<div class="search_bar_row">
		<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" onClick="newData()">新增分类</a>
        &nbsp;
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" onClick="editData()">编辑分类</a>
        &nbsp;
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" onClick="delData()">删除分类</a>
	</div>
</div>
<table id="ArticleCatTable"></table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
getListData();
function getListData(){
$("#ArticleCatTable").datagrid({  
    toolbar:'#tb_articlecat',
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Content/Article/Cat')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'CategoryID',align:'left',title:'编号'},
		{field:'CatName',width:'160',align:'left',title:'类别名称'},
		{field:'ListOrder',align:'left',width:'160',title:'排序'},
		{field:'Status',width:150,title:'状态',formatter:function(val,row){
			return val==1?'启用':'禁用';
		}}
	]]
});	
}
function editData(){
	onResetGroup();
	var row = $('#ArticleCatTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('ArticleCatForm');
	
	var obj = $("#ArticleCatForm").dialog({
		title : '编辑',
		resizable : true,
		method : 'get',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('Content/Article/Cat?do=edit')?>&CategoryID="+row.CategoryID,
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
	rebulidDialog('ArticleCatForm');
	var obj = $("#ArticleCatForm").dialog({
		title : '新增分类',
		resizable : true,
		method : 'get',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('Content/Article/Cat?do=add')?>",
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
function delData(ArticleID){
	$.messager.confirm("提示",'删除?', function (r) {
		if (r) {
			$.messager.progress({'text':'<?=lang("C_LOADING")?>', showType:'fade'});
			$.get("<?=site_url('Content/ArticleCat?do=del')?>&CategoryID="+CategoryID,function(data){
				$.messager.progress('close');
				if(data.code == 200){
					$.messager.alert('<?=lang("C_TIP")?>','<?=lang("C_SUCCESS")?>','info',function(){
						$('#ArticleCatTable').datagrid('reload');
					});
				}else{
					 $.messager.alert('<?=lang("C_TIP")?>','<?=lang("C_ERROR")?>','error');
				}
			},'json');
		}
	});
}
/**********常用方法**********/
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('Content/Article/Cat')?>?do=save",
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
			 onResetGroup();
			 $('#ArticleCatTable').datagrid('reload');
		   }else{
		   	 $.messager.alert('error','系统发生错误','error');
		   }
		}
	});
}
function onResetGroup() {
	$("#ArticleCatForm").dialog('destroy');
}
</script>