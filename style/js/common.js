function base_url(str){
	return 'https://'+document.domain+'/'+str;
}
function site_url(str){
	var base_url = 'http://'+document.domain+'/';
	return base_url+'index.php/'+str;
}
function GetRequest(){
   var url = location.search; //获取url中含"?"符后的字串
   var theRequest = new Object();
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}
function jump(e){
	window.location.href=e;
}
function isPoneAvailable(phone) {  
  var myreg=/^[1][3,4,5,6,7,8][0-9]{9}$/;  
  if (!myreg.test(phone)) {  
	  return false;  
  } else {  
	  return true;  
  }  
}  
function fmoney(value){
	var value=Math.round(parseFloat(value)*100)/100;
	var xsd=value.toString().split(".");
	if(xsd.length==1){
		value=value.toString()+".00";
		return value;
	}
	if(xsd.length>1){
		if(xsd[1].length<2){
			value=value.toString()+"0";
		}
		return value;
	}
}

function convertDateFromString(dateString) { 
	if (dateString) { 
		var arr1 = dateString.split(" "); 
		var sdate = arr1[0].split('-'); 
		var date = new Date(sdate[0], sdate[1]-1, sdate[2]); 
		return date;
	} 
}
