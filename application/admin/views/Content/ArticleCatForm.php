<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="CategoryID" id="CategoryID" value="<?=isset($data['CategoryID'])?$data['CategoryID']:"0"?>" />
    <tr>
      <td class="textCol">分类名称</td>
      <td class="contentCol"><input type="text" name="CatName" id="CatName" class="easyui-textbox input_width" value="<?=isset($data['CatName'])?$data['CatName']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">排序</td>
      <td class="contentCol"><input type="text" name="ListOrder" id="ListOrder" class="easyui-textbox input_width" value="<?=isset($data['ListOrder'])?$data['ListOrder']:"99"?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">状态</td>
      <td class="contentCol"><select id="Status" class="easyui-combobox" name="Status" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['Status'])&&$data['Status']=1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['Status'])&&$data['Status']=0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
  </table>
</form>