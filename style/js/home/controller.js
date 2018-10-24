angular.module('app').controller('serviceManager',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp','loactionCity','loading',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp,loactionCity,loading){	
	//加载状态
	loading.open();
	//服务列表
	requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/category').then(function(result){
		$scope.categoryData = result.data;
		console.log($scope.categoryData);
	}).then(function(){
		loading.close();
	});
	//获取定位
	$scope.location = {};
	$scope.location.city = "定位中...";
	loactionCity.getData(mapKey).then(function(result){
		$scope.location.city = result.city;
	});	
	//选择城市
	$scope.changeCity = function(){
		$state.go('app.city');
	}
	//图片切换
    var mySwiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationElement: 'div',
        autoplay: 4000,
    });	
}]);
angular.module('app').controller('city',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp','loactionCity','loading',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp,loactionCity,loading){	
	//加载状态
	loading.open();
	//请求城市列表
	loactionCity.getData(mapKey).then(function(result){
		$scope.location = result;
	}).then(function(){
		requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/city',{ProvincialID:$scope.location.provincialID}).then(function(result){
			$scope.cityData = result.data;
		});
	}).then(function(){
		loading.close();
	});
	//点击城市，设置新的城市并返回首页
	$scope.city = function($index){		
		if(angular.isUndefined($scope.cityData[$index])){			
			$state.go("app");
			return false;
		}
		if(angular.isUndefined($scope.cityData[$index].CityName)){			
			$state.go("app");
			return false;
		}
		if(angular.isUndefined($scope.cityData[$index].CityID)){
			$state.go("app");
			return false;
		}		
		$scope.location.city = $scope.cityData[$index].CityName;
		$scope.location.cityID = $scope.cityData[$index].CityID;
		$window.localStorage.setItem('userLocation',angular.toJson($scope.location));
		$state.go('app');
		return true;
	}	

}]);
angular.module('app').controller('serviceChange',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp','loactionCity','loading',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp,loactionCity,loading){	
	//加载状态
	loading.open();
	//获取参数
	$scope.search = {};
	$scope.search.cid = $stateParams.cid || 0;
	//获取服务分类
	requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/category').then(function(result){
		$scope.categoryData = result.data;
		$scope.getServiceList($scope.search.cid);
	});
	
	$scope.getServiceList = function(cid){
		requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/service',{CategoryID:cid}).then(function(result){
			$scope.serviceData = result.data;
			$scope.search.cid = cid;
			loading.close();	
		})
	}
	
}]);
angular.module('app').controller('serviceDetail',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','$interval','requestHttp','loactionCity','loading',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,$interval,requestHttp,loactionCity,loading){	
	//加载状态
	loading.open();
	//获取参数
	$scope.param = {};
	$scope.param.cid = $stateParams.cid || 0;
	$scope.param.sid = $stateParams.sid || 0;
	$scope.param.tid = $stateParams.tid || 0;
	//拉取服务详情
	requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/service_detail',{ServiceID:$scope.param.sid}).then(function(result){
		$scope.serviceDetail = result.data;					
		console.log(result);
	}).then(function(){
		loading.close();
	});
	//点击跳转购买服务
	$scope.serviceOrder = function(){
		$state.go("^.order" , $scope.param);
	}
}]);
angular.module('app').controller('serviceOrder',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','$interval','requestHttp','loactionCity','loading',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,$interval,requestHttp,loactionCity,loading){
	//加载状态
	loading.open();
	//获取参数
	$scope.param = {};
	$scope.param.cid = $stateParams.cid || 0;
	$scope.param.sid = $stateParams.sid || 0;
	$scope.param.tid = $stateParams.tid || 0;
	//数据
	$scope.info = {};	
	$scope.info.Meta = {};
	$scope.info.Meta.Square = 0;
	$scope.info.Meta.Month = 0;
	//月份数量
	$scope.monthData = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36];
	//优惠券选择
	$scope.CouponData = [];
	$scope.CouponData.push({"id":"1","name":"不使用优惠券"});
	$scope.CouponData.push({"id":"2","name":"9.8优惠券"});
	$scope.CouponData.push({"id":"3","name":"9.9优惠券"});

	//拉取会员信息
	requestHttp.get('http://dingdong.zh3721.com/index.php/api/member/base').then(function(result){
		if(result.data.code == "200"){
			$scope.member = result.data.rows;
			$scope.info.Mobile = $scope.member.Mobile;
			$scope.info.Customer = $scope.member.RealName || "";
			console.log($scope.member);
		}else{
			console.log('登录失效');
		}				
	}).then(function(){//重新定位城市	
		loactionCity.getData(mapKey).then(function(result){
			$scope.location = result;
		}).then(function(){//定位城市下的区域			
			requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/area',{CityID:$scope.location.cityID}).then(function(result){
				$scope.areaData = result.data;
			}).then(function(){//拉取服务详情
				requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/service_detail',{ServiceID:$scope.param.sid}).then(function(result){
					$scope.serviceDetail = result.data;
					$scope.totalPrice = 0;
					$scope.$watch("info.Meta.Square",function(){						
						var Square = Number($scope.info.Meta.Square);
						var Month = Number($scope.info.Meta.Month);
						if(!isNaN(Square) && angular.isNumber(Square) && !isNaN(Month) && angular.isNumber(Month) && !angular.isUndefined($scope.serviceDetail.ServicePrice)){
							$scope.totalPrice = (Square * $scope.serviceDetail.ServicePrice) * Month;
						}
					},true);
					$scope.$watch("info.Meta.Month",function(){						
						var Square = Number($scope.info.Meta.Square);
						var Month = Number($scope.info.Meta.Month);
						if(!isNaN(Square) && angular.isNumber(Square) && !isNaN(Month) && angular.isNumber(Month) && !angular.isUndefined($scope.serviceDetail.ServicePrice)){
							$scope.totalPrice = (Square * $scope.serviceDetail.ServicePrice) * Month;
						}
					},true);
				}).then(function(){	
					//选择月份
					$scope.monthIndex = 0;
					$("#MonthList").mobiscroll().treelist({  
						theme: "android-ics",  
						lang: "zh",
						display: 'bottom',
						cancelText: null,
						inputClass: 'form-control placeholder',
						placeholder : "<      请选择",
						defaultValue:[$scope.monthIndex],
						headerText:function(valueText){
							return "选择购买数量";
						},
						formatResult:function(index){//返回值
							$scope.monthIndex = index;							
							return $scope.monthData[index]+"个月";
						},
						onSelect:function(valueText, inst){
							$scope.info.Meta.Month = $scope.monthData[inst.values[0]] || 0;
						}
					});		
					//优惠券
					$scope.couponIndex = 0;
					$("#CouponList").mobiscroll().treelist({  
						theme: "android-ics",  
						lang: "zh",
						display: 'bottom',
						cancelText: null,
						inputClass: 'form-control placeholder',
						placeholder : "<      请选择",
						defaultValue:[$scope.couponIndex],
						headerText:function(valueText){
							return "选择优惠券";
						},
						formatResult:function(index){							
							$scope.couponIndex = index;
							return $scope.CouponData[index].name;										
						},
						onSelect:function(valueText, inst){
							$scope.info.Coupon = $scope.CouponData[inst.values[0]].id;
						}
					});
					//所在地区
					$scope.AreaIndex = 0;
					$("#AreaList").mobiscroll().treelist({  
						theme: "android-ics",  
						lang: "zh",
						display: 'bottom',
						cancelText: null,
						inputClass: 'form-control placeholder',
						placeholder : "<      请选择",
						defaultValue:[$scope.AreaIndex],
						headerText:function(valueText){
							return "选择优惠券";
						},
						formatResult:function(index){
							$scope.AreaIndex = index;
							return $scope.areaData[index].AreaName;										
						},
						onSelect:function(valueText, inst){
							$scope.info.AreaID = $scope.areaData[inst.values[0]].AreaID;
						}
					});
					loading.close();
				});
			});
		});
	});

	
	//地图搜索
	$scope.height = window.screen.height+"px";
	$scope.mapState = false
	$scope.mapPlace = {};
	$scope.closeMap = function(){
		$scope.mapState = false;
		$("#search-input").val("");
	}
	$scope.selectPlace = function(id){
		$scope.info.Address = $scope.mapPlace[id].name;
		$scope.mapState = false;
		$("#search-input").val("");
	}		
	$("#search-input").bind("input propertychange", function () {
		var val = $(this).val();
		if (val != null && val.length > 0) {
			$scope.searchPlace(val);
		}
		return 0;
	});	
	$scope.searchPlace = function(val){
		$scope.mapState = true;
		$scope.mapPlace 			= {};		
		$scope.mapPlace.key 		= mapKey;
		$scope.mapPlace.city 		= $scope.location.city;
		$scope.mapPlace.keywords 	= val;		
		$scope.mapPlace.extensions 	= "all";
		requestHttp.get('http://restapi.amap.com/v3/place/text',$scope.mapPlace).then(function(result){
			$scope.mapPlace = result.data.pois;
		});
	}
	
	//预约时间
	$(document).on("touchstart","input#BookingTime",function(){	
		var curr 	= new Date(new Date().getTime());
		var year 	= curr.getFullYear();
		var month 	= curr.getMonth();
		var date 	= curr.getDate();
		$("#BookingTime").mobiscroll().datetime({
			theme: "android-ics",
			lang: "zh",
			display: 'bottom',
			dateFormat: 'yyyy-mm-dd',
			minDate: new Date(year, month, (date+1),8,0),
			maxDate: new Date(year, month, (date+7),20,0),
			stepMinute: 30,
			invalid:[
				{ start: '00:00', end: '07:30' },
				{ start: '20:30', end: '23:59' },
			],
			headerText:function(text){			
				var array = text.split(' ');
				var date = array[0].split('-');
				var time = array[1].split(':');			
				return date[0] + "年" + date[1] + "月" + date[2] + "日 " + time[0] + "时" + time[1] + "分";			
			}  
		})
	});

	//上传图片
	$scope.info.Images = [];
	$scope.thumb = function(base64){
		$scope.info.Images.push(base64);
	}

	
	$scope.codeTime = {};
	$scope.codeTime.text 	= "获取验证码";
	$scope.codeTime.state	= false;
	$scope.codeTime.second 	= $window.localStorage.getItem('serviceOrderTime') || 0;
	$scope.codeTime.promise = undefined;
	$scope.codeTime.open	= false;
	$scope.code = function(){
		if($scope.codeTime.state){
			return false;
		}
		$scope.codeTime.state = true;
		requestHttp.post('http://dingdong.zh3721.com/index.php/api/other/sendsms',{Mobile:$scope.info.Mobile,Openid:$scope.member.WechatOpenid}).then(function(result){
			if(result.data.code == 200){
				$scope.codeTime.open	= true;
				$scope.codeTime.second 	= 60;
			}else{
				$scope.codeTime.state = false;
				layer.msg('手机号码错误,无法接收短信验证码');
			}
		}).then(function(){
			if($scope.codeTime.open == true){
				$scope.startTime();
			}
		});
	}	
	$scope.startTime = function(){
		$scope.codeTime.promise = undefined;
		$scope.codeTime.promise = $interval(function(){
			if($scope.codeTime.second <= 0){  
				$interval.cancel($scope.codeTime.promise);
				$scope.codeTime.promise	= undefined;				
				$scope.codeTime.text	= "重发验证码";
				$scope.codeTime.state	= false;
			}else{					
				$scope.codeTime.text = $scope.codeTime.second + "秒后可重发";  
				$scope.codeTime.second--;	
				$window.localStorage.setItem('serviceOrderTime',$scope.codeTime.second);			
			}  
		},1000,60);
	}	
	if(parseInt($scope.codeTime.second)){
		$scope.codeTime.state = true;
		$scope.startTime();
	}

	//提交订单
	$scope.postOrder = function(){
		$scope.postButtom = true;
		$scope.info.ProvincialID = $scope.location.provincialID;
		$scope.info.CityID = $scope.location.cityID;
		$scope.info.ServiceID = $scope.param.sid;
		console.log($scope.info);
//		if($scope.param.tid == 1 && $scope.info.Images.length <= 0){
//			layer.msg('请上传图片');
//			layer.open({content: '请上传图片',skin: 'msg',time:2});
//			return false;
//		}
		if($scope.param.tid == 1 && (angular.isUndefined($scope.info.Remark) || $scope.info.Remark == "")){			
			loading.msg("请输入您的维护需求");
			return $scope.postButtom = false;
		}	
		if($scope.param.tid == 1 && (angular.isUndefined($scope.info.BookingTime) || $scope.info.BookingTime == "")){
			loading.msg('请选择预约时间');
			return $scope.postButtom = false;
		}
		var regSquare = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
		if($scope.param.tid == 2 && (!regSquare.test($scope.info.Meta.Square) )){
			loading.msg('请输入房屋平方');
			return $scope.postButtom = false;
		}
		if($scope.param.tid == 2 && (angular.isUndefined($scope.info.Meta.Month) || $scope.info.Meta.Month <= 0 || !Number($scope.info.Meta.Month))){
			loading.msg('请输入购买数量');
			return $scope.postButtom = false;
		}		
		var regName= /^[\u4E00-\u9FA5A-Za-z]{2,20}$/;
		if(!regName.test($scope.info.Customer) || angular.isUndefined($scope.info.Customer) || $scope.info.Customer == ""){
			loading.msg('请输入姓名');
			return $scope.postButtom = false;
		}
		var regTel= /^1(3|4|5|7|8)\d{9}$/;
		if(!regTel.test($scope.info.Mobile)  || angular.isUndefined($scope.info.Mobile) || $scope.info.Mobile == ""){
			loading.msg('请输入手机号码');
			return $scope.postButtom = false;
		}
		var regCode= /^[0-9]{4,4}$/;
		if((!regCode.test($scope.info.Code) || angular.isUndefined($scope.info.Code)) && ($scope.member.Mobile == ""  || angular.isUndefined($scope.member.Mobile))){
			loading.msg('请输入验证码');
			return $scope.postButtom = false;
		}		
		if(angular.isUndefined($scope.info.AreaID) || ($scope.info.AreaID) <= 0){
			loading.msg('请选择所在地区');
			return $scope.postButtom = false;
		}		
		var regAddress= /[^\x00-\xff]|[A-Za-z0-9_]/ig;
		if(!regAddress.test($scope.info.Address) || angular.isUndefined($scope.info.Address) || $scope.info.Address == ""){
			loading.msg('请输入详细地址');
			return $scope.postButtom = false;
		}
		if(!angular.isUndefined($scope.info.BookingTime) && $scope.info.BookingTime != ""){
			$scope.info.BookingTime = $scope.info.BookingTime + ":00"; 
		}
		//console.log($scope.info);
		requestHttp.post('http://dingdong.zh3721.com/index.php/api/order/create',$scope.info).then(function(result){
			console.log(result);			
			if(result.data.code == 200){
				$scope.postButtom = false;
			}else{
				loading.msg('订单创建失败');
				$scope.postButtom = false;
			}
		}).then(function(){
			$scope.postButtom = false;
		});
//		$scope.play = {};
//		$scope.play.store_id = "10164";
//		$scope.play.orderid = "MMP";
//		$scope.play.price = "0.01";
//		$scope.play.return_url = $window.location.href;

//		document.write("<form action=\"http://m.91dale.com/Home/Pay/pay_third.html\" method=\"post\" name=\"play\" style=\"display:none\">");  
//		document.write("<input type=\"hidden\" name=\"store_id\" value=\""+$scope.play.store_id+"\"/>");
//		document.write("<input type=\"hidden\" name=\"orderid\" value=\""+$scope.play.orderid+"\"/>");
//		document.write("<input type=\"hidden\" name=\"price\" value=\""+$scope.play.price+"\"/>");
//		document.write("<input type=\"hidden\" name=\"return_url\" value=\""+$scope.play.return_url+"\"/>");
//		document.write("</form>");  
//		document.play.submit();
	}

}]);



