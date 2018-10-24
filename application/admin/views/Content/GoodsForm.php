<style type="text/css">
#ThumbDiv img {
	max-height:150px;
	max-width:326px;
}
.ke-icon-example1 {
 background-image: url(<?=base_url()?>style/libraries/kindeditor/themes/default/default.png);
	background-position: 0px -672px;
	width: 16px;
	height: 16px;
}
</style>
<script language="javascript">
function showUploadWindow(){
	$("#upimg").click();
}
function showPreview(source) {  
	var file = source.files[0];
	if(window.FileReader){
		var fr = new FileReader();
		fr.readAsDataURL(file);
		fr.onloadend = function(e) {  
			$("#ThumbDiv").html('<img src="'+e.target.result+'" />'); 
			$("input[name=BigThumb]").val(e.target.result);
		};  
	}  
}
function CreateKindEditor(){
	var k_options = {  
		resizeType:0,
		width:'320px',
		minWidth:'320px',
		height:"480px",
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		uploadJson:"<?=site_url('Content/Goods/UploadImages')?>",
		cssData : 'img{max-width:100%;}body{font-size:14px;}',
		items : [
			'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
		afterChange:function(){  
			this.sync();  
		},
		afterBlur:function(){  
			this.sync();  
		}
	};  
	var editor = new Array();
	$(function(){
		KindEditor.create('textarea[name="Content"]',k_options);
		KindEditor.create('textarea[name="OtherDesc"]',k_options); 
	});
}
</script>
<form method="post" enctype="multipart/form-data" id="form-information">
  <input type="hidden" name="GoodsID" id="GoodsID" value="<?=isset($data['GoodsID'])?$data['GoodsID']:"0"?>" />
  <input type="hidden" name="Qty" id="Qty" value="<?=isset($data['Qty'])?$data['Qty']:"0"?>" />
  <input type="file" id="upimg" style="display:none;" onchange="showPreview(this)"  accept="image/gif, image/jpeg, image/png"   />
  <input type="hidden" id="BigThumb" name="BigThumb" value="<?=isset($data['BigThumb'])?$data['BigThumb']:""?>" />
  <div id="GoodsFormTab" class="easyui-tabs">
    <div title="基础信息">
      <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width:160px;">缩略图</td>
          <td class="contentCol" colspan="3"><div style="width:150px; height:150px; line-height:150px; border:1px solid #e0e0e0;text-align:center; padding:5px;" onClick="showUploadWindow()" id="ThumbDiv">
              <?php if(isset($data['BigThumb'])&&$data['BigThumb']!=''):?>
              <img src="<?=strpos($data['BigThumb'],'goods')>0?base_url($data['BigThumb']):$data['BigThumb']?>" style="max-height:100%; max-height:100%;" />
              <?php else:?>
              点击上传图片
              <?php endif;?>
            </div>
            <p>&nbsp;最佳尺寸350*350</p></td>
        </tr>
        <tr>
          <td width="160">商品名称</td>
          <td colspan="3"><input type="text" name="GoodsName" id="GoodsName" class="easyui-textbox input_width" value="<?=isset($data['GoodsName'])?$data['GoodsName']:""?>" data-options="width:'100%',required:true"  /></td>
        </tr>
        <tr>
          <td>价格</td>
          <td><input type="text" name="Price" id="Price" class="easyui-textbox input_width" value="<?=isset($data['Price'])?$data['Price']:""?>" data-options="min:0,precision:2,width:'100%',required:true"  /></td>
          <td style="width:160px;">单位</td>
          <td><input type="text" name="Unit" id="Unit" class="easyui-textbox" value="<?=isset($data['Unit'])?$data['Unit']:""?>" data-options="required:true" /></td>
        </tr>
        <tr>
          <td>库存</td>
          <td><input type="text" name="Qty" id="Qty" class="easyui-numberbox" value="<?=isset($data['Qty'])?$data['Qty']:"500"?>" data-options="required:true,precision:0,min:0" /></td>
          <td>在售</td>
          <td><select id="OnSale" name="OnSale"  class="easyui-combobox" data-options="editable:false">
              <option value="0" <?=isset($data['OnSale'])&&$data['OnSale']==0?"selected='selected'":""?>>禁止</option>
              <option value="1" <?=isset($data['OnSale'])&&$data['OnSale']==1?"selected='selected'":""?>>启动</option>
            </select></td>
        </tr>
        <tr>
          <td>简短描述</td>
          <td colspan="3"><input class="easyui-textbox" data-options="multiline:true,required:true" id="Description" name="Description" value="<?=isset($data['Description'])?$data['Description']:""?>" style="width:380px;height:100px"></td>
        </tr>
        <tr>
          <td>状态</td>
          <td colspan="3"><select id="Status" class="easyui-combobox" name="Status" style="width:200px;" data-options="editable:false">
              <option value="1" <?=isset($data['Status'])&&$data['Status']=1?'selected="selected"':''?>>启用</option>
              <option value="0" <?=isset($data['Status'])&&$data['Status']=0?'selected="selected"':''?>>禁用</option>
            </select></td>
        </tr>
      </table>
    </div>
    <div title="内容详细" style="display:none;">
      <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50%">内容描述</td>
          <td>保障说明</td>
        </tr>
        <tr>
          <td><div style="width:320px;">
              <textarea rows="3" id="Content" name="Content" class="easyui-validatebox" data-options="validType:'length[0,1000000]'" invalidMessage="最大长度不能超过1000000"><?=isset($data['Content'])?$data['Content']:""?>
</textarea>
            </div></td>
          <td><div style="width:320px;">
              <textarea style="width:320px;" rows="3" id="OtherDesc" name="OtherDesc" class="easyui-validatebox" data-options="validType:'length[0,1000000]'" invalidMessage="最大长度不能超过1000000"><?=isset($data['OtherDesc'])?$data['OtherDesc']:""?>
</textarea>
            </div></td>
        </tr>
      </table>
    </div>
  </div>
</form>
