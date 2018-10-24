<?php $this->load->view("Common/Head",array("pageTitle"=>"申请提现"));?>
<style>
body{ background:#efeef4;}
#MoneyMain{ margin:10px; background:#FFFFFF; padding:20px;border-radius:5px;}
.text{ font-size:13px;}
.input-number{ border:none; font-size:36px; line-height:48px; width:100%; height:48px; text-indent:15px;}
.inputFrm{ border-bottom:1px solid #d6d6d6; padding:5px 10px; position:relative; margin-bottom:3px;}
.inputFrm .fu{ position:absolute; left:0; bottom:3px; font-size:30px;}
.weui-btn{ font-size:15px;}

.weui-label,.weui-cell__bd p{ font-size:15px;}
.weui-cells{ margin-top:0;}
.weui-cells:after{ border-bottom:0;}
.weui-select,.weui-input{ border:1px solid #d9d9d9;border-radius:5px; padding:5px 10px; font-size:13px; color:#848484; height:20px; line-height:20px; width:80%;}
#BankAccountForm .weui-label{ width:85px;}
.layui-m-layerbtn span:nth-child(2){ background:#1aad19; color:#FFFFFF;border-radius:0;}
#MyBalance,#ServiceFee{ font-weight:bold;}
</style>
<div id="MoneyMain">
	<p class="text">零钱总额 <span id="MyBalance">0.00</span> 元<!--，本次手续费 <span id="ServiceFee">0.00</span> 元--></p>
    <div class="inputFrm">
    	<input type="number" class="input-number" name="Amount" id="Amount" maxlength="6" />
        <span class="fu">¥</span>
    </div>
    <!--<p class="text" style="padding-top:15px; color:#828282;">手续费( <strong>1%</strong> )，每笔最低 <strong>1</strong> 元</p>-->
    <div style="padding-top:20px;"><a href="javascript:submitDepositForm();" class="weui-btn weui-btn_primary" style="background:#4c7bad;">立即提现</a></div>
    <div class="weui-flex" style="padding-top:8px;">
      <div class="weui-flex__item" style="padding-right:4px;"><a href="javascript:allDeposit();" class="weui-btn weui-btn_default">全部提取</a></div>
      <div class="weui-flex__item" style="padding:0 4px;"><a href="<?=site_url('Member/Purse?do=PurseList')?>" class="weui-btn weui-btn_default">财务记录</a></div>
      <div class="weui-flex__item" style="padding-left:4px;"><a href="<?=site_url('Member/Purse?do=DrawnList')?>" class="weui-btn weui-btn_default">申请记录</a></div>
    </div>
    <ol style="padding:10px 15px; font-size:13px; line-height:26px;">
        <li>最低提现额度为 50 元</li>
        <li>提现流程，每周二，四会统一进行处理</li>
        <!--<li>付款到账实效为1-3日，最快次日到账</li>-->
    </ol>
</div>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
getPurseInfo();
function getPurseInfo(){
	$.get(site_url('Member/index?do=getPurseInfo'),function(data){
		$("#MyBalance").text(fmoney(data.totalAmount));
	},'json');
}
function allDeposit(){
	$("input[name='Amount']").val($("#MyBalance").text());
	getServiceFee();
}	
</script>