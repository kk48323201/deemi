<form  method="post" id="AddressForm" style="width:100vw;">
<input type="hidden" name="AddressID" value="{{AddressID}}" />
<input type="hidden" name="lat" id="input-lat" value="{{lat}}" />
<input type="hidden" name="lng" id="input-lng" value="{{lng}}" />
<div class="weui-cells weui-cells_form" style="margin-top:0;">
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">客户名称</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="text" name="Customer" value="{{Customer}}" required="required"  placeholder="请输入联系姓名">
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">联系电话</label>
    </div>
    <div class="weui-cell__bd">
      <input class="weui-input" type="number" name="Phone" value="{{Phone}}" pattern="[0-9]*" required="required" placeholder="请输入手机号码">
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd">
      <label class="weui-label">所在区域</label>
    </div>
    <div class="weui-cell__bd">
      <textarea class="weui-input" style="height:40px;" id="select_contact" required="required" name="WecharAddress" readonly="readonly" placeholder="所在区域">{{WecharAddress}}</textarea>
    </div>
  </div>
  <div class="weui-cell">
    <div class="weui-cell__hd" style="margin-top:-30px;">
      <label class="weui-label">详细地址</label>
    </div>
    <div class="weui-cell__bd">
      <textarea class="weui-input" style="height:60px;" required="required" name="ZdyAddress" placeholder="请输入门牌号（至少5个字）">{{ZdyAddress}}</textarea>
    </div>
  </div>
  <div class="weui-cell" id="SpecialAddress">
    <div class="weui-cell__hd">
      <label class="weui-label">优惠地址</label>
    </div>
    <div class="weui-cell__bd">
      <label style="display:block;"><input type="checkbox" name="TypeID" value="1" style="vertical-align:middle;" /><span style="font-size:12px;"> (设定后无法更改)</span></label>
    </div>
  </div>
</div>
</form>