angular.module('app').controller('orders',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//获取参数
	$scope.param = {};
	$scope.param.type = $stateParams.type || 0;

	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入订单列表');
		$scope.list = {};
		$scope.list[0] = 1;
		$scope.list[1] = 2;
		$scope.list[2] = 3;
		$scope.list[3] = 4;
		$scope.list[4] = 5;
		$scope.list[5] = 6;
		$scope.list[6] = 7;
		$scope.list[7] = 8;
		$scope.list[8] = 9;
		$scope.list[9] = 0;
	});

	//点击不同的订单列表
	$scope.panelOrders = function(id){
		$scope.param.type = id;
		return false;
	}
	
	//点击返回首页
	$scope.backHome = function(){
		$state.go('app');
	}
	
	//会员中心
	$scope.user = function(){
		$state.go('app.user');
	}
	
	//点击查订单详情
	$scope.ordersShow = function(id){
		$scope.param.id = id;
		$state.go('.detail',$scope.param);
	}
	
	//点击查订单详情
	$scope.cancelButtom = false;
	$scope.cancel = function($event,id){
		$scope.cancelButtom = !$scope.cancelButtom;	
		$event.stopPropagation();
	}

	//点击支付
	$scope.palyButtom = false;
	$scope.paly = function($event,id){
		$scope.palyButtom = !$scope.palyButtom;
		$event.stopPropagation();
	}

	//去评价
	$scope.commentButtom = false;
	$scope.comment = function($event,id){
		$scope.commentButtom = !$scope.commentButtom;
		$event.stopPropagation();
	}

	//删除订单
	$scope.deleteButtom = false;
	$scope.delete = function($event,id){
		$scope.deleteButtom = !$scope.deleteButtom;
		$event.stopPropagation();
	}
}]);

