<?php $this->load->view('Common/header.php');?>
<div id="tb_main" style="padding:5px;">
	<div class="search_bar_row">
    状态&nbsp;<select class="easyui-combobox" id="s_Status">
    <option value="">全部</option>
    <option value="0">待接单</option>
    <option value="1">待服务</option>
    <option value="2">服务中</option>
    <option value="3">待付款</option>
    <option value="4">已完成</option>
    <option value="5">已取消</option>
    </select>&nbsp;
	客户姓名&nbsp;<input class="easyui-textbox" style="width:120px;height: 20px"  id="s_Customer">&nbsp;
    客户电话&nbsp;<input class="easyui-textbox" style="width:120px;height: 20px"  id="s_Phone">&nbsp;
    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-search" onClick="searchData()">搜索</a>
    </div>
    <div class="search_bar_row">
	<a href="javascript:editData();" class="easyui-linkbutton" iconCls="icon-edit">编辑</a>
    <a href="javascript:dispatchOrder();" class="easyui-linkbutton" iconCls="icon-edit">派单</a>
    <a href="javascript:cancelOrder();" class="easyui-linkbutton" iconCls="icon-edit">取消</a>
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
	url:'<?=site_url('Market/Order')?>?do=ListData',
	method:'post',
    columns : [[
		{field:'OrderID',align:'left',title:'编号'},
		{field:'Sn',align:'left',title:'流水号'},
		{field:'GoodsName',align:'left',title:'服务项目',width:'160'},
		{field:'Customer',width:'90',align:'left',title:'姓名'},
		{field:'Phone',align:'left',width:'160',title:'电话'},
		{field:'OrderAmount',align:'left',width:'110',title:'实际支付'},
		{field:'MasterName',align:'left',title:'负责师傅'},
		{field:'MasterPhone',align:'left',title:'师傅电话'},
		{field:'Status',align:'left',width:'160',title:'状态',formatter:function(val,row){
			var rs = '';
			switch(parseInt(val)){
				case 0:
					rs = '待接单';
					break;
				case 1:
					rs = '待服务';
					break;
				case 2:
					rs = '服务中';
					break;
				case 3:
					rs = '待支付';
					break;
				case 4:
					rs = '已完成';
					break;
				case 5:
					rs = '已取消';
					break;
				default:
					rs = '未知';
					break;
			}
			return rs;
		}},
		{field:'BookingTime',width:150,title:'预约时间'},
		{field:'TravelTime',width:150,title:'出发时间'},
		{field:'ServiceTime',width:150,title:'服务时间'},
		{field:'PaymentTime',width:150,title:'支付时间'},
		{field:'CreateTime',width:150,title:'创建时间'},
	]]
});	
}
function cancelOrder(){
	var row = $('#MainTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	if(row.Status > 1){
		$.messager.alert('信息','当前订单不可取消');return false;
	}
	$.messager.confirm("提示",'取消?', function (r) {
		if(r){
			$.post("<?=site_url('Market/Order?do=cancel')?>",{OrderID:row.OrderID,Status:5},function(data){
				if(data.code == 200){
					$.messager.alert('信息','操作成功',function(){
						$("#MainTable").datagrid("reload");
					});
				}else{
					$.messager.alert('信息','操作失败');
				}
			},'json');
		}
	});
}
function searchData(){
	var s_Status = $("#s_Status").combobox('getValue');
	var s_Customer = $("#s_Customer").textbox('getValue');
	var s_phone = $("#s_Phone").textbox('getValue');
	
	$('#MainTable').datagrid('load',{
		Status: s_Status,
		Customer:s_Customer,
		phone:s_phone
	});
}
//--派遣
function dispatchOrder(){
	onResetGroup();
	var row = $('#MainTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	if(row.Status > 1){
		$.messager.alert('信息','当前订单不可派遣');return false;
	}
	rebulidDialog('MainForm');
	var obj = $("#MainForm").dialog({
		title : '在线派遣',
		resizable : true,
		method : 'post',
		width : 600,
		top:'50px',
		href : "<?=site_url('Market/Order?do=Dispatch')?>&OrderID="+row.OrderID,
		buttons:[{
			text:'确定',
			iconCls: 'icon-save',
			handler:function(){
				saveDispatchOrder();
			}
		},{
			text:'取消',
			iconCls: 'icon-cancel',
			handler:function(){
				$("#MainForm").dialog('close');
			}
		}]
	});
}
function saveDispatchOrder(){
	var MasterID = $("#MasterID").combobox('getValue');
	if(MasterID == ""){
		$.messager.alert('信息','请选择师傅');return false;
	}
	$.post("<?=site_url('Market/Order?do=saveDispatchOrder')?>",$("#form-information").serialize(),function(data){
		if(data.code == 200){
			$.messager.alert('信息','操作成功');
			$("#MainForm").dialog('close');
			$("#MainTable").datagrid("reload");
			
		}else{
			$.messager.alert('信息','操作失败');
		}
	},'json');
}
function editData(){
	onResetGroup();
	var row = $('#MainTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('EditOrder');
	var obj = $("#EditOrder").dialog({
		title : '编辑订单',
		resizable : true,
		method : 'post',
		height:'auto',
		width : 600,
		top:'50px',
		href : "<?=site_url('Market/Order?do=editData')?>&OrderID="+row.OrderID,
		onLoad : function(str) {  
          
        }
	});
}
function onResetGroup() {
	$("#MainForm").dialog('destroy');
}
</script>