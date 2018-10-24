<?php $this->load->view('Common/header.php');?>
<style>
.infobox .textCol{ width:110px;}
.infobox .contentCol{ width:auto;}
.waterposition{width:400px;margin-left:0;background:#f9f9f9;border:1px solid #999;border-collapse: collapse;line-height:20px;}
.waterposition td{border:1px solid #999; color:#000000;}
.waterposition label{ display:block; height:20px;}
</style>
<form id="form-information" method="post">
<div class="easyui-tabs" style="width:100%;">
  <div title="基础设置" style="padding:10px">
    <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textCol">网站名称</td>
        <td class="contentCol"><input name="base[site_name]" value="<?=isset($base['site_name'])?$base['site_name']:""?>" class="easyui-textbox input_width" data-options="required:true,width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">关键词</td>
        <td class="contentCol"><input name="base[site_keywords]" value="<?=isset($base['site_keywords'])?$base['site_keywords']:""?>" class="easyui-textbox input_width" data-options="required:true,width:'400px'"  /></td>
      </tr>
      <tr>
        <td class="textCol">网站介绍</td>
        <td class="contentCol"><input name="base[site_description]" value="<?=isset($base['site_description'])?$base['site_description']:""?>" class="easyui-textbox" data-options="multiline:true" style="width:400px;height:100px"></td>
      </tr>
      <tr>
      	<td></td>
        <td><a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a></td>
      </tr>
    </table>
  </div>
  <div title="邮箱配置" style="padding:10px;">
    <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textCol">SMTP服务器</td>
        <td class="contentCol"><input name="mail[smtp_host]" value="<?=isset($mail['smtp_host'])?$mail['smtp_host']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">SMTP用户名</td>
        <td class="contentCol"><input name="mail[smtp_user]" value="<?=isset($mail['smtp_user'])?$mail['smtp_user']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">SMTP密码</td>
        <td class="contentCol"><input name="mail[smtp_pass]" value="<?=isset($mail['smtp_pass'])?$mail['smtp_pass']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">SMTP端口</td>
        <td class="contentCol"><input name="mail[smtp_port]" value="<?=isset($mail['smtp_port'])?$mail['smtp_port']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">发信人邮箱</td>
        <td class="contentCol"><input name="mail[smtp_sendmail]" value="<?=isset($mail['smtp_sendmail'])?$mail['smtp_sendmail']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
      	<td></td>
        <td><a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a></td>
      </tr>
    </table>
  </div>
  <div title="附件配置" style="padding:10px;">
    <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textCol">上传附件大小</td>
        <td class="contentCol"><input name="attr[attr_maxsize]" value="<?=isset($attr['attr_maxsize'])?$attr['attr_maxsize']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" />
          <span>&nbsp;K (1M=1024K)</span></td>
      </tr>
      <tr>
        <td class="textCol">水印类型</td>
        <td class="contentCol"><label>
          <input name="attr[water_type]" type="radio" value="1" <?=isset($attr['water_type'])&&(string)$attr['water_type']=='1'?"checked='checked'":''; ?>/>
          图片水印</label>
          <label>
          <input name="attr[water_type]" type="radio" value="2" <?=isset($attr['water_type'])&&(string)$attr['water_type']=='2'?"checked='checked'":''; ?>/>
          文字水印</label>
          <label>
          <input name="attr[water_type]" type="radio" value="0" <?=isset($attr['water_type'])&&(string)$attr['water_type']=='0'?"checked='checked'":''; ?>/>
          关闭</label></td>
      </tr>
      <tr>
        <td class="textCol">水印边距</td>
        <td class="contentCol"><input name="attr[water_padding]" value="<?=isset($attr['water_padding'])?$attr['water_padding']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" />
          &nbsp;PX</td>
      </tr>
      <tr>
        <td class="textCol">透明度</td>
        <td class="contentCol"><input name="attr[water_opacity]" value="<?=isset($attr['water_opacity'])?$attr['water_opacity']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" />
          &nbsp;(1-100)</td>
      </tr>
      <tr>
        <td class="textCol">图片质量</td>
        <td class="contentCol"><input name="attr[water_quality]" value="<?=isset($attr['water_quality'])?$attr['water_quality']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" />
          &nbsp;(1-100)</td>
      </tr>
      <tr>
        <td class="textCol">水印位置</td>
        <td class="contentCol"><table class="waterposition">
            <tbody>
              <tr>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="topleft" <?=isset($attr['water_position'])&&$attr['water_position']=='topleft'?'checked="checked"':''?> />
                  顶部居左</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="topcenter" <?=isset($attr['water_position'])&&$attr['water_position']=='topcenter'?'checked="checked"':''?> />
                  顶部居中</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="topright" <?=isset($attr['water_position'])&&$attr['water_position']=='topright'?'checked="checked"':''?> />
                  顶部居右</label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="middleleft" <?=isset($attr['water_position'])&&$attr['water_position']=='middleleft'?'checked="checked"':''?> />
                  中部居左</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="middlecenter" <?=isset($attr['water_position'])&&$attr['water_position']=='middlecenter'?'checked="checked"':''?> />
                  中部居中</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="middleright" <?=isset($attr['water_position'])&&$attr['water_position']=='middleright'?'checked="checked"':''?> />
                  中部居右</label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="bottomleft" <?=isset($attr['water_position'])&&$attr['water_position']=='bottomleft'?'checked="checked"':''?> />
                  底部居左</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="bottomcenter" <?=isset($attr['water_position'])&&$attr['water_position']=='bottomcenter'?'checked="checked"':''?> />
                  底部居中</label></td>
                <td><label>
                  <input type="radio" name="attr[water_position]" value="bottomright"  <?=isset($attr['water_position'])&&$attr['water_position']=='bottomright'?'checked="checked"':''?> />
                  底部居右</label></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="textCol">水印图片</td>
        <td class="contentCol"><input type="text" name="attr[water_image_path]" value="<?=isset($attr['water_opacity'])?$attr['water_opacity']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">文字水印</td>
        <td class="contentCol"><input name="attr[water_text_value]" value="<?=isset($attr['water_text_value'])?$attr['water_text_value']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">文字大小</td>
        <td class="contentCol"><input name="attr[water_text_size]" value="<?=isset($attr['water_text_size'])?$attr['water_text_size']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">文字颜色</td>
        <td class="contentCol"><input name="attr[water_text_color]" id="color" value="<?=isset($attr['water_text_color'])?$attr['water_text_color']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
      	<td></td>
        <td><a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a></td>
      </tr>
    </table>
  </div>
  <div title="优惠配置" style="padding:10px;">
  	<table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textCol">商户折扣</td>
        <td class="contentCol"><input name="base[merchant_discount]" value="<?=isset($base['merchant_discount'])?$base['merchant_discount']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">新用户折扣</td>
        <td class="contentCol"><input name="base[user_discount]" value="<?=isset($base['user_discount'])?$base['user_discount']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">开启新用户折扣</td>
        <td class="contentCol"><select id="base[open_user_discount]" class="easyui-combobox" name="base[open_user_discount]" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($base['open_user_discount']) && $base['open_user_discount']==1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($base['open_user_discount']) && $base['open_user_discount']==0?'selected="selected"':''?>>禁用</option>
        </select>
        </td>
      </tr>
      <tr>
      	<td></td>
        <td><a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a></td>
      </tr>
    </table>
  </div>
  <!--<div title="微信配置" style="padding:10px;">
    <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textCol">APPID</td>
        <td class="contentCol"><input name="wechat[appid]" value="<?=isset($wechat['appid'])?$wechat['appid']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">APPSECRET</td>
        <td class="contentCol"><input name="wechat[appsecret]" value="<?=isset($wechat['appsecret'])?$wechat['appsecret']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">Token</td>
        <td class="contentCol"><input name="wechat[token]" value="<?=isset($wechat['token'])?$wechat['token']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">Encodingaeskey</td>
        <td class="contentCol"><input name="wechat[encodingaeskey]" value="<?=isset($wechat['encodingaeskey'])?$wechat['encodingaeskey']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
        <td class="textCol">模拟微信Openid</td>
        <td class="contentCol"><input name="wechat[WechatOpenid]" value="<?=isset($wechat['WechatOpenid'])?$wechat['WechatOpenid']:""?>" class="easyui-textbox input_width" data-options="width:'400px'" /></td>
      </tr>
      <tr>
      	<td></td>
        <td><a href="javascript:onSubmitGroup()"  class="easyui-linkbutton l-btn l-btn-small" data-options="iconCls:'icon-save'"><span class="l-btn-text">保存</span></a></td>
      </tr>
    </table>
  </div>-->
</div>
</form>
<script language="javascript">
function onSubmitGroup() {		
	$("#form-information").form('submit', {
		url : "<?=site_url('Webconfig/index')?>?do=Save",
		onSubmit : function(){
			$.messager.progress({'text':'正在导入数据,请稍后......', showType:'fade'});
		},
		success : function(str) {
		   $.messager.progress('close');
		   obj = eval('(' + str + ')');
		   if(obj.code == '200'){
		   	 $.messager.alert('信息','<div align="center">信息已保存</div>');
		   }else{
		   	 $.messager.alert('信息','系统发生错误','error');
		   }
		}
	});
}
</script>
<?php $this->load->view('Common/footer.php');?>