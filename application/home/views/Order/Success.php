<?php $this->load->view("Common/Head");?>
<link rel="stylesheet" href="<?=base_url()?>style/css/buttons.css">
<style>
.Main{ background:url(<?=base_url()?>style/images/background.png) top no-repeat; background-size:100%; border-bottom:1px solid #e3e3e3; padding-bottom:30px; margin-bottom:20px;}
.small-unit{padding: 3px 5vw;}
.label{position: absolute;display: inline-block;width:70px;height:30px;text-align: justify;overflow: hidden; color:#4d4c4d;}
.label:after{display: inline-block;content: '';width:70px;height:30px;text-align: justify;overflow: hidden;}

.msg{display: inline-block;margin-left:90px;position: relative;color:#878787;}
.msg:before{ content: '：';position: absolute;left:-18px;}
#OrderAmount:before{}
</style>
<div class="Main">
<div style="text-align:center; padding:30px; padding-bottom:10px;"><img src="<?=base_url()?>style/images/ico/order-success.png" width="120" /></div>
<p style="text-align:center; font-size:20px; color:#000000;">下单成功</p>
<p style="text-align:center; font-size:16px; color:#a7a7a7;">生活愉快</p>
</div>
<div class="small-unit">
    <label class="label">收货人</label>
    <div class="msg"><span id="Customer"><?=$OrderInfo['Customer']?></span></div>
</div>
<div class="small-unit">
    <label class="label">手机号</label>
    <div class="msg"><span id="Phone"><?=$OrderInfo['Phone']?></span></div>
</div>
<div class="small-unit">
    <label class="label">收货地址</label>
    <div class="msg"><span id="Address"><?=$OrderInfo['Region']?> <?=$OrderInfo['Address']?></span></div>
</div>
<div class="small-unit">
    <label class="label">支付金额</label>
    <div class="msg"><span id="OrderAmount"><?=$OrderInfo['OrderAmount']?></span></div>
</div>

<div align="center" style="padding-top:20px;">
<a href="<?=site_url('Member/Order')?>" class="button button-border button-rounded button-highlight" style="width:160px; font-size:14px;padding:0 20px;color:#ff7e05;border:#ff7e05 1px solid;">前往订单列表</a>
</div>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav");?>
<?php $this->load->view("Common/Footer");?>