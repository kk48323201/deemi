<?php $this->load->view("Common/Head");?>
<style>
body{ background:#f2f2f2;}
#serviceOrder{ min-height:300px; background:url(<?=base_url()?>style/images/bg_mine.png) top no-repeat; background-size:100% auto; padding-top:30px;}
#serviceOrder form{ width:96vw; margin:0 auto;}
#serviceOrder #question .weui-cell:before{ border-top:none;}
#serviceOrder #question p{ font-size:15px; line-height:22px; padding:10px 15px;}
#serviceOrder .weui-cells{ font-size:15px;}
#serviceOrder #question .weui-cell{ padding-top:0;}
#serviceOrder .warm_tip{ font-size:15px; background:#FFFFFF; padding:10px 15px; height:auto;}
#serviceOrder .warm_tip h1{ font-size:16px;}
#serviceOrder .warm_tip p{ font-size:14px; line-height:26px;}
#serviceOrder .submitBtn{ position:fixed; bottom:0; width:100%; left:0; background:#FFFFFF;}
#serviceOrder .submitBtn a{border-radius:0; margin:10px; font-size:15px;}
#serviceOrder .weui-cells{ margin-top:0;}
#serviceOrder .weui-cell__ft{ color:#333333; font-size:14px;}
#AddressMain{display: none; width: 100%;height: 100%;position: absolute;top: 0;z-index: 999; background:#FFFFFF;}
</style>
<div id="serviceOrder">
	<form id="serviceOrderForm" method="post">
    	<input type="hidden" name="AddressID" id="form-AddressID" value="" />
        <input type="hidden" name="BookingTime" value="" />
    	<div class="weui-cells">
          <a class="weui-cell weui-cell_access" href="javascript:;" id="SelServiceAddress">
            <div class="weui-cell__bd">
              <p style="width:75px;">地址信息</p>
            </div>
            <div class="weui-cell__ft">
            	<p id="OrderCustomer">选择服务地址</p>
            	<p id="OrderAddress"></p>
            </div>
          </a>
          <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
              <p>上门时间</p>
            </div>
            <div class="weui-cell__ft" id="input-BookingTime">选择时间</div>
          </a>
          <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
              <p>订单费用</p>
            </div>
            <div class="weui-cell__ft"><?=sprintf("%.2f",$total)?> 元</div>
          </a>
        </div> 
        <div style="height:8px; clear:both;"></div>
        <div class="weui-cells weui-cells_form" id="question">
          <p>问题描述：</p>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" id="textarea" placeholder="请描述需要服务的具体内容。" rows="3" name="Remark"></textarea>
              <div class="weui-textarea-counter"><span id="count">0</span>/50</div>
            </div>
          </div>
        </div>
        <div style="height:8px; clear:both;"></div>
        <div class="warm_tip">
         <div class="wrap">
           <h1 class="font4">温馨提示</h1>
           <p>1、标注价格（除面议外）均为建议小哥人工费用，不包含材料配件费，配件可自备，也可由服务小哥代为购买；</p>
           <p>2、如有高空作业或疑难问题，需加收人工费时，最终报价由您和小哥双方协商确定。</p>
         </div>
       </div>
       <div style="height:90px; clear:both;"></div>
         <div class="submitBtn">
         	<a class="weui-btn weui-btn_primary" style="background:#1560ab;" href="javascript:submitServiceForm();" id="showTooltips">确定</a>
         </div>
    </form>
</div>
<div id="AddressMain">
  <iframe id="Addressframe" src="<?=site_url('Member/Address')?>" frameborder="0" width="100%" height="100%"></iframe>
</div>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
$(function(){
	$("#SelServiceAddress").click(function(){
		$("#AddressMain").show();
	});
	$("#input-BookingTime").datetimePicker({
        min: "<?=date('Y-m-d')?>",
		yearSplit: '-',
        monthSplit: '-',
        dateSplit: '',
		times: function () {
          return [
            {
              values: ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00']
            }
          ];
        },
        value: '<?=date("Y-m-d")?> 09:00',
        onChange: function (picker, values, displayValues) {
          str = values.toString();
		  serviceTime = str.replace(',','-');
		  serviceTime = serviceTime.replace(',','-');
		  serviceTime = serviceTime.replace(',',' ');
		  $("#input-BookingTime").text(serviceTime);
		  $("#serviceOrderForm").find("input[name='BookingTime']").val(serviceTime);
		  console.log(values);
        }
      });
	  var max = 50;
	  $('#textarea').on('input', function(){
		 var text = $(this).val();
		 var len = text.length;
		 $('#count').text(len);
		 if(len > max){
		   $("#textarea").val(text.substring(0,50));
		 }
	  });
});
function setAddress(AddressID){
	$("#AddressMain").hide();
	$.get("<?=site_url('Member/Address?do=getAddress')?>",{AddressID:AddressID},function(data){
		if(data.code == 200){
			$("#serviceOrderForm").find("input[name='AddressID']").val(AddressID);
			$("#serviceOrderForm").find("#OrderCustomer").text(data.rows.Customer+' '+data.rows.Phone);
			$("#serviceOrderForm").find("#OrderAddress").text(data.rows.WecharAddress+' '+data.rows.ZdyAddress);
		}
	},'json');
}
function submitServiceForm(){
	var serviceTime = $("#serviceOrderForm").find("input[name='BookingTime']").val();
	var AddressID = $("#serviceOrderForm").find("input[name='AddressID']").val();
	var GoodsID = $("#serviceOrderForm").find("input[name='GoodsID']").val();
	if(AddressID==''){
		msg('请输入地址');return false;
	}
	if(serviceTime==''){
		msg('请输入预约时间');return false;
	}
	
	if(GoodsID=''){
		msg('商品编号参数');return false;
	}
	$.post("<?=site_url('Cart/index?do=SaveOrderData')?>",$("#serviceOrderForm").serialize(),function(data){
    	if(data.code == 200){
			msg("您的服务已提交");
			jump("<?=site_url('Member/Order')?>")
		}else{
			msg("操作失败");
		}
    },'json');
}
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}
</script>