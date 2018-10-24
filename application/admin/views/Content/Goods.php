<?php $this->load->view('Common/header.php');?>
<div id="tb_main" style="padding:5px;">
	<a href="javascript:newData();" class="easyui-linkbutton" iconCls="icon-add">新增</a>
	&nbsp;
	<a href="javascript:editData();" class="easyui-linkbutton" iconCls="icon-edit">编辑</a>
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
	url:'<?=site_url('Content/Goods')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'GoodsID',align:'left',title:'编号'},
		{field:'BigThumb',align:'left',width:'60',title:'缩略图',formatter:function(val,row){
			if(val != ''){
				return '<img src="<?=base_url()?>'+val+'" style="height:50px;man-width:120px;" />';
			}else{
				return '';
			}
		}},
		{field:'GoodsName',width:'160',align:'left',title:'商品名称'},
		{field:'Price',align:'left',width:'110',title:'价格'},
		{field:'OnSale',align:'left',width:'110',title:'状态',formatter:function(val,row){
			if(val==1){
				return '在售';
			}else{
				return '禁止';
			}
		}},
		{field:'CreateTime',width:150,title:'创建时间'},
		{field:'Operation',title:'操作',width:180,formatter:function(val,row){
			html = "";
			html += '<a href="javascript:delData('+row.GoodsID+');" class="easyui-linkbutton l-btn l-btn-small btn-text" style="padding:3px 5px;">删除</a>';
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
		width : 700,
		top:'50px',
		href : "<?=site_url('Content/Goods?do=edit')?>&GoodsID="+row.GoodsID,
		onLoad : function(str) {  
			CreateKindEditor();
		},
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
		width : 700,
		top:'50px',
		href : "<?=site_url('Content/Goods?do=add')?>",
		onLoad : function(str) {  
			CreateKindEditor();
		},
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
function delData(GoodsID){
	$.messager.confirm("提示",'删除?', function (r) {
		if (r) {
			$.messager.progress({'text':'<?=lang("C_LOADING")?>', showType:'fade'});
			$.get("<?=site_url('Content/Goods?do=del')?>&GoodsID="+GoodsID,function(data){
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
/**********常用方法**********/
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('Content/Goods')?>?do=save",
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