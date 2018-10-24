<?php $this->load->view("Common/Head");?>
<style>
.mine {background: url(<?=base_url()?>style/images/bg_mine.png) no-repeat top center;background-size: 100%;padding-top:56px; min-height:500px;}
.mine .mine_center {position: absolute;top: 20px; width: 100%;padding: 20px 0;}
.mine .mine_center a {display: block; padding:0 15px;}
.mine .mine_center .mine_avatar {width: 80px;height: 80px;border-radius: 50%; display: inline-block;vertical-align: top;margin-right: 15px;position: relative;overflow: hidden;background: #f2f2f2;margin-left: 15px;box-shadow: 0px 0px 15px -1px #1d9ff9;}
.mine .mine_center .mine_avatar img {
  width: 100%;  position: absolute;  left: 0;  right: 0;  top: 0;  bottom: 0;  margin: auto;}
.mine .mine_center .mine_info {display: inline-block;vertical-align: top;margin-top:46px;}
.mine .mine_center .mine_info h2 {font-size: 15px; color:#333333; font-weight:normal; line-height:18px;}
.mine .mine_center .mine_info p {font-size:14px;color: #666;}
.mine .order_center {  width: 98vw;  height: 200px;  margin: 0 auto;  background: url(<?=base_url()?>style/images/bg_my.png) no-repeat center;
  background-size: 100%;}
.mine .order_center .order_sort ul {  font-size: 0; overflow: hidden; width: 100%; padding-top: 82px;}
.mine .order_center .order_sort ul li { width: 25%; text-align: center; float: left; position: relative;}
.mine .order_center .order_sort ul li a {display: block; padding: 5px 0;}
.mine .order_center .order_sort ul li a img {width: 30px;}
.mine .order_center .order_sort ul li a p {font-size: 13px;color: #333;margin-top: 3px;}
.weui-cells{ font-size:14px; margin-top:0;}.weui-cell{ padding:13px 15px;}
.MemberRowsNav img{width:20px;margin-right:10px;display:block;}
.layui-m-layerbtn span[yes]{ background:#4988c8; color:#FFFFFF;border-radius:0;}
</style>
<div class="mine">
  <div class="mine_center"> <a href="#" class="wrap">
    <div class="mine_avatar"> <img src="<?=$_SESSION['WechatHeadimgurl']?>"> </div>
    <div class="mine_info">
      <h2><?=$_SESSION['WechatNickname']?></h2>
      <p><?php if($_SESSION['Mobile']==''):?><font onClick="showPhoneTask()">立即绑定手机</font><?php else:?><?=$_SESSION['Mobile']?><?php endif;?></p>
    </div>
    </a> </div>
  <div class="order_center">
    <div class="order_sort">
      <ul>
        <li> <a href="<?=site_url('Member/Order#1')?>"> <img src="<?=base_url()?>style/images/ico/01.png">
          <p>待接单</p>
          </a> </li>
        <li> <a href="<?=site_url('Member/Order#2')?>"> <img src="<?=base_url()?>style/images/ico/03.png">
          <p>进行中</p>
          </a> </li>
        <li> <a href="<?=site_url('Member/Order#3')?>"> <img src="<?=base_url()?>style/images/ico/04.png">
          <p>待支付</p>
          </a> </li>
        <li> <a href="<?=site_url('Member/Order#4')?>"> <img src="<?=base_url()?>style/images/ico/05.png">
          <p>已完成</p>
          </a> </li>
      </ul>
    </div>
  </div>
  <div class="weui-cells"> 
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Master/Order')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/weixiu.png" ></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>维修任务</p>
    </div>
    <span class="weui-cell__ft"><span class="weui-badge"><?=$data['TaskCount']?></span></span> </a>
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Member/Earnings')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/shouyi.png" ></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>累计收益</p>
    </div>
    <span class="weui-cell__ft"><?=$data['Earnings']==''?'0.00':$data['Earnings']?> 元</span> </a>
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Member/Qrcode')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/ewm.png" ></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>我的二维码</p>
    </div>
    <span class="weui-cell__ft"></span> </a> <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Member/Address')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/dz.png" ></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>我的地址</p>
    </div>
    <span class="weui-cell__ft"></span> </a> 
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Member/Purse')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/qb.png" ></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>钱包</p>
    </div>
    <span class="weui-cell__ft" style="font-size:13px;" id="PurseTotalAmount"><font><?=$data['Cash']==''?'0.00':$data['Cash']?></font> 元</span> </a>
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Member/Contact')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/lx.png"></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>联系我们</p>
    </div>
    <span class="weui-cell__ft"></span> </a>
    <?php if($data['Manage'] == 1):?>
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Manage/Member')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/vip.png"></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>会员管理</p>
    </div>
    <span class="weui-cell__ft"></span> </a>
    <a class="weui-cell weui-cell_access MemberRowsNav" href="<?=site_url('Shoukuan/')?>">
    <div class="weui-cell__hd"><img src="<?=base_url()?>style/images/ico/shoukuan.png"></div>
    <div class="weui-cell__bd weui-cell_primary">
      <p>面对面支付</p>
    </div>
    <span class="weui-cell__ft"></span> </a>
    <?php endif;?> 
    </div>
</div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script id="PhoneTaskFormHtml" type="text/template">
<?php $this->load->view("Member/PhoneTaskForm");?>
</script>
<script language="javascript">
function showPhoneTask(){
	html = document.getElementById('PhoneTaskFormHtml').innerHTML;
	html = html.replace('{{MemberID}}','<?=$_SESSION['MemberID']?>');
	layer.open({
    	type: 1,
		title: false,
		style:'position:absolute;top:0;left:0;width:100vw;',
		anim: 'scale',
		btn: ['保存', '关闭'],
		content:html,
		success: function(elem){},
		yes:function(index){
		  savePhoneTask();
		  return false;
		}    
    });
}
function savePhoneTask(){
	var Mobile = $("#PhoneTaskForm").find("input[name='Mobile']").val();
	var Code = $("#PhoneTaskForm").find("input[name='Code']").val();
	if(Mobile == ''){
		msg('请输入验证码');
		return false;
	}
	if(Code==''){
		msg('请输入验证码');return false;
	}
	$.post("<?=site_url('Member/index?do=savePhoneTask')?>",$("#PhoneTaskForm").serialize(),function(data){
		if(data.code == 200){
			layer.closeAll();
			msg(data.info);
			setTimeout(function(){
				window.location.reload();
			},1500);
			
		}else{
			msg(data.info);
		}
		
	},"json");
}
function sendPhoneTaskCode(){
	var Mobile = $("#PhoneTaskForm").find("input[name='Mobile']").val();
	if(Mobile == ''){
		msg('请输入手机号码');
		return false;
	}
	$.post("<?=site_url('Member/sendCode')?>",{Mobile:Mobile},function(data){
		msg(data.info);
	},"json");
}
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}
getPurseInfo();
function getPurseInfo(){
	$.get(site_url('Member/index?do=getPurseInfo'),function(data){
		$("#PurseTotalAmount").find('span').text(fmoney(data.totalAmount));
	},'json');
}
</script>