angular.module('app').controller('ordersDetail',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//获取参数
	$scope.param = {};
	$scope.param.type = $stateParams.type || 0;
	$scope.param.id = $stateParams.id || 0;
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入订单详情');
	});
	console.log($scope.param);
}]);


angular.module('app').controller('package',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入套餐服务列表');
	});	
	//跳转到套餐服务详情
	$scope.goPackageDetail = function(id){
		$scope.package = {};
		$scope.package.id = id;
		$state.go('.detail',$scope.package);
	}
		
}]);

angular.module('app').controller('packageDetail',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//获取参数
	$scope.param = {};
	$scope.param.id = $stateParams.id || 0;
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入套餐详情页面');
	});	
	//购物套餐
	$scope.packageOrder = function(){
		console.log('点击购买');
		$state.go('.order',$scope.param);
	}

}]);

angular.module('app').controller('packageOrder',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//获取参数
	$scope.param = {};
	$scope.param.id = $stateParams.id || 0;
	
	$scope.info = {};
	$scope.info.number = "";
	$scope.info.name = "";
	$scope.info.tel = "";
	$scope.info.address = "";
	$scope.info.location = "";
	
	//layer.open({type: 2, shadeClose: false});
	//layer.closeAll();

	//地图搜索
	$scope.height = window.screen.height+"px";
	$scope.mapState = false
	$scope.mapPlace = {};
	$scope.closeMap = function(){
		$scope.mapState = false;
		$("#search-input").val("");
	}
	$scope.selectPlace = function(id){
		$scope.info.location = $scope.mapPlace[id].name;
		$scope.mapState = false;
		$("#search-input").val("");
	}	
	$scope.searchPlace = function(val){
		$scope.mapState = true;
		if(angular.isUndefined(localStorage.city)){
			$scope.mapCity = {};
			$scope.mapCity.key = mapKey;
			requestHttp.get('http://restapi.amap.com/v3/ip',$scope.mapCity).then(function(result){
				localStorage.city = result.data.city;
				$scope.getMapPlace();
			});
		}else{
			$scope.mapPlace 			= {};		
			$scope.mapPlace.key 		= mapKey;
			$scope.mapPlace.city 		= localStorage.city;
			$scope.mapPlace.keywords 	= val;		
			$scope.mapPlace.extensions 	= "all";
			requestHttp.get('http://restapi.amap.com/v3/place/text',$scope.mapPlace).then(function(result){
				$scope.mapPlace = result.data.pois;
			});
		}
	}
	$("#search-input").bind("input propertychange", function () {
		var val = $(this).val();
		if (val != null && val.length > 2) {
			$scope.searchPlace(val);
		}
		return 0;
	});
	
	
	
	
	
	
	
	
	$scope.number = function(eve){
		console.log(eve);
		eve.placeholder='请输入';
	}
	
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入套餐购买页面');
	});	
	$scope.goPackagePlay = function(){
//		var regNumber = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
//		if(!regNumber.test($scope.info.number)){
//			console.log($scope.info);
//			layer.open({content: "请输入正确的购买数量.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regName= /^[\u4E00-\u9FA5A-Za-z0-9]{2,20}$/;
//		if(!regName.test($scope.info.name)){
//			layer.open({content: "请输入姓名.", skin: 'msg', time: 2});
//			return false;
//		}		
//		var regTel= /^1(3|4|5|7|8)\d{9}$/;
//		if(!regTel.test($scope.info.tel)){
//			layer.open({content: "请输入手机号码.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regLocation= /[^\x00-\xff]|[A-Za-z0-9_]/ig;
//		if(!regLocation.test($scope.info.location)){
//			layer.open({content: "请选择所在地区.", skin: 'msg', time: 2});
//			return false;
//		}	
//		var regAddress= /[^\x00-\xff]|[A-Za-z0-9_]/ig;
//		if(!regAddress.test($scope.info.address)){
//			layer.open({content: "请输入详细地址.", skin: 'msg', time: 2});
//			return false;
//		}
		//提交表单
		requestHttp.get('').then(function(result){
			console.log("点击了购买按钮");
			$state.go('app.package.list');
		});
	}	
	
}]);


