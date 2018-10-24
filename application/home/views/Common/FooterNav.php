<style>
#bagel-footer .weui-tabbar__icon{ height:25px; width:25px;}
#bagel-footer .weui-tabbar__label{ font-size:13px; color:#666666;}
#bagel-footer .cur .weui-tabbar__label{ color:#4c7bad;}
</style>
<div class="zclear50"></div>
<div id="bagel-footer" class="weui-tabbar"> 
  <?php if(isset($CurNav)&&$CurNav=='Home'):?>
  <a href="<?=site_url('Home/index')?>" class="weui-tabbar__item cur">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-home01.png"> </div>
  <p class="weui-tabbar__label">首页</p>
  </a> 
  <?php else:?>
  <a href="<?=site_url('Home/index')?>" class="weui-tabbar__item">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-home02.png"> </div>
  <p class="weui-tabbar__label">首页</p>
  </a>
  <?php endif;?>
  <?php if(isset($CurNav)&&$CurNav=='Order'):?>
  <a href="<?=site_url('Member/Order')?>" class="weui-tabbar__item cur">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-order01.png"> </div>
  <p class="weui-tabbar__label">订单</p>
  </a> 
  <?php else:?>
  <a href="<?=site_url('Member/Order')?>" class="weui-tabbar__item">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-order02.png"> </div>
  <p class="weui-tabbar__label">订单</p>
  </a> 
  <?php endif;?>
  <?php if(isset($CurNav)&&$CurNav=='Member'):?>
  <a href="<?=site_url('Member')?>" class="weui-tabbar__item cur">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-member01.png"> </div>
  <p class="weui-tabbar__label">我的</p>
  </a> 
  <?php else:?>
  <a href="<?=site_url('Member')?>" class="weui-tabbar__item">
  <div class="weui-tabbar__icon"> <img src="<?=base_url()?>style/images/ico/nav-member02.png"> </div>
  <p class="weui-tabbar__label">我的</p>
  </a> 
  <?php endif;?>
</div>
