<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="OrderID"  value="<?=isset($data['OrderID'])?$data['OrderID']:"0"?>" />
    <tr>
      <td class="textCol">选择师傅</td>
      <td class="contentCol"><select id="MasterID" name="MasterID" class="easyui-combobox" data-options="required:true"></select></td>
    </tr>
    <tr>
      <td>备注</td>
      <td colspan="3"><input class="easyui-textbox" data-options="multiline:true" id="Remark" name="Remark" value="" style="width:380px;height:100px"></td>
    </tr>
  </table>
</form>
<script language="javascript">
getDispatchMasterList();
function getDispatchMasterList(){
	$("#MasterID").combobox({
		valueField: 'MemberID',
		textField: 'RealName',
		width:120,
		url: '<?=site_url('Market/Order/index?do=getDispatchMasterList')?>'
	});
}
</script>