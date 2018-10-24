<?php $this->load->view("Common/Head");?>
<style>
.font14 {font-size:14px; margin:0;}
.weui-media-box__thumb{ width:60px; height:60px;}
.weui-media-box__bd{ height:60px;}
.clear008{clear:both; height:8px; background:#eeeef4; overflow:hidden;}
.weui-cell{ background:#FFFFFF;}
.font14{ font-size:14px;}
#payBtn{ color:#FFFFFF; text-decoration:none;}
</style>
<form method="post" action="" id="form-formview">
  <input type="hidden" name="CourseID" value="<?=$data['CourseID']?>" />
  <div class="weui-cells weui-cells_form" style="margin-top:0;">
    <div class="weui-cells__title">报名人信息</div>
    <div class="weui-cell">
      <div class="weui-cell__hd">
        <label class="weui-label font14">联系人</label>
      </div>
      <div class="weui-cell__bd">
        <input class="weui-input font14" type="text" name="Contact" id="Contact" placeholder="请输入联系人" value="">
      </div>
    </div>
    <div class="weui-cell">
      <div class="weui-cell__hd">
        <label class="weui-label font14">手机号码</label>
      </div>
      <div class="weui-cell__bd">
        <input class="weui-input font14" type="tel" name="Phone" id="Phone" placeholder="请输入手机号码" value="">
      </div>
    </div>
  </div>
  <div class="clear008"></div>
  <div class="weui-panel weui-panel_access" style="margin-top:0;">
    <div class="weui-panel__hd">粤音琴行</div>
    <div class="weui-media-box weui-media-box_appmsg" style="background:#f8f8f8;">
    <div class="weui-media-box__hd"> <img class="weui-media-box__thumb" src="<?=base_url('style/images/logo.jpg')?>" style="border:#CCCCCC 1px solid;" /> </div>
    <div class="weui-media-box__bd">
      <h4 class="weui-media-box__title font14" style="margin-bottom:5px;"><?=$data['CourseName']?></h4>
      <p class="weui-media-box__desc"><?=$data['Description']?></p>
    </div>
    </div> </div>
  <div class="weui-flex" style="border-top:1px solid #dddddd; position:fixed; bottom:0; width:100%;">
    <div class="weui-flex__item" style="line-height:38px;text-indent:15px; background:#FFFFFF;">合计：<span style="color:#ff9933; font-size:16px;" id="nowpeice">¥<?=$data['Price']?></span></div>
    <div class="weui-flex__item"><a href="javascript:submitOrder();" class="weui-btn weui-btn_primary" id="payBtn" style="border-radius:0; font-size:15px;">马上支付</a></div>
  </div>
</form>
<?php $this->load->view("Common/Footer");?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
function submitOrder(){
	var Contact = $("#Contact").val();
	var Phone = $("#Phone").val();
	if(Contact==''){
		msg('请输入联系人');return false;		
	}
	if(Phone == ''){
		msg('请输入手机号码');return false;
	}
	var loading = layer.open({type: 2,shadeClose: false});
	$.post("<?=site_url('Course/OrderPay')?>",$("#form-formview").serialize(),function(data){
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
	},'json');
}
function jsApiCall(appId, timeStamp, nonceStr, package, signType, paySign){
	var OrderSn = $("#form-formview").find("input[name=Sn]").val();
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
				$.toast("支付成功", function() {
					window.location.href='<?=base_url()?>';
				});
			}else{
				$.toast("系统交易发生错误", "forbidden");
			}
			return false;
		}
	);
}
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}
</script>