angular.module('app').controller('packageList',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入已购买的套餐列表');
	});
	//已购买的套餐详情
	$scope.goPackageDetail = function(id){
		console.log("点击了已购买套餐详情按钮");
		$state.go('.detail',{id:id});
	}
}]);

angular.module('app').controller('packageListDetail',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入已购买套餐详情');
	});
}]);

angular.module('app').controller('user',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp','checkLogin',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp,checkLogin){	
	$('html, body').animate({scrollTop:0 },1);

	//checkLogin.getData();
	
	
	//请求服务详情
	requestHttp.get('').then(function(result){
		console.log('进入会员');
	});
	
	//点击不同的订单列表
	$scope.changeOrders = function(id){
		$state.go('app.orders');
	}
	
	//点击返回首页
	$scope.backHome = function(){
		$state.go('^');
	}
		
	//会员中心
	$scope.user = function(){
		$state.go('app.user');
	}
		
	//套餐服务
	$scope.goPackage = function(){
		$state.go('app.package.list');
	}
	
}]);


angular.module('app').controller('login',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
		
	$scope.info = {};
	$scope.info.userAccount = "";
	$scope.info.userPassword = "";
	
	$scope.login = function(){
//		var regUserAccount= /^1(3|4|5|7|8)\d{9}$/;
//		if(!regUserAccount.test($scope.info.userAccount)){
//			layer.open({content: "请输入手机号码.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regPassword = /^[a-zA-Z0-9_-]{6,16}$/;
//		if(!regPassword.test($scope.info.userPassword)){
//			layer.open({content: "请输入登录密码.", skin: 'msg', time: 2});
//			return false;
//		}
		
		$state.go('app.worker');
		
	}
	
	$scope.register = function(id){
		$state.go("app.register",{id:id});
	}
	
	$scope.forgetPassword = function(id){
		$state.go("app.forget");
	}
}]);

