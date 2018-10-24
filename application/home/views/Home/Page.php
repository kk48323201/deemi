<?php $this->load->view("Common/Head");?>
<style>
section img{ max-width:100%; width:100%;}
ul{ margin-left:30px;}
</style>
<div style="min-height:85vh;">
<?php if($data['PageID'] == 2):?>
<img src="<?=base_url()?>/upload/article/20180802/ac677008010b94031e6cbca5a4948347.jpg" style="width:100%;" />
<?php else:?>
<img src="<?=base_url()?>style/images/banner001.jpg" style="width:100%;" />
<?php endif;?>
<article class="weui-article" style="margin-top:0;">
   <section>
   <?=$data['Content']?>
   </section>
</article>
</div>
<?php $this->load->view("Common/Footer");?>