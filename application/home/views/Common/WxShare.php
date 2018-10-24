<?php if(is_weixin()==true):?>
<?php $signature = getWxSahreConfig();?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
wx.config({
    debug: false,
    appId: '<?=isset($signature['appid'])?$signature['appid']:""?>',
    timestamp: '<?=isset($signature['timestamp'])?$signature['timestamp']:""?>',
    nonceStr:  '<?=isset($signature['nonceStr'])?$signature['nonceStr']:""?>',
    signature: '<?=isset($signature['signature'])?$signature['signature']:""?>',
    jsApiList: ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo']
});
var wx_imgUrl = "<?=$WxShare_img?>";
var wx_lineLink = "<?=$WxShare_link?>";
var wx_descContent = '<?=str_replace("\n","",mb_substr($WxShare_desc, 0, 32, 'utf-8'))?>';
var wx_shareTitle = '<?=$WxShare_title?>';
wx.ready(function () {
	wx.onMenuShareAppMessage({
		title: wx_shareTitle, // 分享标题
		desc: wx_descContent, // 分享描述
		link: wx_lineLink, // 分享链接
		imgUrl: wx_imgUrl,
		type: '', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () {},
		cancel: function () {}
	});
	wx.onMenuShareTimeline({
		title: wx_shareTitle,
		link: wx_lineLink,
		imgUrl: wx_imgUrl,
		success: function () {},
		cancel: function () {}
	});
	wx.onMenuShareQQ({
		title: wx_shareTitle,
		desc: wx_descContent,
		link: wx_lineLink,
		imgUrl: wx_imgUrl,
		success: function () {},
		cancel: function () {}
	});
	wx.onMenuShareWeibo({
		title: wx_shareTitle,
		desc: wx_descContent,
		link: wx_lineLink,
		imgUrl: wx_imgUrl,
		success: function () {},
		cancel: function () {}
	});
	wx.onMenuShareQZone({
		title: wx_shareTitle,
		desc: wx_descContent,
		link: wx_lineLink,
		imgUrl: wx_imgUrl,
		success: function () {},
		cancel: function () {}
	});
	wx.error(function (res) {
	 	//alert(res.errMsg);
	});
});
</script>
<?php endif;?>