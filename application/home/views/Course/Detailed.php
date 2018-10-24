<?php $this->load->view("Common/Head");?>
<style>
.weui-article h1{margin-top:0; font-size:18px; line-height:26px; margin-bottom:3px;}
.weui-article .d{ height:26px; font-size:12px; margin:0;color:#999999;}
#goodsFooter{ position:fixed; width:100%; bottom:0; background:#f9f9f9;border-top: 1px solid #ccc;-webkit-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); z-index:10;}
#goodsFooter .weui-btn{border-radius:0; font-size:14px; line-height:50px;}
#goodsFooter .weui-btn:after{border-radius:0;}
#goodsFooter .s1{ float:left; width:50%; display:inline-block; font-size:12px; text-align:center; padding-top:6px; text-decoration:none;}
#goodsFooter .s1 img{ height:22px;}
#goodsFooter .s1 span{ display:block; text-align:center; color:#828282;}
.weui-footer{ height:150px;}
</style>
<?php if($data['BigThumb']!=''):?>
<img src="<?=base_url($data['BigThumb'])?>" style="width:100%;" />
<?php endif;?>
<div class="weui-article" style="padding:10px;">
<h1><?=$data['CourseName']?></h1>
<p class="d"><span class="pull-left">发布日期：<?=date("Y-m-d",strtotime($data['CreateTime']))?></span><span class="pull-right">粤音琴行</span></p>
<section>
  <table class="table table-condensed table-striped" style="margin-bottom:5px; font-size:14px;">
    <tbody>
      <tr>
        <th align="center">体验时长：</th>
        <td><?=$data['ExperienceTime']?> 分钟</td>
      </tr>
      <tr>
        <th align="center">现场福利：</th>
        <td><?=$data['Welfare']?></td>
      </tr>
      <tr>
        <th align="center">适用门店：</th>
        <td><?=$data['Shop']?></td>
      </tr>
      <?php if($data['Tips']!=''):?>
      <tr>
        <th width="90" align="center">温馨提示：</th>
        <td><?=$data['Tips']?></td>
      </tr>
      <?php endif;?>
    </tbody>
  </table>
  <div class="content"><?=$data['Content']?></div>
</section>
</div>
<div class="weui-flex" id="goodsFooter">
  <div class="weui-flex__item">
            <a class="s1" href="<?=base_url()?>"><img src="<?=base_url()?>style/images/goods_s1.png"><span>返回</span></a>
            <a class="s1" href="tel:<?=$data['Tel']?>"><img src="<?=base_url()?>style/images/goods_s2.png"><span>电话</span></a>
        </div>
  <div class="weui-flex__item" style="flex:3;"><a href="<?=site_url('Course/Order/'.$data['CourseID'])?>" id="BuyButton" class="weui-btn weui-btn_primary" style="text-decoration:none; color:#FFFFFF;">立即报名( <?=$data['Price']?>元 )</a></div>
</div>
<?php $this->load->view("Common/Footer");?>
<?php $this->load->view("Common/WxShare",array(
'WxShare_img'=>base_url('style/images/logo.jpg'),
'WxShare_link'=>site_url('Course/Detailed/'.$data['CourseID']),
'WxShare_desc'=>$data['Description'],
'WxShare_title'=>$data['CourseName'],
));?>
