<?php $this->load->view("Common/Head");?>
<style>
body {background:no-repeat top url(<?=base_url()?>style/images/normal_code.jpg);background-size:100%;}
#myCode{padding:0 30px;box-sizing:border-box;position:absolute;left:50%;top:50%;width:100%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);}
#myCode .qrcodeImg img{width:100%}
#myCode .qrCode{ padding:28px 0 0; text-align:center;border-radius:10px; background:#fff; display:block;height:auto;}
#myCode .refresh{ font-size:13px; color:#666; line-height:49px;}
</style>
<div id="myCode" style="display: block;">
  <div class="qrCode">
    <div class="qrcodeImg"> <span><i class="cover-logo"></i><img src="<?=base_url($qrimg)?>"></span></div>
    <div class="refresh"><p>了解家电污染、关爱家人健康</p></div>
  </div>
</div>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav");?>
<?php $this->load->view("Common/Footer");?>
<?php $MemberID = isset($_SESSION['MemberID'])?$_SESSION['MemberID']:0;?>
<?php $this->load->view("Common/WxShare",array(
'WxShare_img'=>base_url().'style/images/logo.png',
'WxShare_link'=>site_url('?ShareID='.$MemberID),
'WxShare_desc'=>'了解家电二次污染，关注家人工作生活环境的空气问题！',
'WxShare_title'=>'洗哥',
));?>
