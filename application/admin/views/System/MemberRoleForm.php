<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="RoleID" id="RoleID" value="<?=isset($data['RoleID'])?$data['RoleID']:"0"?>" />
    <tr>
      <td class="textCol">角色名称</td>
      <td class="contentCol"><input type="text" readonly="readonly" name="RoleName" id="RoleName" class="easyui-textbox input_width" value="<?=isset($data['RoleName'])?$data['RoleName']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">直接佣金比例（%）</td>
      <td class="contentCol"><input type="text" name="DirectRate" id="DirectRate" class="easyui-textbox input_width" value="<?=isset($data['DirectRate'])?$data['DirectRate']:"15.00"?>" data-options="min:0,precision:2,width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">间接佣金比例（%）</td>
      <td class="contentCol"><input type="text" name="DndirectRate" id="DndirectRate" class="easyui-textbox input_width" value="<?=isset($data['DndirectRate'])?$data['DndirectRate']:"3.00"?>" data-options="min:0,precision:2,width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td>粉丝权限</td>
      <td colspan="3"><select id="IsFans" class="easyui-combobox" name="IsFans" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['IsFans'])&&$data['IsFans']==1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['IsFans'])&&$data['IsFans']==0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
    <tr>
      <td>优惠地址</td>
      <td colspan="3"><select id="DcAddress" class="easyui-combobox" name="DcAddress" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['DcAddress'])&&$data['DcAddress']==1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['DcAddress'])&&$data['DcAddress']==0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
    <tr>
      <td>前端管理</td>
      <td colspan="3"><select id="Manage" class="easyui-combobox" name="Manage" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['Manage'])&&$data['Manage']==1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['Manage'])&&$data['Manage']==0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
    <tr>
      <td>地图展示</td>
      <td colspan="3"><select id="ShowMap" class="easyui-combobox" name="ShowMap" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['ShowMap'])&&$data['ShowMap']==1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['ShowMap'])&&$data['ShowMap']==0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
  </table>
</form>