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
<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="BannerID" id="BannerID" value="<?=isset($data['BannerID'])?$data['BannerID']:"0"?>" />
    <input type="file" id="upimg" style="display:none;" onchange="showPreview(this)"  accept="image/gif, image/jpeg, image/png"   />
    <input type="hidden" id="BigThumb" name="BigThumb" value="<?=isset($data['BigThumb'])?$data['BigThumb']:""?>" />
    <tr>
      <td>缩略图</td>
      <td class="contentCol"><div style="width:326px; height:150px; line-height:150px; border:1px solid #e0e0e0;text-align:center; padding:5px;" onClick="showUploadWindow()" id="ThumbDiv">
          <?php if(isset($data['BigThumb'])&&$data['BigThumb']!=''):?>
          <img src="<?=strpos($data['BigThumb'],'banner')>0?base_url($data['BigThumb']):$data['BigThumb']?>" style="max-height:100%; max-height:100%;" />
          <?php else:?>
          点击上传图片
          <?php endif;?>
        </div>
        </td>
    </tr>
    <tr>
      <td class="textCol">标题</td>
      <td class="contentCol"><input type="text" name="BannerName" id="BannerName" class="easyui-textbox input_width" value="<?=isset($data['BannerName'])?$data['BannerName']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">链接</td>
      <td class="contentCol"><input type="text" name="Link" id="Link" class="easyui-textbox input_width" value="<?=isset($data['Link'])?$data['Link']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">分类</td>
      <td class="contentCol"><select class="easyui-combobox" name="CatID" id="CatID" style="width:200px;" data-options="prompt:'请选择分类',editable:false">
        </select></td>
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
<script>
getCatListData();
function getCatListData(){
	$('#CatID').combobox({
    	url:"<?=site_url('Content/Banner?do=getCatListData')?>",
    	valueField:'CatID',
    	textField:'CatName',
    	method:"post",
		onLoadSuccess: function () {
			<?php if(isset($data['CatID'])):?>
			$("#CatID").combobox("setValue",<?=$data['CatID']?>);
			<?php endif;?>
		}
	});
}		
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
</script>
