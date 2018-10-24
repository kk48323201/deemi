<?php $this->load->view("Common/Head");?>
<style>
body{ background:#f2f2f2; height:100vh;}
.ServiceOrderRow{ margin:10px; padding:10px 15px; background:#FFFFFF;-moz-box-shadow:2px 1px 8px #333333;-moz-box-shadow:0px 1px 3px #ADADAD; -webkit-box-shadow:0px 1px 3px #ADADAD; box-shadow:0px 1px 3px #ADADAD; font-size:14px;}
.ServiceOrderRow p{ padding:0;}
.ServiceOrderRow .weui-cell{ padding-left:0; padding-right:0;}
.ServiceOrderRow .weui-cell:active{ background:#FFFFFF;}

#member-order-nav{background:#FFF;border-bottom:1px solid #c4c4c4; overflow:hidden;-webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.3); width:100%;-webkit-box-shadow:0 .03px .03px 0 rgba(0,0,0,.2);box-shadow:0 .03px .03px 0 rgba(0,0,0,.2); position:fixed; top:0; z-index:99;}
#member-order-nav a{ color:#5d5d5d; float:left; line-height:32px; text-decoration:none;font-size:14px; border-bottom:2px solid #FFFFFF; display:inline-block; width:20%; text-align:center;}
#member-order-nav a.cur{ color:#4c7bad; border-bottom:2px solid #4c7bad;}
.layui-m-layerbtn span[yes]{ color:#4c7bad;}

</style>
<div id="member-order-nav"> <a href="#0">全部</a> <a href="#1">待接单</a> <a href="#2">进行中</a><a href="#3">待支付</a><a href="#4">已完成</a></div>
<div style="height:37px; clear:both;"></div>
<div id="MainContainer" rows="10" page="1" Status="0"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Order'));?>
<?php $this->load->view("Common/Footer");?>
<script type="text/template" id="ServiceOrderRowHtml">
<div class="ServiceOrderRow" onClick="jump('{{OrderUrl}}')">
    <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd">
          <p>{{Sn}}</p>
        </div>
        <div class="weui-cell__ft">{{StatusText}}</div>
    </div>
    <p>服务地址：{{Region}} {{Address}}</p>
    <p>服务时间：{{BookingTime}}</p>
    <p>服务价格：{{OrderAmount}}</p>
</div>
</script>
<script language="javascript">
var get = GetRequest();
var s = typeof(get['s']) == 'undefined'?0:parseInt(get['s']);
$(document).ready(function(){
	if(window.location.hash!=''){
		x = window.location.hash.replace('#','');
		changeTab(x);
	}else{
		changeTab(0);
	}
	$("#member-order-nav a").click(function(){
		var hash = $(this).attr('href');
		x = hash.replace('#','');
		changeTab(x);
	});
	var AjaxLoading = true;
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var total = parseInt($("#MainContainer").attr('total'));
		var page = parseInt($("#MainContainer").attr('page'));
		var rows = parseInt($("#MainContainer").attr('rows'));
		var maxpage = total < 1?1:Math.ceil(total/rows)*1;
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			if(AjaxLoading == true){
				x = $("#MainContainer").attr('Status');
				getListData(page,x);
			}
		}
	});
});
function changeTab(x){
	$("#member-order-nav a").removeClass("cur");
	$("#member-order-nav a:eq("+x+")").addClass("cur");
	$("#MainContainer").attr('Status',x);
	/*$("#OrderListDataMain").html('');
	var Status = x;
	$("#OrderListDataMain").attr("page","1");
	LoadListData(Status,1);*/
	getListData(1,x);
}
function getListData(inipage,x){
	var get = GetRequest();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var url = "<?=site_url('Member/Order?do=getData')?>";
	var rows = $("#MainContainer").attr("rows");
	var postData = {'page':inipage,'rows':rows,'Status':x};
	if(inipage == 1){
		$("#MainContainer").html('');
	}
	AjaxLoading = false;
	$("#MainContainer").attr("page",parseInt(inipage)+1);
	$.post(url,postData,function(data){
    	layer.close(loading);
		$.each(data.rows, function(idx, obj) {
			var StatusText = '';
			if(obj.Status == 0){
				StatusText = '待接单';
			}else if(obj.Status == 1){
				StatusText = '待服务';
			}else if(obj.Status == 2){
				StatusText = '待付款';
			}else if(obj.Status == 3){
				StatusText = '已完成';
			}
			var OrderAmount = '现场定价';
			if(obj.OrderAmount != 0.00){
				OrderAmount = obj.OrderAmount + ' 元';
			}
			var html = document.getElementById('ServiceOrderRowHtml').innerHTML;
			var OrderUrl = site_url('Order/ServiceOrderDetial/'+obj.Sn);
			html = html.replace('{{Sn}}',obj.Sn)
					   .replace('{{StatusText}}',StatusText)
					   .replace('{{Region}}',obj.Region)
					   .replace('{{OrderUrl}}',OrderUrl)
					   .replace('{{Address}}',obj.Address)
					   .replace('{{OrderAmount}}',OrderAmount)
					   .replace('{{BookingTime}}',obj.BookingTime);
			$("#MainContainer").append(html);
		});
		$("#MainContainer").attr("total",parseInt(data.total));
		if(rows*inipage >= parseInt(data.total) || parseInt(data.total) < 1){
			$(".weui-loadmore").hide();
			AjaxLoading = false;
		}else{
			AjaxLoading = true;
		}
		$("img.lazy").lazyload();
    },"json");
}
</script>
