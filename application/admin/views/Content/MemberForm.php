<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="MemberID" id="MemberID" value="<?=isset($data['MemberID'])?$data['MemberID']:"0"?>" />
    <tr>
      <td class="textCol">真实姓名</td>
      <td class="contentCol"><input name="RealName" value="<?=isset($data['RealName'])?$data['RealName']:""?>" class="easyui-textbox input_width"  /></td>
      <td class="textCol">手机号码</td>
      <td class="contentCol"><input class="easyui-textbox input_width" name="Mobile" id="Mobile" value="<?=isset($data['Mobile'])?$data['Mobile']:""?>" data-options="required:true" /></td>
    </tr>
    <tr>
      <td class="textCol">身份角色</td>
      <td class="contentCol"><?=$this->Html_model->getRoleListHtml($data)?></td>
      <td class="textCol"></td>
      <td class="contentCol"></td>
    </tr>
    <tr>
      <td class="textCol">登录密码</td>
      <td class="contentCol"><input class="easyui-textbox input_width" name="Password" id="Password" value="" /></td>
      <td class="textCol">电子邮箱</td>
      <td class="contentCol"><input class="easyui-textbox input_width" name="Email"  id="Email" value="<?=isset($data['Email'])?$data['Email']:""?>" data-options="validType:'email'"  /></td>
    </tr>
    <tr>
      <td class="textCol">微信昵称</td>
      <td class="contentCol"><input class="easyui-textbox input_width" value="<?=isset($data['WechatNickname'])?base64_decode($data['WechatNickname']):""?>" data-options="disabled:true"    /></td>
      <td class="textCol">微信性别</td>
      <td class="contentCol"><input name="WechatSex" id="WechatSex"  class="easyui-combobox" /></td>
    </tr>
    <tr>
      <td class="textCol">微信Openid</td>
      <td><input class="easyui-textbox input_width" name="WechatOpenid" id="WechatOpenid"  value="<?=isset($data['WechatOpenid'])?$data['WechatOpenid']:""?>" data-options="disabled:true"   /></td>
      <td class="textCol">微信Unionid</td>
      <td><input class="easyui-textbox input_width" name="WechatUnionid" id="WechatUnionid"  value="<?=isset($data['WechatUnionid'])?$data['WechatUnionid']:""?>" data-options="disabled:true"   /></td>
    </tr>
    <tr>
      <td class="textCol">账号状态</td>
      <td colspan="3"><label><input name="Status" type="radio" value="1" <?=isset($data['Status'])&&(string)$data['Status']=='1'||!isset($data['Status'])?"checked='checked'":''; ?> />启用</label> 
			<label><input name="Status" type="radio" value="0" <?=isset($data['Status'])&&(string)$data['Status']=='0'?"checked='checked'":''; ?> />停用</label>
	  </td>
      
    </tr>
    <tr>
    <td height="38" colspan="4" align="center">
    <a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a>
    &nbsp;&nbsp;
    <a href="javascript:onResetGroup();"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-cancel'"><span class="l-btn-text">关闭</span></a>
    </td>
    </tr>
  </table>
</form>
<script language="javascript">
$(function(){
	<?php if($data['RoleID']):?>
	setTimeout(function(){
		$("#RoleID").combobox('setValue',<?=$data['RoleID']?>);
	},500);
	<?php endif;?>
});
CreateSexInput(<?=isset($data['WechatSex'])?$data['WechatSex']:0;?>);
function CreateSexInput(id){
	$('#WechatSex').combobox({
    	valueField:'id',
    	textField:'text',
		data:[
			{id:'0',text:'保密'},
			{id:'1',text:'男'},
			{id:'2',text:'女'},
		],
		onLoadSuccess: function () {
			if(id*1 > 0){
				$('#WechatSex').combobox("setValue",id);
			}else{
				$('#WechatSex').combobox("setValue",0);
			}
		}
	});
}
</script>