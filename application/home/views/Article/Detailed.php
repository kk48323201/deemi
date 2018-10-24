<?php $this->load->view("Common/Head");?>
<style>
section img{ max-width:100%;}
.weui-article h1{margin-top:0; font-size:18px; line-height:26px; margin-bottom:3px;}
#goodsFooter{ position:fixed; width:100%; bottom:0; background:#f9f9f9;border-top: 1px solid #ccc;-webkit-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); z-index:10;}
#goodsFooter .weui-btn{border-radius:0; font-size:14px; line-height:50px;}
#goodsFooter .weui-btn:after{border-radius:0;}
#goodsFooter .s1{ float:left; width:50%; display:inline-block; font-size:12px; text-align:center; padding-top:6px; text-decoration:none;}
#goodsFooter .s1 img{ height:22px;}
#goodsFooter .s1 span{ display:block; text-align:center; color:#828282;}
ul{ margin-left:30px;}
.weui-footer__text{ margin-bottom:60px;}
</style>
<div style="min-height:75vh;">
<article class="weui-article" style="margin-top:0;">
   <h1><?=$data['Title']?></h1>
   <section>
   <?php if($data["VideoLink"]!=""):?>
   <iframe style="width:100vw;height:55vw;" src='<?=$data["VideoLink"]?>' frameborder=0 'allowfullscreen'></iframe>
   <?php endif;?>
   <?=html_entity_decode($data['Content'])?>
   </section>
</article>
</div>
<div class="weui-flex" id="goodsFooter">
  <div class="weui-flex__item" style="flex:3;"><a href="tel:<?=$data['Tel']?>" id="BuyButton" class="weui-btn weui-btn_primary" style="text-decoration:none; color:#FFFFFF;">电话咨询</a></div>
</div>
<?php $this->load->view("Common/Footer");?>