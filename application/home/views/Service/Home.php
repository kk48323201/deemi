<?php $this->load->view("Common/Head");$data=tag_getPage($PageID);?>
<style>
article img{ max-width:100%; width:100%;}
.weui-article{ padding:0;}
.onceBuyBtn{ position:fixed; bottom:53px;border-radius:0; width:100%; font-size:16px; background:#1560ab;}
</style>
<article class="weui-article"><?=$data['Content']?></article>
<a href="tel:0756-8639288" class="weui-btn weui-btn_primary onceBuyBtn">电话下单</a>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>