angular.module('app').controller('forget',['$scope','$location','$stateParams','$state','$interval','requestHttp',function ($scope,$location,$stateParams,$state,$interval,requestHttp){
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.info = {};
	$scope.info.userCode 		= "";
	$scope.info.userAccount 	= "";	
	$scope.info.userPassword 	= "";
	$scope.info.userCodeSer 	= "";
	
	$scope.login = function(){
		var regUserAccount= /^1(3|4|5|7|8)\d{9}$/;
		if(!regUserAccount.test($scope.info.userAccount)){
			layer.open({content: "请输入手机号码.", skin: 'msg', time: 2});
			return false;
		}
		var regCode = /^[0-9]{6,6}$/;
		if(!regCode.test($scope.info.userCode)){
			layer.open({content: "请输入验证码.", skin: 'msg', time: 2});
			return false;
		}
		if($scope.info.userCode != $scope.info.userCodeSer){
			layer.open({content: "验证码错误.", skin: 'msg', time: 2});
			return false;
		}
		var regPassword = /^[a-zA-Z0-9_-]{6,16}$/;
		if(!regPassword.test($scope.info.userPassword)){
			layer.open({content: "请输入登录密码.", skin: 'msg', time: 2});
			return false;
		}
		requestHttp.get('').then(function(result){
			console.log('修改密码状态');
		}).then(function(){
		
		});
	}
	
	$scope.codeTime = {};
	$scope.codeTime.text 	= "获取验证码";
	$scope.codeTime.state	= false;
	$scope.codeTime.second 	= window.localStorage.getItem('forgetTimeOut') || 0;
	$scope.codeTime.promise = undefined;
	$scope.code = function(){
		if($scope.codeTime.state){
			return false;
		}		
		$scope.codeTime.state = true;
		requestHttp.get('').then(function(result){
			$scope.info.userCodeSer = "";
			$scope.codeTime.second 	= 10;
		}).then(function(){
			$scope.startTime();
		});
	}	
	$scope.startTime = function(){
		$scope.codeTime.promise = undefined;
		$scope.codeTime.promise = $interval(function(){
			if($scope.codeTime.second <= 0){  
				$interval.cancel($scope.codeTime.promise);
				$scope.codeTime.promise	= undefined;				
				$scope.codeTime.text	= "重发验证码";
				$scope.codeTime.state	= false;
			}else{					
				$scope.codeTime.text = $scope.codeTime.second + "秒后可重发";  
				$scope.codeTime.second--;				
			}  
		},1000,100);
	}	
	if(parseInt($scope.codeTime.second)){
		$scope.codeTime.state = true;
		$scope.startTime();
	}
	$scope.$on("$destroy", function() {		
		$interval.cancel($scope.codeTime.promise);
		window.localStorage.setItem('forgetTimeOut',$scope.codeTime.second);
	});	
	
}]);



