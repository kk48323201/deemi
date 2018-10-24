<?php $this->load->view("Common/Head");?>
<style>
.swiper-slide img{ max-width:100%;}
#HomeNav{ padding-top:8px;}
#HomeNav .weui-flex__item{ text-align:center;}
#HomeNav .weui-flex__item img{ width:70px; display:inline-block;box-shadow:0 -1px 3px rgba(0,0,0,0.3);border-radius:50%;}
#HomeNav a{ color:#3f3f3f;}
#HomeNav span{ display:block; text-align:center; font-size:14px; font-weight:bold;}
#SearchBar{ width:100%; position:relative;}
#SearchBar form{ display:block; padding:10px;}
#SearchBar input {height:36px;border-radius:36px; text-indent:15px;background:#f5f5f5;outline: none; width:100%;
  position: relative; border:none;font-size:14px;}
#SearchBar button {width:42px;height:42px;background: none;border: none;position: absolute;top:7px;right:5%;}
#SearchBar button i{ font-size:18px; color:#CCCCCC;}
.titleListData{ background:url(<?=base_url()?>style/images/ico/tuijian.png) no-repeat left; background-size:auto 100%;font-size:16px; font-weight:bold;margin:10px; text-indent:30px; height:30px; line-height:30px; padding-top:2px;}
#gundong{padding:0 10px;box-sizing:border-box;height:26px;padding:0 10px;font-size:16px;position: relative;overflow: hidden; background:#D1D1D1;}
#horse{position: absolute;width:100%;-webkit-animation:horse 6s linear 0s infinite;}
@-webkit-keyframes horse
{
    0%   {left:0px;top:0px;}
    47%  {left:220px;top:0px;}
    48%  {left:220px;top:100px;}
    49%  {left:-200px;top:100px;}
    50%  {left:-200px;top:0px;}
    100% {left:0px;top:0px;}
}
</style>
<div id="gundong">
  <div id="horse">新用户首单<span style="font-weight:bold; color:#FF0000;">六折</span>优惠，限前50名用户</span></div>
</div>
<div style="clear:both; height:0;"></div>
<div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="1000">
  <div class="swiper-wrapper">
    <div class="swiper-slide"><img src="<?=base_url()?>style/images/banner.jpg"></div>
  </div>
</div>
<div id="HomeNav">
	<div class="weui-flex">
      <div class="weui-flex__item"><a href="<?=site_url('Service/index?PageID=4')?>"><img src="<?=base_url()?>style/images/img122671656f595878.png" /><span>家电清洗</span></a></div>
      <div class="weui-flex__item"><a href="<?=site_url('Service/index?PageID=5')?>"><img src="<?=base_url()?>style/images/img122691656f5ea7d8.png" /><span>水管清洗</span></a></div>
      <div class="weui-flex__item"><a href="<?=site_url('Service/index?PageID=6')?>"><img src="<?=base_url()?>style/images/img122701656f668f48.png" /><span>餐厅清洗</span></a></div>
      <div class="weui-flex__item"><a href="<?=site_url('Home/Business')?>"><img src="<?=base_url()?>style/images/img122721656f70b8d8.png" /><span>合作商家</span></a></div>
    </div>
</div>
<div id="SearchBar">
	<form>
		 <input type="text" placeholder="搜索您需要的服务">
		 <button type="submit"><i class="fa fa-search"></i></button>
	</form>
</div>
<div class="titleListData">热销服务</div>
<div style="border-bottom:1px solid #efeeee; height:0; clear:both;"></div>
<style>
.ServiceListMain{ padding:10px;}
.ServiceListMain .item{ height:90px; margin-bottom:10px;border-bottom:1px solid #efeeee; display:block; margin:10px; padding-bottom:10px; position:relative;}
.ServiceListMain .item .leftThumb{ width:90px; height:90px;float:left; background:url(/style/images/goods_bg.png) no-repeat; background-size:100% 100%;}
.ServiceListMain .item .leftThumb img{ display:block; width:100%; height:100%;}
.ServiceListMain .item .rightInfo{ padding-left:100px;}
.ServiceListMain .item .rightInfo p.title{ font-size:15px; color:#505050; font-weight:bold; line-height:24px; height:48px;}
.ServiceListMain .item .rightInfo p.price:before{ content:"¥"; color:#e81f1f; font-size:12px; margin-right:3px;}
.ServiceListMain .item .rightInfo p.price{color:#e81f1f; font-size:18px; font-weight:bold; margin-top:19px; line-height:20px;}
.ServiceListMain .item .join{ width:36px; position:absolute; right:0; bottom:10px;}
</style>
<div class="ServiceListMain" page='1' rows='20'></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Home'));?>
<?php $this->load->view("Common/Footer");?>
<script id="ServiceTemplate" type="text/template">
<a class="item" href="{{goodsUrl}}">
	<div class="leftThumb"></div>
	<div class="rightInfo">
		<p class="title">{{GoodsName}}</p>
		<p class="price">{{Price}}</p>
	</div>
	<img class="join" src="<?=base_url()?>style/images/ico/join.png" />
</a>
</script>
<script language="javascript">
var AjaxLoading = true;
$(document).ready(function(){
	getListData(1);
	$("img.lazy").lazyload();
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var maxpage = parseInt($("#ServiceListMain").attr('totalpage'));
		var page = parseInt($("#ServiceListMain").attr('page'));
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			getListData(page);
		}
	});
});
function getListData(inipage){
	ListMain = $(".ServiceListMain");
	ListMain.attr("page",parseInt(inipage)+1);
	var get = GetRequest();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var rows = ListMain.attr("rows");
	var url = "<?=site_url('Home/index')?>?do=getListData&rows="+rows+"&page="+inipage;
	$.get(url,function(data){
    	layer.close(loading);
		$.each(data.rows, function(idx, obj) {
			var html = document.getElementById('ServiceTemplate').innerHTML;
			html = html.replace('{{GoodsName}}',obj.GoodsName)
    			       .replace('{{Price}}',obj.Price)
					   .replace('{{goodsUrl}}',site_url('Goods/index/'+obj.GoodsID))
					   .replace('{{GoodsID}}',obj.GoodsID)
    			       .replace('{{Thumb}}',obj.Thumb);
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
function site_url(str){
	return 'http://'+location.host+'/index.php/'+str;
}
</script>
<?php $MemberID = isset($_SESSION['MemberID'])?$_SESSION['MemberID']:0;?>
<?php $this->load->view("Common/WxShare",array(
'WxShare_img'=>base_url().'style/images/logo.png',
'WxShare_link'=>site_url('?ShareID='.$MemberID),
'WxShare_desc'=>'了解家电二次污染，关注家人工作生活环境的空气问题！',
'WxShare_title'=>'洗哥',
));?>
<script language="javascript">
wx.ready(function () {
    wx.getLocation({
        success: function (res) {
            console.log(res.latitude);  //纬度
            console.log(res.longitude); //经度
            var geocoder = new qq.maps.Geocoder({
                complete: function (result) {   //解析成功的回调函数
                    var address = result.detail.address;  //获取详细地址信息
                    console.log(address);    
                }
            });
            geocoder.getAddress(new qq.maps.LatLng(res.latitude, res.longitude));
        },
        fail: function (res) {
        },
        cancel: function (res) {       
        }
    });
});
</script>