<?php $this->load->view('Common/header.php');?>
<div id="tb_main">
	<div class="search_bar_row">		
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" onClick="updateStatus(1)">更新{已处理}</a>
        &nbsp;
		<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-cancel" onClick="updateStatus(2)">删除</a>
	</div>
</div>
<table id="MainTable"></table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
getListData();
function getListData(){
$("#MainTable").datagrid({  
	pageSize:20,
	toolbar:'#tb_main',
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Market/DrawnRecord')?>?do=ListData',
	method:'post',
    columns : [[
		{field:'ID',align:'left',title:'编号'},
		{field:'Amount',align:'left',width:'120',title:'金额'},
		{field:'WechatOpenid',align:'left',title:'微信Openid',width:'260'},
		{field:'RealName',width:'160',align:'left',title:'名称'},
		{field:'Status',align:'left',width:'80',title:'状态',formatter:function(val,row){
			var rs = '';
			switch(parseInt(val)){
				case 0:
					rs = '待处理';
					break;
				case 1:
					rs = '已处理';
					break;
				case 2:
					rs = '取消';
					break;
				default:
					rs = '未知';
					break;
			}
			return rs;
		}},
		{field:'CreateTime',align:'left',width:'160',title:'创建时间'},
	]]
});	
}

function updateStatus(status){
	var row = $('#ArticleTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	$.messager.confirm("提示",'更新状态?', function (r) {
		if (r) {
			$.messager.progress({'text':'<?=lang("C_LOADING")?>', showType:'fade'});
			$.get("<?=site_url('Market/DrawnRecord?do=update')?>&ID="+row.ID+"&Status="+status,function(data){
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
function onResetGroup() {
	$("#MainForm").dialog('destroy');
}
</script>