angular.module('app').controller('register',['$scope','$location','$stateParams','$state','$interval','requestHttp',function ($scope,$location,$stateParams,$state,$interval,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	//获取参数
	$scope.param = {};
	$scope.param.id = $stateParams.id || 0;
	
	$scope.info = {};
	$scope.info.userCode 		= "";
	$scope.info.userAccount 	= "";	
	$scope.info.userPassword 	= "";
	$scope.info.userCodeSer 	= "";
	
	$scope.login = function(){
		var regUserAccount= /^1(3|4|5|7|8)\d{9}$/;
		if(!regUserAccount.test($scope.info.userAccount)){
			layer.open({content: "请输入手机号码.", skin: 'msg', time: 2});
			return false;
		}
		var regCode = /^[0-9]{6,6}$/;
		if(!regCode.test($scope.info.userCode)){
			layer.open({content: "请输入验证码.", skin: 'msg', time: 2});
			return false;
		}
		if($scope.info.userCode != $scope.info.userCodeSer){
			layer.open({content: "验证码错误.", skin: 'msg', time: 2});
			return false;
		}
		var regPassword = /^[a-zA-Z0-9_-]{6,16}$/;
		if(!regPassword.test($scope.info.userPassword)){
			layer.open({content: "请输入登录密码.", skin: 'msg', time: 2});
			return false;
		}
		requestHttp.get('').then(function(result){
			console.log('注册账号状态');
		}).then(function(){
		
		});
	}
	
	$scope.codeTime = {};
	$scope.codeTime.text 	= "获取验证码";
	$scope.codeTime.state	= false;
	$scope.codeTime.second 	= window.localStorage.getItem('registerTimeOut') || 0;
	$scope.codeTime.promise = undefined;
	$scope.code = function(){
		if($scope.codeTime.state){
			return false;
		}		
		$scope.codeTime.state = true;
		requestHttp.get('').then(function(result){
			$scope.info.userCodeSer = "";
			$scope.codeTime.second 	= 10;
		}).then(function(){
			$scope.startTime();
		});
	}	
	$scope.startTime = function(){
		$scope.codeTime.promise = undefined;
		$scope.codeTime.promise = $interval(function(){
			if($scope.codeTime.second <= 0){  
				$interval.cancel($scope.codeTime.promise);
				$scope.codeTime.promise	= undefined;				
				$scope.codeTime.text	= "重发验证码";
				$scope.codeTime.state	= false;
			}else{					
				$scope.codeTime.text = $scope.codeTime.second + "秒后可重发";  
				$scope.codeTime.second--;				
			}  
		},1000,100);
	}	
	if(parseInt($scope.codeTime.second)){
		$scope.codeTime.state = true;
		$scope.startTime();
	}
	$scope.$on("$destroy", function() {
		$interval.cancel($scope.codeTime.promise);
		window.localStorage.setItem('registerTimeOut',$scope.codeTime.second);
	});	

}]);

