<form  method="post" id="MemberForm" style="width:100vw;">
<input type="hidden" name="MemberID" value="{{MemberID}}" />
<input type="hidden" name="lat" id="input-lat" value="{{lat}}" />
<input type="hidden" name="lng" id="input-lng" value="{{lng}}" />
<input type="hidden" name="RoleID" id="input-RoleID" value="{{RoleID}}" />
<div class="weui-cells weui-cells_form" style="margin-top:0;">
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">上级名称</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="text" value="{{ParentName}}" required="required"  placeholder="">
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">真实名称</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="text" name="RealName" value="{{RealName}}" required="required"  placeholder="">
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd"><label for="RoleName" class="weui-label">角色</label></div>
    <div class="weui-cell__bd">
      <input class="weui-input" id="RoleID"  type="text" value="{{RoleName}}" data-values="{{RoleID}}">
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">地图标记</label>
    </div>
    <div class="weui-cell__bd">
      <textarea class="weui-input" style="height:40px;" id="select_contact" required="required" name="WecharAddress" readonly="readonly" placeholder="">{{WecharAddress}}</textarea>
    </div>
  </div>
</div>
</form>