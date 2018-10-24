<?php $this->load->view("Common/Head");?>
<style>
.weui-media-box{ padding:10px;}
.weui-media-box_appmsg .weui-media-box__hd{ width:80px; height:50px;}
.weui-panel{ margin-top:0;}
a.weui-media-box{ text-decoration:none;}
</style>
<div class="weui-panel weui-panel_access" style="min-height:85vh;">
  <div class="weui-panel__bd">
    <?php foreach($data as $item):?>
    <a href="<?=site_url('Article/Detail/'.$item['ArticleID'])?>" class="weui-media-box weui-media-box_appmsg">
    <div class="weui-media-box__hd"> <img class="weui-media-box__thumb" src="<?=base_url().$item['BigThumb']?>" alt=""> </div>
    <div class="weui-media-box__bd">
      <h4 class="weui-media-box__title"><?=$item['Title']?></h4>
      <p class="weui-media-box__desc"><?=$item['Description']?></p>
    </div>
    </a>
    <?php endforeach;?>
  </div>
</div>
<?php $this->load->view("Common/Footer");?>
