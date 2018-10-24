<?php $this->load->view("Common/Head");?>
<style>#AddressForm .weui-cell{ padding:8px 15px;}
.layui-m-layerbtn span:nth-child(2){background:#1560ab;}
#map {display: none; width: 100%;height: 100%;position: absolute;top: 0;z-index: 999;}
.weui-loadmore_line{ border:none;}
#AddAddressBtn{border-top:1px solid #d8d8d8; position:fixed; bottom:0;display:block; padding:2vw 3vw; width:94vw; background:#FFFFFF;}
html{ height:100vh;}
.IsDiscounts{position:absolute; right:10px; padding:0 10px; border:#FF0000 1px solid; color:#FF0000; top:18px;border-radius:3px; font-size:12px; line-height:22px; height:22px; display:none;}
.Show{ display:inline-block;}
.BtnHide{ display:none;}
#SpecialAddress{ display:none;}
</style>
<?php $this->load->view("Member/AddressMain");?>
<?php $this->load->view("Common/Footer");?>
<script id="AddAddressFormHtml" type="text/template">
<?php $this->load->view("Member/AddressForm");?>
</script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script language="javascript">
var MerchantAddressCount = 0;
var DcAddress = 0;
function setAddress(e){
	var AddressID = e.attr('AddressID');
	if(window.top!=window.self){
		window.parent.setAddress(AddressID);
	}
}
ListData();
function ListData(){
	var loading = layer.open({type: 2});
	$.ajax({
	   type: "GET",
	   url: "<?=site_url('Member/Address?do=ListData')?>",
	   data: {'page':1,'rows':20},
	   dataType: "json",
	   error: function (request) {
		  
	   },
	   success: function (data) {
		   $("#list-address").html('');
		   if(data.rows.length > 0){
		   	 	$(".empty-address").hide();
				for(i=0;i<data.rows.length;i++){
			   		html = $("#ListDataTemplate").html();
					if(data.rows[i].IsDefault==1){data.rows[i].IsDefault='<i class="setDef"></i>';}
					else{data.rows[i].IsDefault='';}
					var IsShow = parseInt(data.rows[i].TypeID) == 1?'Show':'';
					var BtnHide = parseInt(data.rows[i].TypeID) == 1?'BtnHide':'';
					if(parseInt(data.rows[i].TypeID) == 1){
						MerchantAddressCount = MerchantAddressCount + 1;	
					}
					if(parseInt(data.DcAddress) == 1){
						DcAddress = parseInt(data.DcAddress);
					}
					html = html.replace('{{Customer}}',data.rows[i].Customer)
						   .replace('{{Phone}}',data.rows[i].Phone)
						   .replace('{{Address}}',data.rows[i].Address)
						   .replace('{{Show}}',IsShow)
						   .replace('{{BtnHide}}',BtnHide)
						   .replace('{{WecharAddress}}',data.rows[i].WecharAddress)
						   .replace(/{{AddressID}}/g,data.rows[i].AddressID)
						   .replace('{{IsDefault}}',data.rows[i].IsDefault)
						   .replace(/{{ZdyAddress}}/g,data.rows[i].ZdyAddress);
			   		$("#list-address").append(html);
			     }
		   }else{
		   		$(".empty-address").show();
		   }
		   layer.close(loading);
	   }
   });
}
function AddAddress(){
	html = document.getElementById('AddAddressFormHtml').innerHTML;
	html = html.replace('{{Customer}}','')
			.replace('{{Phone}}','')
			.replace('{{ZdyAddress}}','')
			.replace('{{WecharAddress}}','')
			.replace('{{AddressID}}','0');
	layer.open({
    	type: 1,
		title: false,
		style:'position:absolute;top:0;left:0;width:100vw;',
		anim: 'scale',
		btn: ['保存', '关闭'],
		content:html,
		success: function(elem){
			$('#select_contact').click(function(){
				$(this).trigger('blur')
				$('#map').show()
			});
			if(MerchantAddressCount < 1 && DcAddress == 1){
				$("#SpecialAddress").css("display","flex");
			}
			window.addEventListener('message', function(event) {
			  // 接收位置信息，用户选择确认位置点后选点组件会触发该事件，回传用户的位置信息
			  var loc = event.data;
			  if (loc && loc.module == 'locationPicker') {//防止其他应用也会向该页面post信息，需判断module是否为'locationPicker'
				  $('#map').hide();
				  if(loc.poiname == '我的位置'){
					  loc.poiname = '';
				  }
				  console.log(loc);
				  $('#select_contact').val(loc.poiaddress+loc.poiname);
				 // $('#input-lng').val(loc.latlng.lng);
				  $('#input-lng').val(loc.latlng.lng);
				  $('#input-lat').val(loc.latlng.lat);
			
			  }
			}, false);
		},
		yes:function(index){
		  Save();
		  return false;
		}    
    });
}
function EditAddress(AddressID){
	var loadIndex = layer.open({type: 2});
	$.get("<?=site_url('Member/Address?do=getAddress')?>",{AddressID:AddressID},function(obj){
    	html = document.getElementById('AddAddressFormHtml').innerHTML;
		html = html.replace('{{Customer}}',obj.rows.Customer)
			.replace('{{Phone}}',obj.rows.Phone)
		   .replace('{{Address}}',obj.rows.Address)
		   .replace('{{WecharAddress}}',obj.rows.WecharAddress)
		   .replace('{{AddressID}}',obj.rows.AddressID)
		   .replace('{{AddressID}}',obj.rows.AddressID)
		   .replace('{{AddressID}}',obj.rows.AddressID)
		   .replace('{{lng}}',obj.rows.lng)
		   .replace('{{lat}}',obj.rows.lat)
		   .replace('{{IsDefault}}',obj.rows.IsDefault)
		   .replace(/{{ZdyAddress}}/g,obj.rows.ZdyAddress);
		layer.open({
			type: 1,
			title: false,
			style:'position:absolute;top:0;left:0;width:100vw;',
			anim: 'scale',
			btn: ['保存', '关闭'],
			content:html,
			success: function(elem){
				layer.close(loadIndex);				
			},
			yes:function(index){
			  Save();
			  return false;
			}    
		});
  	},"json");
}
function delAddress(AddressID){
	var loading = layer.open({type: 2});
	$.get("<?=site_url('Member/Address?do=delAddress')?>",{AddressID:AddressID},function(obj){
		layer.close(loading);
		ListData();
		msg('删除成功');
	});
}
function SetAddress(AddressID){
	var loading = layer.open({type: 2});
	$.get("<?=site_url('Member/Address?do=setAddress')?>",{AddressID:AddressID},function(obj){
		layer.close(loading);
		ListData();
	});
}
function Save(){
	var phone = $("input[name='Phone']").val();
	if($("input[name='Customer']").val()==''){
		msg('请输入收货人姓名');return false;
	}
	if(phone==''){
		msg('请输入手机号码');return false;
	}
	if(!isPoneAvailable(phone)){
		msg('手机号码格式错误');return false;
	}
	if($("input[name='Region']").val()==''){
		msg('请输入所在区域');return false;
	}
	if($("textarea[name='Address']").val()==''){
		msg('请输入详细地址');return false;
	}
	layer.open({type: 2});
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "<?=site_url('Member/Address?do=Save')?>" ,
		data: $('#AddressForm').serialize(),
		success: function (result) {
			layer.closeAll();
			if (result.code == 200) {
				ListData();
				msg("已保存");
			};
		},
		error : function() {
			msg("<?=lang('C_NETWORK_ERROR')?>");
		}
	});
}
function msg(str){
	layer.open({
    	content:str,
		time:2
    });
}
</script>