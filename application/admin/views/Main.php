<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>管理登录</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/libraries/jquery-easyui-1.5.3/themes/black/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/libraries/jquery-easyui-1.5.3/themes/icon.css" />
<script type="text/javascript" src="<?=base_url()?>style/libraries/jquery-easyui-1.5.3/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>style/libraries/jquery-easyui-1.5.3/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/css/admin/menu_black2.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/css/admin/icomoon/style.css" />
</head>
<style>
#zdyCenter .panel-body{ overflow-y:hidden;}
</style>
<body class="easyui-layout">
<div data-options="region:'north',border:false" style="height:50px;">
  <h1 style="line-height:50px;margin:0; padding:0;padding-left:10px; font-size:16px; font-weight:normal; width:300px; float:left;">管理系统</h1>
  <a href="<?=site_url("Home/Logout")?>" style="float:right; color:#FFFFFF; text-decoration:none; padding-right:10px; line-height:50px;">退出登录</a>
</div>
<div data-options="region:'west',split:true,title:'菜单'" style="width:193px;" id="leftMenu">
  <ul>
	  <?php foreach($menu as $item):?>
      <li class="block">
      <input type="checkbox" name="item<?=$item['Module']['ModuleID']?>" id="item<?=$item['Module']['ModuleID']?>">
      <label for="item<?=$item['Module']['ModuleID']?>"><i aria-hidden="true" class="icon-category"></i>&nbsp;&nbsp;<?=$item['Module']["Title"]?></label>
      <ul class="options">
        <?php if(isset($item['Child'])):?>
        <?php foreach($item['Child'] as $items):?>
        <li><a href="javascript:void(0)" onClick="menuClick('<?=$items["Title"]?>','<?=site_url($items['URL'])?>')"><i aria-hidden="true" class="icon-view2"></i>&nbsp;&nbsp;<?=$items["Title"]?></a></li>
        <?php endforeach;?>
        <?php endif;?>
      </ul>
      </li>
      <?php endforeach;?>
  </ul>
</div>
<div data-options="region:'center'" id="zdyCenter">
    <div id="tabs" class="easyui-tabs"  fit="true" border="false" ></div>
</div>
</body>
</html>
<script language="javascript">
function OpenHome(){
	var url = '<?=site_url('Main/Dashboard')?>';
	var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
	$('#tabs').tabs('add',{
		title:'仪表盘',
		content:content,
		closable:false
	});
	
}
function menuClick(title, url){
	if ($('#tabs').tabs('exists', title)){
		$('#tabs').tabs('select', title);
	} else {
		var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
		$('#tabs').tabs('add',{
			title:title,
			content:content,
			closable:true
		});
	}
}
setTimeout("OpenHome()",500);
</script>
