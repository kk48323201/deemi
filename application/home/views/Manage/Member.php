<?php $this->load->view("Common/Head");?>
<style>
.weui-cells{ margin-top:0;}
.weui-cell{ font-size:14px;}
.weui-label,.weui-cell__bd p{ font-size:14px;}
.weui-cells:after{ border-bottom:0;}
.weui-input{ border:1px solid #d9d9d9;border-radius:5px; padding:5px 10px; font-size:13px; color:#848484; height:20px; line-height:20px; width:80%;}
.layui-m-layer1{ z-index:2;}
.layui-m-layerbtn span:nth-child(2){ background:#1aad19; color:#FFFFFF;border-radius:0;}
#map {display: none; width: 100%;height: 100%;position: absolute;top: 0;z-index: 999;}
.red{ color:#3399FF;}
</style>
<div id="DataMain" class="weui-cells" page="1" totalpage="1" rows="30"></div>
<div class="weui-loadmore" id="loadmore">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载</span>
</div>
<div class="weui-loadmore weui-loadmore_line" id="loadend" style="display:none;">
        <span class="weui-loadmore__tips">暂无数据</span>
</div>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<div id="map">
  <iframe id="myframe" src="https://apis.map.qq.com/tools/locpicker?policy=1&total=10&search=1&type=1&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp" frameborder="0" width="100%" height="100%"></iframe>
</div>

<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script id="ListTemplate" type="text/template">
<a class="weui-cell weui-cell_access" href="javascript:edit({{MemberID}});">
	<div class="weui-cell__bd {{red}}">
	  <p>{{NickName}} (No.{{MemberID}})</p>
	</div>
	<div class="weui-cell__ft">{{RoleName}}</div>
</a>
</script>
<script id="EditMemberFormHtml" type="text/template">
<?php $this->load->view("Manage/MemberForm");?>
</script>
<script language="javascript">
var AjaxLoading = true;
$(document).ready(function(){
	getListData(1);
	$("img.lazy").lazyload();
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var maxpage = parseInt($("#DataMain").attr('totalpage'));
		var page = parseInt($("#DataMain").attr('page'));
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			getListData(page);
		}
	});
});
function getListData(inipage){
	ListMain = $("#DataMain");
	ListMain.attr("page",parseInt(inipage)+1);
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var rows = parseInt(ListMain.attr("rows"));
	var url = "<?=site_url('Manage/Member')?>?do=getData&rows="+rows+"&page="+inipage;
	var page = parseInt(inipage)+1;
	$.get(url,function(data){
    	layer.close(loading);
		if(inipage == 1){$("#DataMain").find(".weui-cell").remove();}
		$.each(data.rows, function(idx, obj) {
			var html = document.getElementById('ListTemplate').innerHTML;
			var b = new Base64();
			var NickName = obj.RealName == null||obj.RealName == ""?b.decode(obj.WechatNickname):obj.RealName;
			var red = obj.ParentID > 0?'red':'';
			html = html.replace('{{NickName}}',NickName)
    			       .replace('{{MemberID}}',obj.MemberID)
					   .replace('{{MemberID}}',obj.MemberID)
					   .replace('{{red}}',red)
					   .replace('{{RoleName}}',obj.RoleName);
			ListMain.append(html);
		});
		total = parseInt(data.total);
		totalpage = total>0?Math.ceil(total/rows):1;
		$("#DataMain").attr('totalpage',totalpage);
		if(page > totalpage || total < 1){
			$("#loadmore").hide();
			$("#loadend").show();
			AjaxLoading = false;
		}else{
			AjaxLoading = true;
		}
		$("img.lazy").lazyload();
    },"json");
}
function selectRole(){
	$("#RoleID").select({
		title: "选择角色",
		items: <?=json_encode($RoleData)?>
	});
}
function edit(MemberID){
	var loading = layer.open({type: 2});
	$.ajax({
	   type: "GET",
	   url: "<?=site_url('Manage/Member?do=getSingle')?>",
	   data: {'MemberID':MemberID},
	   dataType: "json",
	   success: function (data) {
	   		layer.close(loading);
			html = document.getElementById('EditMemberFormHtml').innerHTML;
			RealName = data.rows.RealName==null?'':data.rows.RealName;
			lat = data.rows.lat==null?'':data.rows.lat;
			lng = data.rows.lng==null?'':data.rows.lng;
			WecharAddress = data.rows.WecharAddress==null?'':data.rows.WecharAddress;
			ParentName = data.rows.ParentName == null?"":data.rows.ParentName;
			html = html.replace('{{MemberID}}',data.rows.MemberID)
					.replace('{{RealName}}',RealName)
					.replace(/{{RoleID}}/,data.rows.RoleID)
					.replace('{{WecharAddress}}',WecharAddress)
					.replace('{{RoleName}}',data.rows.RoleName)
					.replace('{{ParentName}}',ParentName)
					.replace('{{lat}}',lat)
					.replace('{{lng}}',lng);
			layer.open({
				type: 1,
				title: false,
				style:'position:absolute;top:0;left:0;width:100vw;',
				anim: 'scale',
				btn: ['保存', '关闭'],
				content:html,
				success: function(elem){
					$('#select_contact').click(function(){
						$(this).trigger('blur')
						$('#map').show()
					});
					showMap();
					selectRole();
				},
				yes:function(index){
				  save();
				  return false;
				}    
			});
	   }
   });
}
function save(){
	var loading = layer.open({type: 2});
	$("#input-RoleID").val($("#RoleID").attr('data-values'));
	$.post("<?=site_url('Manage/Member?do=save')?>",$("#MemberForm").serialize(),function(data){
		layer.close(loading);
		if(data.code == 200){
			msg('保存成功');
			getListData(1);
			layer.closeAll();
		}else{
			msg('操作失败');
		}
	},'json');
}
function showMap(){
	window.addEventListener('message', function(event) {
	  // 接收位置信息，用户选择确认位置点后选点组件会触发该事件，回传用户的位置信息
	  var loc = event.data;
	  if (loc && loc.module == 'locationPicker') {//防止其他应用也会向该页面post信息，需判断module是否为'locationPicker'
		  $('#map').hide();
		  if(loc.poiname == '我的位置'){
			  loc.poiname = '';
		  }
		  console.log(loc);
		  $('#select_contact').val(loc.poiaddress+loc.poiname);
		 // $('#input-lng').val(loc.latlng.lng);
		  $('#input-lng').val(loc.latlng.lng);
		  $('#input-lat').val(loc.latlng.lat);
	
	  }
	}, false);
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
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}
</script>
