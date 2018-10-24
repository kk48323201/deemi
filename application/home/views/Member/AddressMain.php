<link rel="stylesheet" href="<?=base_url()?>style/css/MemberAddress.css">
<ul id="list-address">
</ul>
<div class="empty-address" style="display:none;">
  <div class="weui-loadmore weui-loadmore_line"> <span class="weui-loadmore__tips">暂无数据</span> </div>
</div>
<div id="ListDataTemplate" style="display:none" currentpage='1' total='0'>
  <li class="active">
    <div class="address-item" AddressID="{{AddressID}}" onclick="setAddress($(this))">
      <p><span class="mr20">{{Customer}}</span> {{Phone}}</p>
      <p class="address">{{WecharAddress}} {{ZdyAddress}}</p>
      <div class="IsDiscounts {{Show}}"><span>优惠</span></div>
    </div>
    <div class="set-address {{BtnHide}}">
      <div class="set-default"> <span class="radio" onclick="SetAddress({{AddressID}})"></span> {{IsDefault}} <span class="gray84">设为默认地址</span> </div>
      <div class="checkbox"> <a href="javascript:EditAddress({{AddressID}});" class="edit">编辑</a> <a href="javascript:delAddress({{AddressID}});" class="delete">删除</a> </div>
    </div>
  </li>
</div>
<div id="AddAddressBtn"> <a href="javascript:AddAddress();" class="weui-btn weui-btn_primary" style="font-size:15px;background:#1560ab;">+新增服务地址</a> </div>
<div id="map">
  <iframe id="myframe" src="https://apis.map.qq.com/tools/locpicker?policy=1&total=10&search=1&type=1&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp" frameborder="0" width="100%" height="100%"></iframe>
</div>
