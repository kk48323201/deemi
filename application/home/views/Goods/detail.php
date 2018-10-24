<?php $this->load->view("Common/Head");?>
<link rel="stylesheet" href="<?=base_url()?>style/css/jquery-weui.css">
<style>
.weui-cell{ padding:13px 15px;}
#goodsDetail .Thumb img{ width:100%; display:block;}
#goodsDetail .GoodsName{ padding:15px;}
#goodsDetail .GoodsName p{ font-weight:bold;}
#goodsDetail #show_price{ font-size:18px; font-weight:bold; color:#1560ab;}
#goodsDetail .weui-cells{ margin-top:0; font-size:15px;}
#goodsDetail .desc p{ display:inline-block; font-size:12px; line-height:22px;vertical-align:middle; color:#999; margin-right:10px;}
#goodsDetail .desc p img{ width:20px; vertical-align:middle; margin-right:3px; margin-bottom:2px;}
#goodsDetail .xg_tab .weui-flex__item{ text-align:center; height:46px; line-height:46px; border-bottom:1px solid #e8e8e8; color:#999; font-size:15px; position:relative;}
#goodsDetail .xg_tab .weui-flex__item:first-child:before{ content:""; border-right:1px solid #e8e8e8; position:absolute; right:0; height:26px; top:10px;}
#goodsDetail .xg_tab .cur{ color:#333;}
#goodsDetail .xg_tab .cur:after{ content:""; height:1px; overflow:hidden;background:#1560ab; position:absolute; width:30px; right:50%; bottom:0; margin-right:-15px; display:inline-block;}
#goodsDetail .onceBuyBtn{ position:fixed; bottom:53px;border-radius:0; width:100%; font-size:16px; background:#1560ab;}
#cart .onceBuyBtn{;border-radius:0; width:100%; font-size:16px; background:#1560ab;}
#cart .weui-cell__bd p{ font-size:14px;}
#cart .weui-cell{ padding:3px 5px;}
#cart .summary {padding: 8px;text-align: right;background-color: white; font-size:14px;}
#cart .price{font-size:14px;margin-right: 6px;}
#GoodsContent{ padding:10px; padding-bottom:40px;}
#GoodsContent img{ width:100%;}
#CommentsList .item{ padding:15px 0; margin:0 10px; border-bottom:1px solid #d9d9d9;}
#CommentsList .item .info{ line-height:26px; height:26px; padding-left:60px;}
#CommentsList .item .thumb img{ width:100%; height:100%;border-radius:50%;}
#CommentsList .item .thumb{ height:44px; width:44px; float:left;}
#CommentsList .item .pull-left{ float:left; color:#333; font-size:12px;}
#CommentsList .item .pull-right{ float:right;color:#333; font-size:12px;}
#CommentsList .item .content{font-size:14px; color:#666; line-height:22px;padding-left:60px;}
.popup-bottom .weui-popup__modal{ margin-bottom:53px;}
</style>
<div id="goodsDetail">
  <div class="Thumb"><img src="<?=base_url()?>style/images/banner.jpg" /></div>
  <div class="weui-cell GoodsName">
    <div class="weui-cell__bd">
      <p><?=$data['GoodsName']?></p>
    </div>
    <div class="weui-cell__ft"><span id="show_price"><?=$data['Price']?>元</span>起</div>
  </div>
  <div class="weui-cells"> 
    <!--<a class="weui-cell weui-cell_access" href="javascript:;">
    <div class="weui-cell__bd">
      <p>请选择具体服务项</p>
    </div>
    <div class="weui-cell__ft"> </div>
    </a> -->
    <a class="weui-cell weui-cell_access" href="javascript:;">
    <div class="weui-cell__bd desc">
      <p><img src="<?=base_url()?>style/images/icon_1.png">专业服务</p>
      <p><img src="<?=base_url()?>style/images/icon_2.png">价格统一</p>
      <p><img src="<?=base_url()?>style/images/icon_3.png">售后保障</p>
    </div>
    <div class="weui-cell__ft"> </div>
    </a> 
  </div>
  <div class="weui-flex xg_tab">
      <a class="weui-flex__item cur" href="javascript:changeTab(0);">服务详情</a>
      <a class="weui-flex__item" href="javascript:changeTab(1);" >评价（<span id="CommentsCount">0</span>）</a>
  </div>
  <div class="xb_tab_content">
  		<div class="tab_content" id="GoodsContent" style="min-height:400px;"><?=html_entity_decode($data['Content'])?></div>
        <div class="tab_content" style="display:none;" id="CommentsList" totalpage='1' page='1' rows='20'>
        	<div class="weui-loadmore">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>
        </div>
  </div>
  <a href="javascript:;" class="weui-btn weui-btn_primary onceBuyBtn open-popup" data-target="#cart">立即下单</a>
