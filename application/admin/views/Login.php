<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>登入</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="<?=base_url()?>style/libraries/jquery.min.3.2.1.js"></script>
<script charset="utf-8" src="<?=base_url()?>style/libraries/layui-v2.2.5/layui/layui.all.js"></script>
<link rel="stylesheet" href="<?=base_url()?>style/libraries/layui-v2.2.5/layui/css/layui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/libraries/font-awesome-4.5.0/css/font-awesome.min.css" />
<style>
#LAY_app,body,html{height:100%}.layui-layout-body{overflow:auto}#LAY-user-login,.layadmin-user-display-show{display:block!important}.layadmin-user-login{position:relative;left:0;top:0;padding:110px 0;min-height:100%;box-sizing:border-box}.layadmin-user-login-main{width:375px;margin:0 auto;box-sizing:border-box}.layadmin-user-login-box{padding:20px}.layadmin-user-login-header{text-align:center}.layadmin-user-login-header h2{margin-bottom:10px;font-weight:300;font-size:30px;color:#000}.layadmin-user-login-header p{font-weight:300;color:#999}.layadmin-user-login-body .layui-form-item{position:relative}.layadmin-user-login-icon{position:absolute;left:1px;top:1px;width:38px;line-height:36px;text-align:center;color:#d2d2d2}.layadmin-user-login-body .layui-form-item .layui-input{padding-left:38px}.layadmin-user-login-codeimg{max-height:38px;width:100%;cursor:pointer;box-sizing:border-box}.layadmin-user-login-other{position:relative;font-size:0;line-height:38px;padding-top:20px}.layadmin-user-login-other>*{display:inline-block;vertical-align:middle;margin-right:10px;font-size:14px}.layadmin-user-login-other .layui-icon{position:relative;top:2px;font-size:26px}.layadmin-user-login-other a:hover{opacity:.8}.layadmin-user-jump-change{float:right}.layadmin-user-login-footer{position:absolute;left:0;bottom:0;width:100%;line-height:30px;padding:20px;text-align:center;box-sizing:border-box;color:rgba(0,0,0,.5)}.layadmin-user-login-footer span{padding:0 5px}.layadmin-user-login-footer a{padding:0 5px;color:rgba(0,0,0,.5)}.layadmin-user-login-footer a:hover{color:rgba(0,0,0,1)}.layadmin-user-login-main[bgimg]{background-color:#fff;box-shadow:0 0 5px rgba(0,0,0,.05)}.ladmin-user-login-theme{position:fixed;bottom:0;left:0;width:100%;text-align:center}.ladmin-user-login-theme ul{display:inline-block;padding:5px;background-color:#fff}.ladmin-user-login-theme ul li{display:inline-block;vertical-align:top;width:64px;height:43px;cursor:pointer;transition:all .3s;-webkit-transition:all .3s;background-color:#f2f2f2}.ladmin-user-login-theme ul li:hover{opacity:.9}
</style>
</head>
<body style="background-color:#f2f2f2;">
<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">
  <div class="layadmin-user-login-main">
    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
      <div class="layui-form-item">
        <label style="position:absolute; width:38px; height:38px; line-height:38px; text-align:center;"><i class="fa fa-user" aria-hidden="true"></i></label>
        <input type="text" name="AdminUser" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
      </div>
      <div class="layui-form-item">
        <label style="position:absolute; width:38px; height:38px; line-height:38px; text-align:center;"><i class="fa fa-lock" aria-hidden="true"></i></label>
        <input type="password" name="AdminPassword" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
      </div>
      <div class="layui-form-item">
        <div class="layui-row">
          <div class="layui-col-xs7">
            <label style="position:absolute; width:38px; height:38px; line-height:38px; text-align:center;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></label>
            <input type="text" name="Captcha" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
          </div>
          <div class="layui-col-xs5">
            <div style="margin-left: 10px;" id="CaptchaImg" onClick="changeCaptcha()"><?=$captcha?></div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <button class="layui-btn layui-btn-fluid"  type="button" onClick="adminLogin()">登 入</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script language="javascript">
function changeCaptcha(){
	var url = '<?=site_url('Home/Captcha')?>';
	$("#CaptchaImg").html('');
　	$("#CaptchaImg").load(url);
}
function adminLogin(){
	var s_AdminUser = $("input[name=AdminUser]").val();
	var s_AdminPassword = $("input[name=AdminPassword]").val();
	var s_Captcha = $("input[name=Captcha]").val();
	var loading = layer.load(0, {shade: false});
	$.post("<?=site_url('Home/login?do=login')?>",{"AdminUser":s_AdminUser,"AdminPassword":s_AdminPassword,"Captcha":s_Captcha},function(data){
    	layer.close(loading);
		if(data.code==200){
			layer.msg("登录成功");
			self.location='<?=site_url('Main/index')?>'; 
		}else{
			if(data.code==501){
				layer.msg("验证码错误");
			}else{
				layer.msg("账号密码错误");
			}
		}
  	},"json");
}
</script>