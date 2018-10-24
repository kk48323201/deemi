<?php $this->load->view("Common/Head");?>
<style>
.dtext{ color:#b8b8b8; font-size:12px;}
.jiaprice{ color:#ff9933;}
.jianprice{ color:#000000;}
.weui-cell__bd p{ font-size:14px;}
.weui-media-box__hd{ padding-right:10px;}
.weui-cell,.weui-media-box{ padding:10px;}
.pageOpBtn{ display:inline-block; width:50px; height:50px; position:fixed; right:10px; bottom:120px;}
.pageOpBtn a{ display:inline-block; width:100%; color:#FFF; font-size:18px; text-align:center; vertical-align:middle; line-height:50px; background:#000; opacity: 0.5;border-radius:50%; margin-bottom:10px;}
.weui-cell__ft{ margin-right:10px; padding-right:5px;}
.weui-cell__ft:after{content:" ";display:inline-block;height:6px;width:6px;border-width:2px 2px 0 0;border-color:#B8B8B8;border-style:solid;-webkit-transform:matrix(.71,.71,-.71,.71,0,0);transform:matrix(.71,.71,-.71,.71,0,0);position:relative;top:-2px;position:absolute;top:50%;margin-top:-4px;right:10px}
</style>
<div class="weui-cells" style="margin-top:0;" id="ListMain" page="1" rows="20"> 
<!--<a class="weui-cell">
  <div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="http://www.hearti.net/style/images/ico/qianbao_c1.png" width="32"></div>
  <div class="weui-cell__bd" style="padding-right:20px;">
    <p>合和三昧身心灵<br>
      <span class="dtext">04月22日 09:21</span></p>
  </div>
  <div class="weui-cell__ft jiaprice">+75.00</div>
  </a> <a class="weui-cell">
  <div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="http://www.hearti.net/style/images/ico/qianbao_c2.png" width="32"></div>
  <div class="weui-cell__bd" style="padding-right:20px;">
    <p>诺亚洲工作室1<br>
      <span class="dtext">11月07日 01:00</span></p>
  </div>
  <div class="weui-cell__ft jianprice">-1.01</div>
  </a> -->
</div>
<div class="weui-loadmore weui-loadmore_line" id="nomore">
	<span class="weui-loadmore__tips">暂无数据</span>
</div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