</div>
<div id="cart" class='weui-popup__container popup-bottom'>
  <div class="weui-popup__overlay"></div>
  <div class="weui-popup__modal">
    <div class="toolbar">
      <div class="toolbar-inner">
        <a href="javascript:;" class="picker-button close-popup">关闭</a>
        <h1 class="title">我的服务</h1>
      </div>
    </div>
    <form action="#" id="GoodsListForm">
    <div class="modal-content">
      <div class="weui-cells">
        <?php foreach($GoodsList as $item):?>
        <div class="weui-cell weui-cell_swiped GoodsItem">
          <div class="weui-cell__bd">
            <div class="weui-cell">
              <div class="weui-cell__bd">
                <p><?=$item['GoodsName']?></p>
              </div>
              <div class="weui-cell__ft">
                <span class="price">￥<?=$item['Price']?>/<?=$item['Unit']?></span>
                <div class="weui-count">
                  <a class="weui-count__btn weui-count__decrease"></a>
                  <input class="weui-count__number" type="number" readonly="readonly" price="<?=$item['Price']?>" name="GoodsNum[<?=$item['GoodsID']?>]" value="0" />
                  <a class="weui-count__btn weui-count__increase"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
    </div>
    </form>
    <p class="summary">
      <?php if($OrderNum<1 && intval(beiguo_config('base','open_user_discount'))>0):?><span style="color:#FF0000; font-weight:bold;">（新用户首单六折优惠）</span><?php endif;?>服务共计 <strong>0.00</strong> 元
    </p>
    <a href="javascript:submitOrder();" class="weui-btn weui-btn_primary onceBuyBtn">免费预约（勾选服务清单）</a>
  </div>
</div>
<div class="zclear" style="height:80px;"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Home'));?>
<?php $this->load->view("Common/Footer");?>
<?php $MemberID = isset($_SESSION['MemberID'])?$_SESSION['MemberID']:0;?>
<?php $this->load->view("Common/WxShare",array(
'WxShare_img'=>base_url().'style/images/logo.png',
'WxShare_link'=>site_url('?ShareID='.$MemberID),
'WxShare_desc'=>'了解家电二次污染，关注家人工作生活环境的空气问题！',
'WxShare_title'=>'洗哥',
));?>
<script id="CommentsTemplate" type="text/template">
<div class="item">
	<div class="thumb"><img src="{{Avatar}}" /></div>
	<p class="info"><span class="pull-left">{{NickName}}</span><span class="pull-right">{{CreateTime}}</span></p>
	<p class="content">{{Content}}</p>
	<div class="zclear"></div>
</div>
</script>
<script language="javascript">
$(function(){
	$(".weui-count__decrease").click(function(){
		updateCartOrder();
	});
	$(".weui-count__increase").click(function(){
		updateCartOrder();
	});
});
function updateCartOrder(){
	 var total = 0.00;
	 $(".weui-count__number").each(function(){
    	 total = total + parseFloat($(this).attr('price'))*parseInt($(this).val()); 
  	 });
	 <?php if($OrderNum<1 && intval(beiguo_config('base','open_user_discount'))>0):?>
	 total = total.toFixed(2)*<?=beiguo_config('base','user_discount')?>;
	 <?php endif;?>
	 $(".summary").find("strong").text(total.toFixed(2));
}
var MAX = 99, MIN = 0;
$('.weui-count__decrease').click(function (e) {
	var $input = $(e.currentTarget).parent().find('.weui-count__number');
	var number = parseInt($input.val() || "0") - 1
	if (number < MIN) number = MIN;
	$input.val(number)
})
$('.weui-count__increase').click(function (e) {
	var $input = $(e.currentTarget).parent().find('.weui-count__number');
	var number = parseInt($input.val() || "0") + 1
	if (number > MAX) number = MAX;
	$input.val(number)
})
function changeTab(x){
	$(".xg_tab .weui-flex__item").removeClass('cur');
	$(".xg_tab .weui-flex__item:eq("+x+")").addClass('cur');
	$('.tab_content').hide();
	$(".tab_content:eq("+x+")").show();
}
function showServiceList(){
	html = document.getElementById('GoodsListTem').innerHTML;
	layer.open({
    	type: 1
    	,content:html
    	,anim: 3
    	,style: 'position:fixed; bottom:0; left:0; width: 100%;padding:10px 0;box-sizing: border-box;border:none;'
  	});
}
function submitOrder(){
	var total = $(".summary").find("strong").text();
	if(parseFloat(total) < 0.01){
		msg('请选择服务');return false;
	}
	var postdata = $("#GoodsListForm").serialize();
	var url = "<?=site_url('Cart/index?do=SaveTmpDataData')?>";
	$.post(url,postdata,function(data){
		if(data.code == 200){
			window.location.href="<?=site_url('Cart/index?do=Once')?>";
		}else{
			msg('操作失败');
		}
	},'json');
}
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}

var AjaxLoading = true;
$(document).ready(function(){
	getListData(1);
	$("img.lazy").lazyload();
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var maxpage = parseInt($("#CommentsList").attr('totalpage'));
		var page = parseInt($("#CommentsList").attr('page'));
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			getListData(page);
		}
	});
});
function getListData(inipage){
	ListMain = $("#CommentsList");
	ListMain.attr("page",parseInt(inipage)+1);
	var get = GetRequest();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var rows = ListMain.attr("rows");
	var url = "<?=site_url('Goods/index')?>?do=getCommentsListData&GoodsID=<?=$data['GoodsID']?>&rows="+rows+"&page="+inipage;
	$.get(url,function(data){
    	layer.close(loading);
		$("#CommentsCount").text(data.total);
		$.each(data.rows, function(idx, obj) {
			var html = document.getElementById('CommentsTemplate').innerHTML;
			ContentText = '满意，';
			if(obj.Simple == 2){
				ContentText = '不满意，';
			}
			var b = new Base64();
			ContentText = ContentText + obj.Remark;
			html = html.replace('{{Avatar}}',obj.WechatHeadimgurl)
    			       .replace('{{NickName}}',b.decode(obj.WechatNickname))
					   .replace('{{CreateTime}}',obj.CreateTime2)
					   .replace('{{Content}}',ContentText);
			ListMain.append(html);
		});
    	ListMain.attr("total",parseInt(data.total));
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