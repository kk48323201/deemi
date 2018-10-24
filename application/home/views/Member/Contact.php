<?php $this->load->view("Common/Head");$data=tag_getPage(2);?>
<article class="weui-article"><?=$data['Content']?></article>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>