<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="AdminID" id="AdminID" value="<?=isset($data['AdminID'])?$data['AdminID']:"0"?>" />
    <tr>
      <td class="textCol">名称</td>
      <td class="contentCol"><input type="text" name="AdminUser" id="AdminUser" class="easyui-textbox input_width" value="<?=isset($data['AdminUser'])?$data['AdminUser']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">密码</td>
      <td class="contentCol"><input type="text" name="AdminPassword" id="AdminPassword" class="easyui-textbox input_width" value="" data-options="width:'100%'"  /></td>
    </tr>
  </table>
</form>