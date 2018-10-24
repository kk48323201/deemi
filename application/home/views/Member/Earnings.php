<?php $this->load->view("Common/Head");?>
<style>
#member-order-nav{background:#FFF;border-bottom:1px solid #c4c4c4; overflow:hidden;-webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.3); width:100%;-webkit-box-shadow:0 .03px .03px 0 rgba(0,0,0,.2);box-shadow:0 .03px .03px 0 rgba(0,0,0,.2); position:fixed; top:0; z-index:99;}
#member-order-nav a{ color:#5d5d5d; float:left; line-height:32px; text-decoration:none;font-size:14px; border-bottom:2px solid #FFFFFF; display:inline-block; width:50%; text-align:center;}
#member-order-nav a.cur{ color:#4788ca; border-bottom:2px solid #4788ca;}
.weui-cell{ font-size:14px;}
</style>
<div id="member-order-nav"> <a href="#0" class="cur" onclick="changeTab(0)">粉丝</a> <a href="#1" onclick="changeTab(1)">收益</a></div>
<div style="clear:both; height:35px;"></div>
<div id="MainContainer" page="1" maxpage="1" Status="0"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script type="text/template" id="OrderRowHtml">
<div class="weui-cell">
    <div class="weui-cell__bd">
      <p>{{LeftValue}}</p>
    </div>
    <div class="weui-cell__ft">{{RightValue}}</div>
  </div>
</script>
<script language="javascript">
$(document).ready(function(){
	if(window.location.hash!=''){
		x = window.location.hash.replace('#','');
		changeTab(x);
	}else{
		changeTab(0);
	}
	var AjaxLoading = true;
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var total = parseInt($("#MainContainer").attr('total'));
		var page = parseInt($("#MainContainer").attr('page'));
		var rows = parseInt($("#MainContainer").attr('rows'));
		var maxpage = total < 1?1:Math.ceil(total/rows)*1;
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			if(AjaxLoading == true){
				getListData(page);
			}
		}
	});
});

function changeTab(x){
	$("#member-order-nav a").removeClass("cur");
	$("#member-order-nav a:eq("+x+")").addClass("cur");
	$("#MainContainer").attr('Status',x);
	/*$("#OrderListDataMain").html('');
	var Status = x;
	$("#OrderListDataMain").attr("page","1");
	LoadListData(Status,1);*/
	getListData(1);
}
function getListData(inipage){
	var get = GetRequest();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var url = "<?=site_url('Member/Earnings?do=getData')?>";
	var rows = $("#MainContainer").attr("rows");
	var Status = $("#MainContainer").attr('Status');
	var postData = {'page':inipage,'rows':rows,'Status':Status};
	if(inipage == 1){
		$("#MainContainer").html('');
	}
	AjaxLoading = false;
	$("#MainContainer").attr("page",parseInt(inipage)+1);
	$.post(url,postData,function(data){
    	layer.close(loading);
		$.each(data.rows, function(idx, obj) {
			var html = document.getElementById('OrderRowHtml').innerHTML;
			if(Status == 0){
				var base = new Base64();
				html = html.replace('{{LeftValue}}',base.decode(obj.WechatNickname))
						   .replace('{{RightValue}}',obj.DndirectBonusTotal);
			}else{
				html = html.replace('{{LeftValue}}',obj.Sn)
						   .replace('{{RightValue}}',obj.CreateTime);

			}
			$("#MainContainer").append(html);
		});
		$("#MainContainer").attr("total",parseInt(data.total));
		if(rows*inipage >= parseInt(data.total) || parseInt(data.total) < 1){
			$(".weui-loadmore").hide();
			AjaxLoading = false;
		}else{
			AjaxLoading = true;
		}
		$("img.lazy").lazyload();
    },"json");
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
