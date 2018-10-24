<table id="ReportTable"></table>
<script language="javascript">
$(function () {
	$("#ReportTable").datagrid({
		pageSize:20,
		fit:true,
		singleSelect:true,
		pagePosition:'bottom',
		pagination:true,
		queryParams:{MemberID:<?=$MemberID?>},
		url:'<?=site_url('Content/Member/AgentReport')?>?do=getData',
		method:'post',
		columns : [[
			{field:'MemberID',align:'center',title:'编号'},
			{field:'WechatNickname',width:160,align:'left',title:'微信昵称',formatter:function(val,row){
				var base = new Base64();
				return base.decode(val);
			}},
			{field:'DndirectBonusTotal',align:'center',title:'佣金'},
		]]
	});	
});
</script>