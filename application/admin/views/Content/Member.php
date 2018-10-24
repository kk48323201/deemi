<?php $this->load->view('Common/header.php');?>
<style>
.search_bar_row{display:block;margin:5px 3px; color:#FFFFFF; font-size:12px;}
#ThumbDiv img{max-width:100%;max-height:100%;}
.white_a{ color:#FFFFFF; text-decoration:none;}
.btn-text{ padding:0 5px;}
</style>
<div id="tb_member" style="padding:5px;">
	<a href="javascript:editData();" class="easyui-linkbutton" iconCls="icon-edit">编辑</a>
    &nbsp;
    <a href="javascript:showWeiXinQrcode();" class="easyui-linkbutton" iconCls="icon-search">二维码</a>
    &nbsp;
    <a href="javascript:AgentReport();" class="easyui-linkbutton" iconCls="icon-search">粉丝收益报表</a>
    &nbsp;
    <a href="javascript:OrderReport();" class="easyui-linkbutton" iconCls="icon-search">订单收益报表</a>
</div>
<table id="MemberTable"></table>
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
function AgentReport(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	
	rebulidDialog('ReportView');
	var obj = $("#ReportView").dialog({
		title : '粉丝收益报表',
		resizable : true,
		method : 'get',
		queryParams:{MemberID:row.MemberID},
		modal:true,
		height:400,
		width:600,
		top:'50px',
		href : "<?=site_url('Content/Member/AgentReport')?>",
		onLoad : function(str) {  
          
        }
	});
}
function OrderReport(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	
	rebulidDialog('ReportView');
	var obj = $("#ReportView").dialog({
		title : '订单收益报表',
		resizable : true,
		method : 'get',
		modal:true,
		queryParams:{MemberID:row.MemberID},
		height:400,
		width:600,
		top:'50px',
		href : "<?=site_url('Content/Member/OrderReport')?>",
		onLoad : function(str) {  
          
        }
	});
}
function getListData(){
$("#MemberTable").datagrid({  
    toolbar:'#tb_member',
	pageSize:20,
	fit:true,
	singleSelect:true,
	pagePosition:'bottom',
	pagination:true,
	url:'<?=site_url('Content/Member')?>?do=ListData',
	method:'get',
    columns : [[
		{field:'MemberID',align:'center',title:'编号'},
		{field:'Mobile',width:140,align:'left',title:'手机号码',formatter:function(val,row){
			return val;
		}},
		{field:'WechatNickname',width:160,align:'left',title:'微信昵称',formatter:function(val,row){
			var base = new Base64();
			return base.decode(val);
		}},
		{field:'RealName',width:160,align:'left',title:'真实姓名'},
		{field:'RoleName',width:80,align:'left',title:'角色'},
		{field:'WechatSex',width:100,align:'left',title:'性别',formatter:function(val,row){
			var rs = '';
			switch(val){
				case 1:
					rs = '男';
					break;
				case 2:
					rs = '女';
					break;
				default:
					rs = '保密';
					break;
			}
			return rs;
		}},
		{field:'Status',width:40,title:'状态',formatter:function(val,row){
			if(val==0){
				return '禁用';
			}else{
				return '启用';
			}
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
		href : "<?=site_url('Content/Member')?>?do=WeiXinQrcode&MemberID="+row.MemberID,
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
		href : "<?=site_url('Content/Member')?>?do=edit&MemberID="+row.MemberID,
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
		href : "<?=site_url('Content/Member')?>?do=add",
		onLoad : function(str) {  
          CreateSexInput(0);
        }
	});
}
function delData(){
	onResetGroup();
	var row = $('#MemberTable').datagrid('getSelected');
	if(!row){$.messager.alert('信息','请选择数据','info');return false;}
	$.messager.confirm('信息','确定删除？',function(r){
    	if (!r){return false;}
		$.get("<?=site_url('Content/Member')?>?do=del&MemberID="+row.MemberID,function(str,status){
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
/**********常用方法**********/
function onSubmitGroup() {
	$("#form-information").form('submit', {
		url : "<?=site_url('Content/Member')?>?do=save",
		onSubmit : function(){
			$.messager.progress({'text':'正在保存数据,请稍后......', showType:'fade'});
			rs = $(this).form('validate');
			if(!rs){$.messager.progress('close');}
			return rs;
		},
		success : function(str) {
		   $.messager.progress('close');
		   obj = eval('(' + str + ')');
		   if(obj.code == '200'){
		   	 $.messager.alert('信息',obj.info);
			 onResetGroup();
			 $('#MemberTable').datagrid('reload');
		   }else{
		   	 $.messager.alert('信息',obj.info,'error');
		   }
		}
	});
}
function onResetGroup() {
	$("#AddMember").dialog('destroy');
	$("#EditMember").dialog('destroy');
	$("#ContactView").dialog('destroy');
	$("#WeiXinQrcode").dialog('destroy');
	$("#ReportView").dialog('destroy');
}
function rebulidDialog(divID){
	var obj = $('#'+divID).dialog({onOpen:function(){}});
	if(obj){
		obj.dialog('destroy');
		$('body').append('<div id="'+divID+'"></div>');
	}
}
function Base64() {  

    // private property  
    _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";  

    // public method for encoding  
    this.encode = function (input) {  
        var output = "";  
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;  
        var i = 0;  
        input = _utf8_encode(input);  
        while (i < input.length) {  
            chr1 = input.charCodeAt(i++);  
            chr2 = input.charCodeAt(i++);  
            chr3 = input.charCodeAt(i++);  
            enc1 = chr1 >> 2;  
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);  
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);  
            enc4 = chr3 & 63;  
            if (isNaN(chr2)) {  
                enc3 = enc4 = 64;  
            } else if (isNaN(chr3)) {  
                enc4 = 64;  
            }  
            output = output +  
            _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +  
            _keyStr.charAt(enc3) + _keyStr.charAt(enc4);  
        }  
        return output;  
    }  

    // public method for decoding  
    this.decode = function (input) {  
        var output = "";  
        var chr1, chr2, chr3;  
        var enc1, enc2, enc3, enc4;  
        var i = 0;  
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");  
        while (i < input.length) {  
            enc1 = _keyStr.indexOf(input.charAt(i++));  
            enc2 = _keyStr.indexOf(input.charAt(i++));  
            enc3 = _keyStr.indexOf(input.charAt(i++));  
            enc4 = _keyStr.indexOf(input.charAt(i++));  
            chr1 = (enc1 << 2) | (enc2 >> 4);  
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);  
            chr3 = ((enc3 & 3) << 6) | enc4;  
            output = output + String.fromCharCode(chr1);  
            if (enc3 != 64) {  
                output = output + String.fromCharCode(chr2);  
            }  
            if (enc4 != 64) {  
                output = output + String.fromCharCode(chr3);  
            }  
        }  
        output = _utf8_decode(output);  
        return output;  
    }  

    // private method for UTF-8 encoding  
    _utf8_encode = function (string) {  
        string = string.replace(/\r\n/g,"\n");  
        var utftext = "";  
        for (var n = 0; n < string.length; n++) {  
            var c = string.charCodeAt(n);  
            if (c < 128) {  
                utftext += String.fromCharCode(c);  
            } else if((c > 127) && (c < 2048)) {  
                utftext += String.fromCharCode((c >> 6) | 192);  
                utftext += String.fromCharCode((c & 63) | 128);  
            } else {  
                utftext += String.fromCharCode((c >> 12) | 224);  
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);  
                utftext += String.fromCharCode((c & 63) | 128);  
            }  

        }  
        return utftext;  
    }  

    // private method for UTF-8 decoding  
    _utf8_decode = function (utftext) {  
        var string = "";  
        var i = 0;  
        var c = c1 = c2 = 0;  
        while ( i < utftext.length ) {  
            c = utftext.charCodeAt(i);  
            if (c < 128) {  
                string += String.fromCharCode(c);  
                i++;  
            } else if((c > 191) && (c < 224)) {  
                c2 = utftext.charCodeAt(i+1);  
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));  
                i += 2;  
            } else {  
                c2 = utftext.charCodeAt(i+1);  
                c3 = utftext.charCodeAt(i+2);  
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));  
                i += 3;  
            }  
        }  
        return string;  
    }  
}
</script>