angular.module('app').controller('worker',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.wallet = function(){
		$state.go('.wallet');
	}
	$scope.workerCheckInfo = function(){
		$state.go('.checkInfo');
	}
	$scope.workerSkill = function(){
		$state.go('.skill');
	}
	
}]);

angular.module('app').controller('workerWallet',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.back = function(){
		$state.go('^');
	}	
	$scope.cash = function(){
		$state.go('.cash');
	}
	$scope.list = function(){
		$state.go('.list');
	}
}]);

angular.module('app').controller('workerWalletCash',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.info = {};
	$scope.info.money = "123.01";
	
	$scope.allCash = "";
	
	$scope.back = function(){
		$state.go('^');
	}	
	$scope.all = function(){
		$scope.allCash = angular.copy($scope.info.money);
	}
	
}]);

angular.module('app').controller('workerWalletList',['$scope','$location','$stateParams','$state','$window','requestHttp',function ($scope,$location,$stateParams,$state,$window,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.back = function(){
		$state.go('^');
	}
	$scope.backHome = function(){
		$state.go('app.worker');
	}
	$scope.Reddit = {};
	$scope.Reddit.busy = false;
	$scope.Reddit.items = []
	$scope.activeData = function(){
		for (var i = 0; i < 30; i++){
			$scope.Reddit.items.push({id:1});
		}
	}	
	
	$window = angular.element($window);
	$window.on('scroll', function(){
		var dh = document.documentElement.scrollHeight || document.body.scrollHeight;
		var ds = $window.scrollTop();
		var wh = $window.height();		
		if((dh - ds) <= wh){
			$scope.activeData();
			$scope.Reddit.busy = true;
			$scope.$apply();
		}
	});	
	$scope.activeData();
}]);

