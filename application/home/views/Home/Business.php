<?php $this->load->view("Common/Head");?>
<style>
body { height:100vh; background: #fff; color: #3D3D3D; }
.mapBox { width: 100vw; font-size: 14px; height: 100vh; }
.mapBox > #mapInfo { padding: 20px; }
.mapBox > div { width: 100%; height: 100%; }
.mapBox > p { padding: 20px; }
.addShop { display: block; color: #fff; background: #00CC99; border: none; font-size: 14px; width: 50vw; margin: 0.4rem 0 0 25vw; padding: 0.32rem; border-radius: 0.8rem; }
.mapInfo > p.center { text-align: center; }
.mapInfo > p { line-height: 0.533333rem; }
.mapInfo > button { display: block; margin: 0.106667rem auto; color: #0c9; background: #fafafb; border: 1px solid #0c9; border-radius: 0.133333rem; padding: 0.15rem 0.3rem; }
#mapTitle{ height:28px; display:inline-block; left:0; top:0; position:fixed; background:#000000; color:#FFFFFF; line-height:28px; padding:0 10px; z-index:999;}
</style>
<script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>

<div class="mapBox">
    <div id="mapBox">
        <p id="mapInfo"></p>
        <p id="mapTitle">加盟商户</p>
    </div>
</div>
<?php $this->load->view("Common/FooterNav",array('CurNav'=>'Home'));?>
<?php $this->load->view("Common/Footer");?>
<script language="javascript">
showMap(22.25947,113.55038);      //假设要以这个地址为中心点显示地图

function showMap(latitude, longitude){
    var map = new qq.maps.Map(document.getElementById("mapBox"),{    //地图部分初始化
        zoom: 12,               //设置地图缩放级别
        center: new qq.maps.LatLng(latitude, longitude),     //设置中心点
        zoomControl: false,    //不启用缩放控件
        mapTypeControlOptions: {  //设置控件的地图类型为普通街道地图
            mapTypeIds: qq.maps.MapTypeId.ROADMAP
        }
    });
    var info = new qq.maps.InfoWindow({ map: map });      //添加提示窗

    var result = <?=$MarketData?>;
    //result中数据 用于显示标记、和标记点击时的提示信息
    if(result.code==0 && result.msg=="success"){
        for(var i=0; i<result.data.length; i++){
            var data = result.data[i];
		    var marker = new qq.maps.Marker({ 
				position: new qq.maps.LatLng(data.lat, data.lng)
				,map: map
			}); 
			marker.data = data;
            qq.maps.event.addListener(marker, 'click', function(e) {    //获取标记的点击事件
                info.open();  //点击标记打开提示窗
				console.log(e);
                info.setContent('<div class="mapInfo"><p class="center">'+e.target.data.RealName+'</p>加盟店</div>');  //***设置提示窗内容（这里用到了marker对象中保存的数据）
                info.setPosition(new qq.maps.LatLng(e.latLng.getLat(), e.latLng.getLng()));  //提示窗位置
            });
        }
    }else{
        layer.open({ content: "获取附近商铺失败", skin: 'msg', time: 2 });
    }
}

function bindShop(shopInfo){    //地图标注提示窗上按钮 点击后执行的函数
    alert(shopInfo);  //传过来的包含 id/经度/纬度 的字符串参数
}
</script>
