<form  method="post" id="PhoneTaskForm" style="width:100vw;">
<input type="hidden" name="MemberID" value="{{MemberID}}" />
<div class="weui-cells weui-cells_form" style="margin-top:0;">
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">手机号码</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="text" name="Mobile" value=""   placeholder="请输入手机号码">
    </div>
  </div>
  <div class="weui-cell weui-cell_vcode">
    <div class="weui-cell__hd">
      <label class="weui-label">验证码</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="tel" name="Code" placeholder="请输入验证码"  >
    </div>
    <div class="weui-cell__ft">
      <a class="weui-vcode-btn" style="font-size:14px; color:#4988c8;" href="javascript:sendPhoneTaskCode();">获取验证码</a>
    </div>
  </div>
</div>
</form>