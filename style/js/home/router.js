var projectName = "";
var projectOrigin = window.location.origin;
var projectBaseUrl = projectOrigin + projectName + '/index.php/angular/index?t=';
var mapKey = "94c181e20536210e74abe24ca161ec84";
var app = angular.module('app', ["ui.router","oc.lazyLoad","ngTouch"]);

app.config(function($stateProvider,$urlRouterProvider,$httpProvider){
	
	//$locationProvider.html5Mode(true);
	
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	$httpProvider.defaults.transformRequest = [function(data){
		var param = function(obj){
			var query = '';
			var name, value, fullSubName, subName, subValue, innerObj, i;
			for(name in obj){
				value = obj[name];
				if(value instanceof Array){
					for(i=0; i<value.length; ++i){
						subValue = value[i];
						fullSubName = name + '[' + i + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}else if(value instanceof Object){
					for(subName in value){
						subValue = value[subName];
						fullSubName = name + '[' + subName + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}else if(value !== undefined && value !== null){
					query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
				}
			}
			return query.length ? query.substr(0, query.length - 1) : query;
		};
		return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];	
	
	$httpProvider.interceptors.push('UserInterceptor');	

	$urlRouterProvider.otherwise("/");	
	
	$stateProvider.state('app',{
		url : '/',
		views : {
			'content' : {	
				templateUrl	: projectBaseUrl+'serviceManager',
				controller	: "serviceManager",
			}
		}
	}).state('app.city',{
		url : 'city',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'city',
				controller	: 'city'
			}
		}
	});
	
	
	$stateProvider.state('app.serviceChange',{
		url : 'serviceChange/:cid',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'serviceChange',
				controller	: 'serviceChange'
			}
		}
	}).state('app.serviceChange.detail',{
		url : '/detail/:sid/:tid',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'serviceDetail',
				controller	: 'serviceDetail'
			}
		}
	}).state('app.serviceChange.order',{
		url : '/order/:sid/:tid',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'serviceOrder',
				controller	: 'serviceOrder'
			}
		}
	});
	
	$stateProvider.state('app.orders',{
		url : 'orders?type',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'orders',
				controller	: 'orders'
			}
		}
	}).state('app.orders.detail',{
		url : '/detail?id',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'ordersDetail',
				controller	: 'ordersDetail'
			}
		}
	});
		
	$stateProvider.state('app.login',{
		url : 'login',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'login',
				controller	: 'login'
			}
		}
	});	
		
		
	$stateProvider.state('app.forget',{
		url : 'forget',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'forget',
				controller	: 'forget'
			}
		}
	});
		
	$stateProvider.state('app.register',{
		url : 'register?id',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'register',
				controller	: 'register'
			}
		}
	});
	
		
	$stateProvider.state('app.worker',{
		url : 'worker',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'worker',
				controller	: 'worker'
			}
		}
	}).state('app.worker.wallet',{//钱包
		url : '/wallet',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerWallet',
				controller	: 'workerWallet'
			}
		}
	}).state('app.worker.wallet.cash',{//钱包提现
		url : '/cash',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerWalletCash',
				controller	: 'workerWalletCash'
			}
		}
	}).state('app.worker.wallet.list',{//钱包明细
		url : '/list',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerWalletList',
				controller	: 'workerWalletList'
			}
		}
	}).state('app.worker.checkInfo',{//师傅资料验证
		url : '/checkInfo',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerCheckInfo',
				controller	: 'workerCheckInfo'
			}
		}
	}).state('app.worker.skill',{//师傅技能
		url : '/skill',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerSkill',
				controller	: 'workerSkill'
			}
		}
	}).state('app.worker.orders',{//师傅订单
		url : '/orders',
		views : {
			'content@' : {
				templateUrl	: projectBaseUrl+'workerOrders',
				controller	: 'workerOrders'
			}
		}
	});
	
	
		
	$stateProvider.state('app.package',{
		url : 'package',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'package',
				controller	: 'package'
			}
		}
	}).state('app.package.detail',{
		url : '/detail?id',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'packageDetail',
				controller	: 'packageDetail'
			}
		}
	}).state('app.package.detail.order',{
		url : '/order',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'packageOrder',
				controller	: 'packageOrder'
			}
		}
	}).state('app.package.list',{
		url : '/list',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'packageList',
				controller	: 'packageList'
			}
		}
	}).state('app.package.list.detail',{
		url : '/detail?id',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'packageListDetail',
				controller	: 'packageListDetail'
			}
		}
	});
	
	$stateProvider.state('app.user',{
		url : 'user',
		views : {
			'content@' : {				
				templateUrl	: projectBaseUrl+'user',
				controller	: 'user'
			}
		}
	})
	
	
});