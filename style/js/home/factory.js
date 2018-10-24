app.factory('requestHttp',['$http','$q',function($http,$q){
	return{
		post:function(url,data){
			var defer=$q.defer();
			$http({
				method	: 'post',
				url		: url,
				data	: data,

			}).then(function(result,status,headers,config){
				defer.resolve(result,status,headers,config);
			}).catch(function(result,status,headers,config){
				defer.reject(result,status,headers,config);
			});                     
        	return defer.promise;
        },
		get:function(url,data){
			var defer=$q.defer();
			var str = '';
			if(angular.isObject(data)){
				angular.forEach(data,function(value,param){
					str = str ? str + "&" + param + "=" + value : "?" + param + "=" + value;
				});
			}
			url = url + str;	
			$http({
				method	: 'get',
				url		: url,
			}).then(function(result,status,headers,config){
				defer.resolve(result,status,headers,config);
			}).catch(function(result,status,headers,config){
				defer.reject(result,status,headers,config);
			});  
        	return defer.promise;
        },
		jsonp:function(url){
			var defer=$q.defer();
			$http({
				method	: 'jsonp',
				url		: url,
			}).then(function(result,status,headers,config){
				defer.resolve(result,status,headers,config);
			}).catch(function(result,status,headers,config){
				defer.reject(result,status,headers,config);
			});  
        	return defer.promise;
        }
	}
}]);

app.factory('loading',[function(){
	return{
		open:function(){
			$('html, body').animate({scrollTop:0 },1);
			layer.open({type: 2});
        },
		close:function(){
			layer.closeAll();
        },
		msg:function(msg){
			layer.open({content:msg,skin:'msg',time:2});
		}
	}
}]);

app.factory('loactionCity', ["$q", "$window","requestHttp", function($q, $window,requestHttp) {     
    var getData  = function(mapKey){
		//$window.localStorage.setItem('userLocation',null);
		//开始委托
	    var deferred = $q.defer();
		//默认数据
		var data = {};		
		//获取历史记录
		var userLocation = $window.localStorage.getItem('userLocation');
		//记录不存在,获取当前城市及省份
		if(userLocation == null || userLocation == "null"){
			requestHttp.get('http://restapi.amap.com/v3/ip',{key:mapKey}).then(function(result){
				data.provincial = result.data.province;
				data.city = result.data.city;					
			}).then(function(){//判断自动获取当前城市是否合法
				requestHttp.get('http://dingdong.zh3721.com/index.php/api/other/city',{ProvincialID:"0",CityName:data.city}).then(function(result){			
					if(result.data.length <= 0){
						data.provincial = "广东省";
						data.provincialID = "440000";
						data.city = "珠海市";
						data.cityID = "440400";				
					}else{
						data.provincialID = result.data[0].ProvincialID;
						data.city = result.data[0].CityName;
						data.cityID = result.data[0].CityID;
					}
				}).then(function(){			
					deferred.resolve(data);
					$window.localStorage.setItem('userLocation',angular.toJson(data));
				});
			});
		}else{
			var data = angular.fromJson(userLocation);
				deferred.resolve(data);
		}
        return deferred.promise;  
    }  
    return{  
        getData : getData   
    };  
}]);

app.factory('checkLogin', ["$q", "$window","requestHttp", function($q, $window,requestHttp) {     
    var getData = function(){
		$('html, body').animate({scrollTop:0 },1);		
		var data = "";
		var deferred = $q.defer();	
		requestHttp.get('/index.php/angular/checkLogin').then(function(result){
			data = result.data.data;
			if(data == 0){
				//$window.location.href = "/index.php/wechat/login?ddurl="+($window.location.href.replace(/#/, "@"));
			}		
		}).then(function(){
			deferred.resolve(data);
		});
        return deferred.promise;
    }  
    return{
        getData : getData
    };  
}]);

app.directive('stringToNumber',function(){
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(value) {				
                return '' + value;
            });
            ngModel.$formatters.push(function(value) {
				return Number(value);
            });
        }
    };
});
app.directive('numberToString',function(){
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(value) {
                return parseInt(value);
            });
            ngModel.$formatters.push(function(value) {
				return '' + value; 
            });
        }
    };
})



app.directive('fileModel', ['$parse', function($parse) {  
    return {  
        restrict:'A',
         link:function(scope, element, attrs, ngModel){
            element.bind('change', function(event){	
				layer.closeAll();		
				layer.open({type: 2});
                scope.file = (event.srcElement || event.target).files[0];
				var reader = new FileReader();
					reader.readAsDataURL(scope.file);
					reader.onload = function(){
						var result = this.result;
						var maxsize = 100 * 1024;
						var img 	= new Image();
							img.src = result;			
							if(result.length <= maxsize){
								scope.$apply(function(){
									scope.thumb(result);
									img = null;
									layer.closeAll();
								});
								return false;
							}
							img.onload = function(){
								var data = compress(img);
								scope.$apply(function(){
									scope.thumb(data);
									img = null;
									layer.closeAll();
								});
							}

					};
            });
			var compress = function(img) {
				var canvas 	= document.createElement("canvas");
				var ctx 	= canvas.getContext('2d');
				var tCanvas = document.createElement("canvas");
				var tctx 	= tCanvas.getContext("2d");
				var initSize = img.src.length;
				var width = img.width;
				var height = img.height;
				var ratio;
				if((ratio = width * height / 4000000) > 1){
					ratio = Math.sqrt(ratio);
					width /= ratio;
					height /= ratio;
				}else{
					ratio = 1;
				}
				canvas.width = width;
				canvas.height = height;
				ctx.fillStyle = "#fff";
				ctx.fillRect(0, 0, canvas.width, canvas.height);
				var count;
				if((count = width * height / 1000000) > 1){
					count = ~~(Math.sqrt(count) + 1);
					var nw = ~~(width / count);
					var nh = ~~(height / count);
					tCanvas.width = nw;
					tCanvas.height = nh;
					for (var i = 0; i < count; i++){
						for (var j = 0; j < count; j++){
							tctx.drawImage(img, i * nw * ratio, j * nh * ratio, nw * ratio, nh * ratio, 0, 0, nw, nh);
							ctx.drawImage(tCanvas, i * nw, j * nh, nw, nh);
						}
					}
				}else{
					ctx.drawImage(img, 0, 0, width, height);
				}
				var ndata = canvas.toDataURL('image/jpeg', 0.1);
				tCanvas.width = tCanvas.height = canvas.width = canvas.height = 0;
				return ndata;
			};
        }  
    }  
}]);


app.factory('UserInterceptor', ["$q","$state","$window",function ($q,$state,$window) {
	return {
		request: function(config){
			return config;
		},
		requestError: function(request){
			return $q.reject(request);
		},
		response: function(config){
			return config;
		},
		responseError: function(response){
			if(501 === response.status){
				layer.closeAll();
				layer.open({type: 2});
				$window.location.href = "/index.php/angular/login?ddurl="+($window.location.href.replace(/#/, "@"));
			}
			return $q.reject(response);
		}
	};
}]);










