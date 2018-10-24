<?php $this->load->view("Common/Head");?>
<style>
body{ background:#f2f2f2; height:96vh;}
#MasterInfo,.ServiceOrderRow,.ContentRow{ margin:10px; padding:10px 15px; background:#FFFFFF;-moz-box-shadow:2px 1px 8px #333333;-moz-box-shadow:0px 1px 3px #ADADAD; -webkit-box-shadow:0px 1px 3px #ADADAD; box-shadow:0px 1px 3px #ADADAD; font-size:14px;}
#MasterInfo .Avatar{ width:44px;height:44px; float:left; padding-right:10px;}
#MasterInfo .Avatar img{ width:100%; height:100%;border-radius:50%;}
.ping{ display:inline-block; width:100px;border-radius:15px; border:#999999 1px solid; text-align:center; color:#999999; margin:0 auto; line-height:26px;}
#question:before,#question:after{ border:none;}
#question{ border:1px solid #999999;border-radius:3px; margin-top:0;}
#question textarea{ font-size:14px; color:#333333;}
#EditBtn{ position:fixed; bottom:60px; padding:10px; display:block; width:100%;box-sizing:border-box;}
#EditBtn a{ background:#4c7bad; font-size:14px;}
#simpleBtn .cur{background:#4c7bad; color:#FFFFFF;border:#4c7bad 1px solid;}
</style>
<input type="hidden" id="Simple" value="1" />
<input type="hidden" id="OrderID" value="<?=$data['OrderID']?>" />
<div style="height:0px; clear:both; overflow:hidden;"></div>
<div id="MasterInfo">
	<div class="Avatar"><img src="<?=base_url()?>style/images/avatar/3.jpg" /></div>
    <p>师傅称呼：<?=$data['MaterName']?></p>
    <p>服务时间：<?=date("H:i",strtotime($data['ServiceTime']))?> ~ <?=date("H:i",strtotime($data['PaymentTime']))?></p>
</div>
<div class="ServiceOrderRow">
	<p style="text-align:center; line-height:32px; margin-bottom:10px;">您的评价，是我们进步的动力</p>
    <div class="weui-flex" id="simpleBtn">
      <div class="weui-flex__item" style="text-align:center;"><a href="javascript:simple(1)" class="ping cur">满意</a></div>	
      <div class="weui-flex__item" style="text-align:center;"><a href="javascript:simple(2);" class="ping">不满意</a></div>
    </div>
    
</div>
<div class="ContentRow">
	<div class="weui-cells weui-cells_form" id="question">
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <textarea class="weui-textarea" id="Remark" placeholder="有更多点评，请输入在此" rows="3" name="Remark"></textarea>
          <div class="weui-textarea-counter" style="font-size:14px;"><span id="count">0</span>/100</div>
        </div>
      </div>
    </div>
</div>
<div id="EditBtn">
	<div class="weui-flex">
      <div class="weui-flex__item"><a href="javascript:submitOrder();" class="weui-btn weui-btn_primary">提交点评</a></div>
    </div>
</div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Order'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
$(function(){
	  var max = 100;
	  $('#textarea').on('input', function(){
		 var text = $(this).val();
		 var len = text.length;
		 $('#count').text(len);
		 if(len > max){
		   $("#textarea").val(text.substring(0,50));
		 }
	  });
});
function simple(v){
	$("#simpleBtn").find('a').removeClass('cur');
	if(v==1){
		$("#simpleBtn").find('a:eq(0)').addClass('cur');
	}else{
		$("#simpleBtn").find('a:eq(1)').addClass('cur');
	}
	$("#Simple").val(v);
}
function submitOrder(){
	var OrderID = $("#OrderID").val();
	var Simple = $("#Simple").val();
	var Remark = $("#Remark").val();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	$.post("<?=site_url('Order/index?do=SaveComments')?>",{OrderID:OrderID,Simple:Simple,Remark:Remark},function(data){
		layer.close(loading);
		if(data.code == 200){
			$("#EditBtn").hide();
			msg('感谢您的评论');
			setTimeout(function(){
				window.location.href = site_url('Member');
			},1700);
		}else{
			msg('操作失败');
		}
	},'json');
}
function msg(str){
	layer.open({
    	content:str,
		shadeClose:false,
		time:2
    });
}
</script>
