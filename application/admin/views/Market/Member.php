<?php $this->load->view('Common/header.php');?>
<style>
.search_bar_row{display:block;margin:5px 3px; color:#FFFFFF; font-size:12px;}
#ThumbDiv img{max-width:100%;max-height:100%;}
.white_a{ color:#FFFFFF; text-decoration:none;}
.btn-text{ padding:0 5px;}
</style>
<table id="MemberTable">
</table>
<?php $this->load->view('Common/footer.php');?>
<script language="javascript">
$(function () {
		$.extend($.fn.validatebox.defaults.rules, {    
		    /*必须和某个字段相等*/  
		    equalTo: {  
		        validator:function(value,param){  
		            return $(param[0]).val() == value;  
		        },  
		        message:"两次密码输入不一样"  
		    },
			phoneNum: { //验证手机号   
				validator: function(value, param){ 
				 return /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value);
				},    
				message: '请输入正确的手机号码。'   
			}
		}); 
});
getListData();
function getListData(){
$("#MemberTable").datagrid({  
    toolbar:'#tb_member',
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Member')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'MemberID',align:'center',title:'编号'},
		{field:'WechatNickname',width:160,align:'left',title:'微信昵称',formatter:function(val,row){
			return val;
		}},
		{field:'WechatProvince',align:'left',title:'微信省份'},
		{field:'WechatCity',title:'微信城市'},
		{field:'WechatSex',width:40,title:'性别',formatter:function(val,row){
			var rs = '保密';
			if(val==1){rs='男';}else if(rs==2){rs='女';}
			return rs;
		}},
		{field:'CreateTime',width:150,title:'创建时间'},
	]]
});	
}
function showWeiXinQrcode(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('WeiXinQrcodeView');
	var obj = $("#WeiXinQrcodeView").dialog({
		title : '微信二维码',
		resizable : true,
		method : 'post',
		height:420,
		width :400,
		top:'50px',
		modal:true,
		href : "<?=site_url('Member')?>?do=WeiXinQrcode&MemberID="+row.MemberID,
		onLoad : function(str) {}
	});
}
function searchData(){
	var s_WechatNickname = $("#s_WechatNickname").textbox('getValue');
	var s_Mobile = $("#s_Mobile").textbox('getValue');
	var s_MemberID = $("#s_MemberID").textbox('getValue');
	$('#MemberTable').datagrid('load',{
		WechatNickname: s_WechatNickname,
		Mobile: s_Mobile,
		MemberID: s_MemberID,
	});
}
function editData(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('EditMember');
	var obj = $("#EditMember").dialog({
		title : '编辑会员',
		resizable : true,
		method : 'post',
		height:'auto',
		width : 600,
		top:'50px',
		href : "<?=site_url('Member')?>?do=edit&MemberID="+row.MemberID,
		onLoad : function(str) {  
           CreateSexInput(row.WechatSex);
		   try {
			   obj = eval('(' + str + ')');
			   if(obj.code == 'error'){
				  $.messager.alert('error',obj.message,'error');
				  $("#EditMember").dialog('destroy');
			   }
　　 	   }catch(err) {}
		   
        }
	});
}
function newData(){
	onResetGroup();
	rebulidDialog('AddMember');
	var obj = $("#AddMember").dialog({
		title : '新增会员',
		resizable : true,
		method : 'post',
		height:'auto',
		width : 600,
		top:'50px',
		href : "<?=site_url('Member')?>?do=Add",
		onLoad : function(str) {  
          CreateSexInput(0);
        }
	});
}
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
function delData(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	$.messager.confirm('信息','确定删除？',function(r){
    	if (!r){return false;}
		$.get("<?=site_url('Member')?>?do=del&MemberID="+row.MemberID,function(str,status){
			obj = eval('(' + str + ')');
			if(obj.code == '200'){
				$.messager.alert('title','<div align="center">信息已删除</div>');
				$('#MemberTable').datagrid('reload');
			}else{
				$.messager.alert('error',obj.message,'error');
			}
		});
	});
}
function PurseData(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	rebulidDialog('MemberPurse');
	
	var obj = $("#MemberPurse").dialog({
		title : '消费记录',
		resizable : true,
		method : 'post',
		height:600,
		width : 600,
		top:'50px',
		href : "<?=site_url('Member')?>?do=Purse",
		onLoad : function(str) {  
        	getPurseListData(row.MemberID);
        }
	});
}
function getPurseListData(MemberID){
$("#MemberPurseTable").datagrid({  
	rownumbers:true,
	pageSize:10,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Member')?>?do=PurseListData&MemberID='+MemberID,
	method:'get',
    columns : [[
		{field:'ProName',width:160,align:'left',title:'名称'},
		{field:'Amount',width:130,align:'left',title:'金额'},
		{field:'CreateTime',width:160,align:'left',title:'时间'}
	]]
});	
}
/**********常用方法**********/
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
			$("#WechatHeadimgurl").val(e.target.result);
		};  
	}  
}
/*动态检查账号重复*/
function checkMobileRepeat(){
	var dateUrl = "<?=site_url('Member')?>?do=checkMobileRepeat";
	var Mobile = $("#Mobile").textbox('getValue');
	var MemberID = $("#MemberID").val();
	var result = true;
	$.ajax({
	    type:'POST',
		url:dateUrl,
		data:{'Mobile':Mobile,'MemberID':MemberID},
		async:false,
		success:function (str){ 
    		var obj = eval('(' + str + ')');
			if(obj.code != '200'){
				$.messager.alert('错误','绑定号码已存在，请勿重复','error');
				result = false;
			}else{
				result = true;
			}
    	} 
	});
	return result;
}
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('Member')?>?do=save",
		onSubmit : function(){
			$.messager.progress({'text':'正在保存数据,请稍后......', showType:'fade'});
			rs = $(this).form('validate');
			if(!rs){$.messager.progress('close');}
			if(rs){
				rs = checkMobileRepeat();
				if(!rs){$.messager.progress('close');}
			}
			return rs;
		},
		success : function(str) {
		   $.messager.progress('close');
		   obj = eval('(' + str + ')');
		   if(obj.code == '200'){
		   	 $.messager.alert('信息','<div align="center">信息已保存</div>');
			 //getListData();
			 onResetGroup();
			 $('#MemberTable').datagrid('reload');
		   }else{
		   	 $.messager.alert('error','系统发生错误','error');
		   }
		}
	});
}
function onResetGroup() {
	$("#AddMember").dialog('destroy');
	$("#EditMember").dialog('destroy');
	$("#ContactView").dialog('destroy');
	$("#WeiXinQrcode").dialog('destroy');
}
function rebulidDialog(divID){
	var obj = $('#'+divID).dialog({onOpen:function(){}});
	if(obj){
		obj.dialog('destroy');
		$('body').append('<div id="'+divID+'"></div>');
	}
}
</script>