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
.clear{ clear:both; height:0; overflow:hidden;}
#MasterEditBtn{ position:fixed; bottom:60px; padding:10px; display:block; width:100%;box-sizing:border-box;}
#MasterEditBtn a{ background:#4c7bad; font-size:14px;}
</style>
<div style="height:0px; clear:both; overflow:hidden;"></div>
<div class="ServiceOrderRow">
    <div class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__bd">
          <p><?=$data['Sn']?></p>
        </div>
        <div class="weui-cell__ft" style="color:#FF0000; font-weight:bold;"><?=lang('order_status_'.$data['Status'])?></div>
    </div>
    <?php if($data['MaterName']!=''):?>
    <p class="table-rows"><span>师傅名称：</span><span><?=$data['MaterName']?></span></p>
    <p class="table-rows"><span>师傅电话：</span><span><?=$data['MasterPhone']?></span></p>
    <?php endif;?>
    <p class="table-rows"><span>服务时间：</span><span><?=$data['BookingTime']?></span></p>
    <div id="OrderAmountRows" style="display:none;">
    <p class="table-rows"><span>服务价格：</span><span><font><?=$data['OrderAmount']?></font> 元</span></p>
    </div>
    <div class="clear" style="clear:both; height:10px;"></div>
    <p class="table-rows"><span><strong>服务清单：</strong></span></p>
    <div class="clear" style="clear:both; height:0;"></div>
    <?php foreach($ServiceList as $item):?>
    <p class="table-rows"><span><?=$item['GoodsName']?>：</span><span><?=$item['Price']?> × <?=$item['Num']?></span></p>
    <?php endforeach;?>
    <div class="clear" style="clear:both; height:10px;"></div>
    <p class="table-rows"><span><strong>联系信息：</strong></span></p>
    <div class="clear"></div>
    <p class="table-rows"><span>联络人：</span><span><?=$data['Customer']?></span></p>
    <p class="table-rows"><span>联系电话：</span><span><?=$data['Phone']?></span></p>
    <p class="table-rows"><span>服务地址：</span><span><?=$data['Region']?> <?=$data['Address']?></span></p>
    <p class="table-rows"><span>问题描述：</span><span><?=$data['Remark']?></span></p>
    <div class="clear"></div>
</div>
<?php if($data['Status'] == 1):?>
<div id="MasterEditBtn">
	<div class="weui-flex">
      <div class="weui-flex__item" style="margin-right:5px;"><a href="javascript:beginService();" class="weui-btn weui-btn_primary">开始服务</a></div>
      <div class="weui-flex__item" style="margin-left:5px;"><a href="javascript:cancelOrder();" class="weui-btn weui-btn_primary">取消服务</a></div>
    </div>
</div>
<?php elseif($data['Status'] == 2 || $data['Status'] == 3):?>
<div id="MasterEditBtn">
    <div class="weui-flex">
      <!--<div class="weui-flex__item" style="margin-right:5px;"><a href="javascript:editPrice();" class="weui-btn weui-btn_primary">编辑价格</a></div>-->
      <div class="weui-flex__item" style="margin-left:0px;"><a href="javascript:beginPay();" class="weui-btn weui-btn_primary">开始支付</a></div>
    </div>
</div>
<?php endif;?>
<div style="clear:both; height:80px;"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Order'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
<?php if($data['OrderAmount'] != '0.00'):?>
$("#OrderAmountRows").show();
<?php endif;?>
function beginPay(){
	var Sn = '<?=$data['Sn']?>';
	var OrderAmount = '<?=$data['OrderAmount']?>';
	if(OrderAmount == '0.00'){
		msg('价格不能为零，请输入服务价格');
		return false;
	}
	payment(Sn);
}
function editPrice(){
	var Sn = '<?=$data['Sn']?>';
	$.prompt({
	  text: "",
	  title: "服务价格",
	  onOK: function(OrderAmount) {
			var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
		  	$.post("<?=site_url('Master/editOrderAmount')?>",{Sn:Sn,OrderAmount:OrderAmount},function(data){
				layer.close(loading);
				if(data.code == 200){
					$("#OrderAmountRows").find('font').text(data.OrderAmount);
					msg('操作成功');
				}else{
					msg('操作失败');
				}
			},"json");
	  },
	  onCancel: function() {
		
	  },
	  input: ''
	});
}
function beginService(){
	var Sn = '<?=$data['Sn']?>';
	layer.open({
		content: '确定开始服务？'
		,btn: ['确定', '取消']
		,yes: function(index){
		  	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
		  	$.post("<?=site_url('Master/beginService')?>",{Sn:Sn},function(data){
				layer.close(loading);
				if(data.code == 200){
					msg('操作成功');
					$.post("<?=site_url('Master/Order?do=beginServiceNotice')?>",{Sn:Sn},function(e){
						if(e.code==200){
							window.location.reload();
						}else{
							msg('通知操作失败');
						}
					},"json")
				}else{
					msg('操作失败');
				}
			},"json");
		}
	});
}
function cancelOrder(){
	var Sn = '<?=$data['Sn']?>';
	layer.open({
		content: '确定取消订单？'
		,btn: ['确定', '取消']
		,yes: function(index){
		  	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
			$.post("<?=site_url('Master/cencelOrder')?>",{Sn:Sn},function(data){
				layer.close(loading);
				if(data.code == 200){
					msg('操作成功');
					setTimeout(function(){
						window.location.reload();
					},1000);
				}else{
					msg('操作失败');
				}
			},"json");
		}
	});
}
function payment(Sn){
	var url = site_url('Order/index?do=WechatPay');
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	$.ajax({
		type: "POST",
		url: url,
		dataType: 'json',
		data:{Sn:Sn},
		success: function (data) {
			layer.close(loading);
			if(data.code==500){
				$.toast(data.rows, "cancel");
				return false;
			}
			jsApiCall(
			data.rows.appId,
			data.rows.timeStamp,
			data.rows.nonceStr,
			data.rows.package,
			data.rows.signType,
			data.rows.paySign
			);
			/*欠缺返回值*/
		}
	});
}
function jsApiCall(appId, timeStamp, nonceStr, package, signType, paySign){
	var OrderSn = '<?=$data['Sn']?>';
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',{
             "appId": appId,    //公众号名称，由商户传入
             "timeStamp":timeStamp,    //时间戳，自 1970 年以来的秒数
             "nonceStr": nonceStr, //随机串
             "package": package,
             "signType": signType,    //微信签名方式
             "paySign": paySign //微信签名
        },
		function(res){
			if(res.err_msg == 'get_brand_wcpay_request:cancel'){
				$.toast("交易已取消", "forbidden");
			}else if(res.err_msg == 'get_brand_wcpay_request:ok'){
    			msg('支付成功');
				setTimeout(function(){
					window.location.href = site_url('Master/Order#2');
				},1000);
			}else{
				$.toast("系统交易发生错误", "forbidden");
			}
			return false;
		}
	);
}
function msg(str){
	layer.open({
    	content:str,
		shadeClose:false,
		time:2
    });
}
</script>