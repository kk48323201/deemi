<?php $this->load->view("Common/Head",array("pageTitle"=>"申请记录"));?>
<style>
.dtext{ color:#b8b8b8; font-size:12px;}
.jiaprice{ color:#ff9933;}
.jianprice{ color:#000000;}
.weui-cell__bd p{ font-size:14px;}
.weui-media-box__hd{ padding-right:10px;}
.weui-cell,.weui-media-box{ padding:10px;}
.pageOpBtn{ display:inline-block; width:50px; height:50px; position:fixed; right:10px; bottom:120px;}
.pageOpBtn a{ display:inline-block; width:100%; color:#FFF; font-size:18px; text-align:center; vertical-align:middle; line-height:50px; background:#000; opacity: 0.5;border-radius:50%; margin-bottom:10px;}
.weui-cell__ft{ margin-right:10px; padding-right:5px;}
.weui-cell__ft:after{content:" ";display:inline-block;height:6px;width:6px;border-width:2px 2px 0 0;border-color:#B8B8B8;border-style:solid;-webkit-transform:matrix(.71,.71,-.71,.71,0,0);transform:matrix(.71,.71,-.71,.71,0,0);position:relative;top:-2px;position:absolute;top:50%;margin-top:-4px;right:10px}
#nomore{ display:none;}
</style>
<div class="weui-cells" style="margin-top:0;" id="MainContainer" rows="10" page="1"></div>
<div class="weui-loadmore" id="loadmore">
	<i class="weui-loading"></i>
	<span class="weui-loadmore__tips">正在加载</span>
</div>
<div class="weui-loadmore weui-loadmore_line" id="nomore">
	<span class="weui-loadmore__tips">暂无数据</span>
</div>
<div class="zclear50"></div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Member'));?>
<?php $this->load->view("Common/Footer");?>
<script id="RecordHtml" type="text/template">
<a class="weui-cell">
  <div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="<?=base_url()?>/style/images/ico/cash.png" width="32"></div>
  <div class="weui-cell__bd" style="padding-right:20px;">
    <p>申请提现<span style="color:#FF0000">{{StatusText}}</span><br>
      <span class="dtext">{{CreateTime}}</span></p>
  </div>
  <div class="weui-cell__ft jianprice">{{Amount}}</div>
  </a>
</script>
<script language="javascript">
var AjaxLoading = true;
$(document).ready(function(){
	getListData(1);
	$(window).scroll(function(){
		var srollPos = $(window).scrollTop();
		browserTotalHeight = parseFloat($(window).height()) + parseFloat(srollPos);
		var total = parseInt($("#MainContainer").attr('total'));
		var page = parseInt($("#MainContainer").attr('page'));
		var rows = parseInt($("#MainContainer").attr('rows'));
		var maxpage = total < 1?1:Math.ceil(total/rows)*1;
		if(($(document).height()-100) <= browserTotalHeight && page<=maxpage){
			if(AjaxLoading == true){
				getListData(page);
			}
		}
	});
});
function getListData(inipage){
	var get = GetRequest();
	var loading = layer.open({type: 2,shade:'background-color: rgba(0,0,0,.2)'});
	var url = "<?=site_url('Member/index')?>";
	var rows = $("#MainContainer").attr("rows");
	var postData = {'do':'getDrawnList','page':inipage,'rows':rows};
	AjaxLoading = false;
	$("#MainContainer").attr("page",parseInt(inipage)+1);
	$.get(url,postData,function(data){
    	layer.close(loading);
		$.each(data.rows, function(idx, obj) {
			var html = document.getElementById('RecordHtml').innerHTML;
			var StatusText = '<span>(待处理)</span>';
			if(obj.Status>0){
				StatusText = '<span style="color:#00008B">(已处理)</span>';
			}
			html = html.replace('{{Amount}}',obj.Amount)
    			       .replace('{{CreateTime}}',obj.CreateTime)
					   .replace('{{StatusText}}',StatusText);
			$("#MainContainer").append(html);
		});
		$("#MainContainer").attr("total",parseInt(data.total));
		if(rows*inipage >= parseInt(data.total) || parseInt(data.total) < 1){
			$("#loadmore").hide();
			if(data.total<1){
				$("#nomore").show();
			}
			AjaxLoading = false;
		}else{
			AjaxLoading = true;
		}
    },"json");
}
</script>