angular.module('app').controller('workerCheckInfo',['$scope','$location','$stateParams','$state','$window','requestHttp',function ($scope,$location,$stateParams,$state,$window,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.back = function(){
		$state.go('^');
	}
	
	$scope.info = {};
	$scope.info.name = "";
	$scope.info.phone = "";
	$scope.info.carded = "";
	
	$scope.add =function(){

//		$scope.info.cardedHeads = angular.element(document.querySelector("div.cardedHeads img"))[0].src;
//		$scope.info.cardedTails = angular.element(document.querySelector("div.cardedTails img"))[0].src;

//		var regName= /^[\u4E00-\u9FA5A-Za-z0-9]{2,20}$/;
//		if(!regName.test($scope.info.name)){
//			layer.open({content: "请输入姓名.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regPhone= /^1(3|4|5|7|8)\d{9}$/;
//		if(!regPhone.test($scope.info.phone)){
//			layer.open({content: "请输入手机号码.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regCarded= /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
//		if(!regCarded.test($scope.info.carded)){
//			layer.open({content: "请输入身份证号码.", skin: 'msg', time: 2});
//			return false;
//		}
//		var regImages = /image\/\w+/;
//		if(!regImages.test($scope.info.cardedHeads)){
//			layer.open({content: "请上传身份证正面.", skin: 'msg', time: 2});
//			return false;
//		}
//		if(!regImages.test($scope.info.cardedTails)){
//			layer.open({content: "请上传身份证反面.", skin: 'msg', time: 2});
//			return false;
//		}
//		
//		requestHttp.get('').then(function(result){
//			
//		}).then(function(){
//		
//		});
	}
	
}]);

angular.module('app').controller('workerSkill',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);

	$scope.back = function(){
		$state.go('^');
	}	

	$scope.data = [
		{name: "水电维修" , active : 0},
		{name: "家电维修" , active : 0},
		{name: "门床柜类" , active : 0},
		{name: "家电保洁" , active : 0},
		{name: "家政保洁" , active : 0},
	];
	
	$scope.selectSkill = function(id){
		$scope.data[id].active = $scope.data[id].active ? 0 : 1;
	}

	$scope.save = function(){
		console.log($scope.data);
	}

}]);

angular.module('app').controller('workerOrders',['$scope','$location','$window','$anchorScroll','$timeout','$stateParams','$state','requestHttp',function ($scope,$location,$window,$anchorScroll,$timeout,$stateParams,$state,requestHttp){	
	$('html, body').animate({scrollTop:0 },1);
	
	$scope.param = {};
	$scope.param.type = 3;
	//点击不同的订单列表
	$scope.panelOrders = function(id){
		$scope.param.type = id;
		return false;
	}
	
}]);











































