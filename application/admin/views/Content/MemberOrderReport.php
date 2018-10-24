<table id="ReportTable"></table>
<script language="javascript">
$(function() {
	$("#ReportTable").datagrid({
		pageSize:20,
		fit:true,
		singleSelect:true,
		pagePosition:'bottom',
		pagination:true,
		queryParams:{MemberID:<?=$MemberID?>},
		url:'<?=site_url('Content/Member/OrderReport')?>?do=getData',
		method:'post',
		columns : [[
			{field:'Sn',align:'center',title:'编号'},
			{field:'OrderAmount',align:'center',title:'总金额'},
			{field:'CreateTime',align:'center',title:'创建时间'},
		]]
	});	
});
</script>