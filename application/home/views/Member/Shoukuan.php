<?php $this->load->view("Common/Head");?>
<style>
body{ background:#efeff4;}
.weui-flex{ border-bottom:1px solid #d9d9d9; text-align:center;}
.weui-flex a{color:#353535; display:block; height:50px; line-height:50px; background:#FFFFFF; font-weight:bold; font-size:20px;}
.weui-flex a:active{ background:#F3F3F3;}
.weui-flex .weui-flex__item:nth-child(2){ border-left:1px solid #d9d9d9; border-right:1px solid #d9d9d9;}
#keyboard{ position:fixed; bottom:52px; left:0; width:100%;}
#MerchantsTitle{ margin:0 auto; background:#fafafa; width:80%; padding:18px; margin-top:10px;}
#MerchantsTitle h1{ font-size:18px; color:#000000;}
#PaymentMain{margin:0 auto; background:#fff; width:80%; padding:18px;}
#PaymentMain a{ font-size:14px; margin-top:20px;}
#Result{ border-bottom:1px solid #e2e2e2; position:relative;}
#Result i{ font-style:normal; margin-right:10px;font-size:20px; position:absolute; left:0; bottom:0;}
#Result #Amount{ font-size:36px;font-weight:bold; border:none; text-indent:20px; width:100%;}

</style>
<div id="MerchantsTitle">
	<h1>祝您生活愉快</h1>
</div>
<div id="PaymentMain">
	<p style="font-size:14px; color:#b2b2b2;">消费金额</p>
    <div id="Result"><i>¥</i> <input type="text" value="0.00" name="Amount" id="Amount" maxlength="6" readonly="readonly" /></div>
    <a href="javascript:payment();" class="weui-btn weui-btn_primary">立即付款</a>
</div>
<div id="keyboard">
  <div class="weui-flex">
    <div class="weui-flex__item"><a href="javascript:enter(1);">1</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(2);">2</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(3);">3</a></div>
  </div>
  <div class="weui-flex">
    <div class="weui-flex__item"><a href="javascript:enter(4);">4</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(5);">5</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(6);">6</a></div>
  </div>
  <div class="weui-flex">
    <div class="weui-flex__item"><a href="javascript:enter(7);">7</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(8);">8</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(9);">9</a></div>
  </div>
  <div class="weui-flex">
    <div class="weui-flex__item"><a href="javascript:enter('.');">.</a></div>
    <div class="weui-flex__item"><a href="javascript:enter(0);">0</a></div>
    <div class="weui-flex__item"><a href="javascript:enter('x');">x</a></div>
  </div>
</div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
function payment(){
	var url = site_url('Shoukuan/index?do=WechatF2F');
	var Amount = fmoney($("#Amount").val());
	if(Amount==0.00){
		$.toast("请输入金额", "forbidden");return false;
	}
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	$.ajax({
		type: "POST",
		url: url,
		dataType: 'json',
		data:{Amount:Amount},
		success: function (data) {
			layer.close(loading);
			if(data.code==500){
				$.toast(data.rows, "cancel");
				return false;
			}
			jsApiCall(
			data.rows.appId,
			data.rows.timeStamp,
			data.rows.nonceStr,
			data.rows.package,
			data.rows.signType,
			data.rows.paySign
			);
			/*欠缺返回值*/
		}
	});
}
function jsApiCall(appId, timeStamp, nonceStr, package, signType, paySign){
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',{
             "appId": appId,    //公众号名称，由商户传入
             "timeStamp":timeStamp,    //时间戳，自 1970 年以来的秒数
             "nonceStr": nonceStr, //随机串
             "package": package,
             "signType": signType,    //微信签名方式
             "paySign": paySign //微信签名
        },
		function(res){
			if(res.err_msg == 'get_brand_wcpay_request:cancel'){
				$.toast("交易已取消", "forbidden");
			}else if(res.err_msg == 'get_brand_wcpay_request:ok'){
				$.toast("交易成功");
				setTimeout(function(){
					location.reload();
				},1500)
			}else{
				$.toast("系统交易发生错误", "forbidden");
			}
			return false;
		}
	);
}
function enter(e){
	var rs = $("#Amount").val();
	if(e == 'x'){
		$("#Amount").val('0.00');
		return true;
	}
	
	if(e == '.'){
		if(rs.indexOf(".") > 0){
			return true;
		}
	}
	if(rs=='0.00'){
		rs = e;
	}else{
		rs = rs+e;
	}

	$("#Amount").val(rs);
}
</script>
<?php $this->load->view("Common/WxShare",array(
'WxShare_img'=>base_url('style/images/logo.png'),
'WxShare_link'=>site_url('Merchants/Shoukuan'),
'WxShare_desc'=>"欢迎使用“洗哥”面对面在线收款，祝您生活愉快，财运亨通！",
'WxShare_title'=>'面对面在线支付',
));?>