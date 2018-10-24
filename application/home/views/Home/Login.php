<?php $this->load->view("Common/Head");?>
<style>
#Jquery_weiui_LoginForm{ font-size:15px;}
.login_bg {
  width: 100%;
  height: 32vh;
  background: url(<?=base_url()?>style/images/banner.jpg) no-repeat top center;
  background-size: 100%;
}
button.weui-vcode-btn{ font-size:15px; color:#1560ab;}
</style>
<!--<div class="login_bg"></div>-->
<div class="weui-cells" id="Jquery_weiui_LoginForm">
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">手机号码</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="number" required maxlength="11" value="13702768919" pattern="[0-9]*" name="Mobile" id="Mobile" placeholder="请输入手机号码">
    </div>
  </div>
  <div class="weui-cell weui-cell_vcode">
    <div class="weui-cell__hd">
      <label class="weui-label">验证码</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="number" required name="vcode" id="vcode" value="123" placeholder="请输入验证码">
    </div>
    <div class="weui-cell__ft">
      <button class="weui-vcode-btn">获取验证码</button>
    </div>
  </div>
</div>
<div style="padding:5px; background:none; margin-top:15px;">
	<a class="weui-btn weui-btn_primary" href="javascript:login();" style="font-size:14px;background:#1560ab;">立即登录</a>
</div>
<div class="login_tip">
   <p style="font-size:13px; text-align:center; line-height:30px;">未注册过的手机号码将会为您自动用户账号</p>
</div>
<label for="weuiAgree" class="weui-agree" style="position:absolute; bottom:0; left:0; width:100%; text-align:center; line-height:60px; padding:0; font-size:15px;">
      <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox" checked="checked">
      <span class="weui-agree__text">
        我已阅读并同意<a href="javascript:void(0);">《服务平台用户协议》</a>
      </span>
</label>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
function login(){
	var Mobile = $("#Mobile").val();
	var vcode = $("#vcode").val();
	if(Mobile==''){
		$.toast("输入手机号码", "cancel");return false;
	}
	if(!checkPhone()){
		$.toast("号码格式错误", "cancel");return false;
	}
	if(vcode==''){
		$.toast("输入验证码", "cancel");return false;
	}
	$.post("<?=site_url('Home/Login?do=login')?>",{Mobile:Mobile,vcode:vcode},function(e){
    	if(e.code == 200){
			$.toast("登录成功");
			self.location="<?=site_url('Home')?>"; 
		}else{
			$.toast("登录失败", "cancel");
		}
    },"json");
}
function checkPhone(){
   var phone = $("#Mobile").val();
   if(!(/^1[34578]\d{9}$/.test(phone))){
     $.toast("号码格式错误", "cancel");
     return false;
   }else{return true;}
}
</script>