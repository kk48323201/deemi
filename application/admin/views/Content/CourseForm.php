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
    <input type="hidden" name="CourseID" id="CourseID" value="<?=isset($data['CourseID'])?$data['CourseID']:"0"?>" />
    <input type="file" id="upimg" style="display:none;" onchange="showPreview(this)"  accept="image/gif, image/jpeg, image/png"   />
    <input type="hidden" id="BigThumb" name="BigThumb" value="<?=isset($data['BigThumb'])?$data['BigThumb']:""?>" />
    <tr>
      <td>缩略图</td>
      <td class="contentCol"><div style="width:326px; height:150px; line-height:150px; border:1px solid #e0e0e0;text-align:center; padding:5px;" onClick="showUploadWindow()" id="ThumbDiv">
          <?php if(isset($data['BigThumb'])&&$data['BigThumb']!=''):?>
          <img src="<?=strpos($data['BigThumb'],'article')>0?base_url($data['BigThumb']):$data['BigThumb']?>" style="max-height:100%; max-height:100%;" />
          <?php else:?>
          点击上传图片
          <?php endif;?>
        </div>
        <p>&nbsp;最佳尺寸500*230</p></td>
    </tr>
    <tr>
      <td class="textCol">课程标题</td>
      <td class="contentCol"><input type="text" name="CourseName" id="CourseName" class="easyui-textbox input_width" value="<?=isset($data['CourseName'])?$data['CourseName']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">简短描述</td>
      <td class="contentCol"><input class="easyui-textbox" data-options="multiline:true,required:true" id="Description" name="Description" value="<?=isset($data['Description'])?$data['Description']:""?>" style="width:380px;height:100px"></td>
    </tr>
    <tr>
      <td class="textCol">价格</td>
      <td class="contentCol"><input type="text" name="Price" id="Price" class="easyui-numberbox input_width" value="<?=isset($data['Price'])?$data['Price']:"100.00"?>" data-options="required:true,precision:2,min:0"  /></td>
    </tr>
    <tr>
      <td class="textCol">体验时长</td>
      <td class="contentCol"><input type="text" name="ExperienceTime" id="ExperienceTime" class="easyui-textbox input_width" value="<?=isset($data['ExperienceTime'])?$data['ExperienceTime']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
    <tr>
      <td class="textCol">使用门店</td>
      <td class="contentCol"><input type="text" name="Shop" id="Shop" class="easyui-textbox input_width" value="<?=isset($data['Shop'])?$data['Shop']:""?>" data-options="width:'100%'"  /></td>
    </tr>
    <tr>
      <td class="textCol">现场福利</td>
      <td class="contentCol"><input type="text" name="Welfare" id="Welfare" class="easyui-textbox input_width" value="<?=isset($data['Welfare'])?$data['Welfare']:""?>" data-options="width:'100%'"  /></td>
    </tr>
    <tr>
      <td class="textCol">温馨提示</td>
      <td class="contentCol"><input type="text" name="Tips" id="Tips" class="easyui-textbox input_width" value="<?=isset($data['Tips'])?$data['Tips']:"有免费停车位"?>" data-options="width:'100%'"  /></td>
    </tr>
    <tr>
      <td class="textCol">客服电话</td>
      <td class="contentCol"><input type="text" name="Tel" id="Tel" class="easyui-textbox input_width" value="<?=isset($data['Tel'])?$data['Tel']:"13417746716"?>" data-options="width:'100%'"  /></td>
    </tr>
    <tr>
      <td class="textCol">状态</td>
      <td class="contentCol"><select id="Status" class="easyui-combobox" name="Status" style="width:200px;" data-options="editable:false">
          <option value="1" <?=isset($data['Status'])&&$data['Status']=1?'selected="selected"':''?>>启用</option>
          <option value="0" <?=isset($data['Status'])&&$data['Status']=0?'selected="selected"':''?>>禁用</option>
        </select></td>
    </tr>
    <tr>
      <td class="textCol">内容</td>
      <td class="contentCol"><div style="width:450px;">
          <textarea rows="3" id="Content" name="Content" class="easyui-validatebox" data-options="validType:'length[0,1000000]'" invalidMessage="最大长度不能超过1000000"><?=isset($data['Content'])?$data['Content']:""?>
</textarea>
        </div></td>
    </tr>
  </table>
</form>
<script>
getCatListData();
CreateKindEditor();
function getCatListData(){
	$('#CategoryID').combobox({
    	url:"<?=site_url('Content/Article?do=catListData')?>",
    	valueField:'CategoryID',
    	textField:'CatName',
    	method:"post",
    	queryParams:{
    		CategoryID:<?=isset($data['CategoryID'])?$data['CategoryID']:"0"?>
    	}
	});
}		
function CreateKindEditor(){
	KindEditor.plugin('example1', function(K) {
		var self = this, name = 'example1';
		self.clickToolbar(name, function() {
			var htmlobj = $('<div>'+self.html()+'</div>');
			//htmlobj.find("img").removeAttr("width");
			//htmlobj.find("img").removeAttr("height");
			//html = html.replace(/ height="\d+"/g, "");// “/”后面的是要替换的字符，“d\+”是数字,最后""里是用来填充的字符  
        	//html = html.replace(/ width="\d+"/g, ""); 
			htmlobj.find("img").attr("width","");
			htmlobj.find("img").attr("height","");
			console.log(htmlobj.html());
			self.html(htmlobj.html());
		});
	});
	var k_options = {  
		resizeType:0,
		width:'400px',
		minWidth:'400px',
		height:"480px",
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		filterMode:false,
		uploadJson:"<?=site_url('Content/Article/UploadImages')?>",
		cssData : 'img{max-width:100%;}body{font-size:14px;}',
		items : [
			'source','template','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|','table', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link','example1'],
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
