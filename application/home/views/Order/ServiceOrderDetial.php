<?php $this->load->view("Common/Head");?>
<style>
body{ background:#f2f2f2; height:96vh;}
.ServiceOrderRow,#Master{ margin:10px; padding:10px 15px; background:#FFFFFF;-moz-box-shadow:2px 1px 8px #333333;-moz-box-shadow:0px 1px 3px #ADADAD; -webkit-box-shadow:0px 1px 3px #ADADAD; box-shadow:0px 1px 3px #ADADAD; font-size:14px;}
.ServiceOrderRow p{ padding:0;}
.ServiceOrderRow .weui-cell{ padding-left:0; padding-right:0;}
.ServiceOrderRow .weui-cell:active{ background:#FFFFFF;}

#question .weui-cell:before{ border-top:none;}
#question p{ font-size:15px; line-height:22px; padding:10px 0;}
#question .weui-cell{ padding-top:0;}
.ServiceOrderRow .weui-cells:after{ border:none;}
.table-rows span:first-child{float:left;}
.table-rows span:nth-child(2){margin-left:76px; display:block;}

#EditBtn{ position:fixed; bottom:60px; padding:10px; display:block; width:100%;box-sizing:border-box;}
#EditBtn a{ background:#4c7bad; font-size:14px;}
</style>
<div style="height:0px; clear:both; overflow:hidden;"></div>
<div class="ServiceOrderRow">
    <div class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__bd">
          <p><?=$data['Sn']?></p>
        </div>
        <div class="weui-cell__ft"><?=lang('order_status_'.$data['Status'])?></div>
    </div>
    <?php if($data['MaterName']!=''):?>
    <p class="table-rows"><span>师傅名称：</span><span><?=$data['MaterName']?></span></p>
    <p class="table-rows"><span>师傅电话：</span><span><?=$data['MasterPhone']?></span></p>
    <?php endif;?>
    <p class="table-rows"><span>服务时间：</span><span><?=$data['BookingTime']?></span></p>
    <?php if($data['OrderAmount']!='0.00'):?>
    <p class="table-rows"><span>服务价格：</span><span>98.00 元</span></p>
    <?php endif;?>
    <div class="clear" style="clear:both; height:10px;"></div>
    <p class="table-rows"><span><strong>服务清单：</strong></span></p>
    <div class="clear" style="clear:both; height:0;"></div>
    <?php foreach($ServiceList as $item):?>
    <p class="table-rows"><span><?=$item['GoodsName']?>：</span><span><?=$item['Price']?> × <?=$item['Num']?></span></p>
    <?php endforeach;?>
    <div class="clear" style="clear:both; height:10px;"></div>
    <p class="table-rows"><span><strong>联系信息：</strong></span></p>
    <div style="clear:both; height:0px;"></div>
    <p class="table-rows"><span>联络人：</span><span><?=$data['Customer']?></span></p>
    <p class="table-rows"><span>联系电话：</span><span><?=$data['Phone']?></span></p>
    <p class="table-rows"><span>服务地址：</span><span><?=$data['Region']?> <?=$data['Address']?></span></p>
    <p class="table-rows"><span>问题描述：</span><span><?=$data['Remark']?></span></p>    
</div>

<?php if($data['Status'] == 3 && $data['commentsCount'] < 1):?>
<div id="EditBtn">
	<div class="weui-flex">
      <div class="weui-flex__item"><a href="javascript:comments();" class="weui-btn weui-btn_primary">点评服务</a></div>
    </div>
</div>
<?php endif;?>
<?php if($data['Status'] == 2):?>
<div id="EditBtn">
	<div class="weui-flex">
      <div class="weui-flex__item"><a href="javascript:pay();" class="weui-btn weui-btn_primary">立即支付</a></div>
    </div>
</div>
<?php endif;?>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Order'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
function comments(){
	window.location.href='<?=site_url("Order/Comments")?>?OrderID=<?=$data['OrderID']?>';
}
</script>
