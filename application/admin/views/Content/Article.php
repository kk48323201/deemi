<?php $this->load->view('Common/header.php');?>
<div id="tb_article">
	<div class="search_bar_row">		
		文章名称&nbsp;<input class="easyui-textbox" style="width:120px;height: 20px"  id="s_Title">&nbsp;
		&nbsp;&nbsp;
		分类&nbsp;<select class="easyui-combobox" name="s_CategoryID" id="s_CategoryID" style="width:200px;" data-options="prompt:'请选择分类',editable:false"></select>
        
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-search" onClick="searchData()">搜索</a>
        &nbsp;
		<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" onClick="newData()">新增文章</a>
	</div>
</div>
<table id="ArticleTable"></table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
getListData();
function getListData(){
$("#ArticleTable").datagrid({  
    toolbar:'#tb_article',
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Content/Article')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'ArticleID',align:'left',title:'编号'},
		{field:'BigThumb',align:'left',width:'160',title:'缩略图',formatter:function(val,row){
			if(val != ''){
				return '<img src="<?=base_url()?>'+val+'" style="height:50px;man-width:120px;" />';
			}else{
				return '';
			}
		}},
		{field:'CatName',width:'160',align:'left',title:'类别'},
		{field:'Title',align:'left',width:'260',title:'文章名称'},
		{field:'CreateTime',width:150,title:'创建时间'},
		{field:'Operation',title:'操作',width:180,formatter:function(val,row){
			html = "";
			html += '<a href="javascript:editData('+row.ArticleID+');" class="easyui-linkbutton l-btn l-btn-small btn-text" style="padding:3px 5px;">编辑</a>';
			html += '&nbsp;<a href="javascript:delData('+row.ArticleID+');" class="easyui-linkbutton l-btn l-btn-small btn-text" style="padding:3px 5px;">删除</a>';
			return html;
		}}
	]]
});	
}
getCatListData();
function getCatListData(){
	$('#s_CategoryID').combobox({
    	url:"<?=site_url('Content/Article?do=catListData')?>",
    	valueField:'CategoryID',
    	textField:'CatName',
    	method:"post",
    	queryParams:{
    		CategoryID:-1
    	}
	});
}	
function searchData(){
	var s_Title = $("#s_Title").textbox('getValue');
	$('#ArticleTable').datagrid('load',{
		Title: s_Title
	});
}
function showCatListData(){
	onResetGroup();
	rebulidDialog('ArticleCatList');
	var obj = $("#ArticleCatList").dialog({
		title : '编辑',
		resizable : true,
		method : 'post',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('Content/Article/Cat')?>",
	});
}
function editData(){
	onResetGroup();
	var row = $('#ArticleTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('ArticleForm');
	
	var obj = $("#ArticleForm").dialog({
		title : '编辑',
		resizable : true,
		method : 'post',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('Content/Article?do=edit')?>&ArticleID="+row.ArticleID,
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
	rebulidDialog('ArticleForm');
	var obj = $("#ArticleForm").dialog({
		title : '新增文章',
		resizable : true,
		method : 'post',
		height:'85%',
		width : 600,
		top:'50px',
		href : "<?=site_url('Content/Article?do=add')?>",
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
			$.get("<?=site_url('Content/Article?do=del')?>&ArticleID="+ArticleID,function(data){
				$.messager.progress('close');
				if(data.code == 200){
					$.messager.alert('<?=lang("C_TIP")?>','<?=lang("C_SUCCESS")?>','info',function(){
						$('#ArticleTable').datagrid('reload');
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
		url : "<?=site_url('Content/Article')?>?do=save",
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
			 $('#ArticleTable').datagrid('reload');
			 onResetGroup();
		   }else{
		   	 $.messager.alert('error','系统发生错误','error');
		   }
		}
	});
}
function onResetGroup() {
	$("#ArticleForm").dialog('destroy');
	$("#ArticleCatList").dialog('destroy');
}
</script>