<div class="easyui-tabs">
  <div title="基本信息">
    <form method="post" enctype="multipart/form-data" id="form-information">
      <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
        <input type="hidden" name="OrderID" id="OrderID" value="<?=isset($data['OrderID'])?$data['OrderID']:"0"?>" />
        <tr>
          <td class="textCol">流水号</td>
          <td class="contentCol"><input name="Sn" value="<?=isset($data['Sn'])?$data['Sn']:""?>" class="easyui-textbox input_width"  /></td>
          <td class="textCol">总金额</td>
          <td class="contentCol"><input class="easyui-numberbox input_width" name="OrderAmount" id="OrderAmount" value="<?=isset($data['OrderAmount'])?$data['OrderAmount']:""?>" data-options="required:true,min:0,precision:2" /></td>
        </tr>
        <tr>
          <td class="textCol">服务师傅</td>
          <td class="contentCol" colspan="3"><input  value="<?=isset($data['MasterName'])?$data['MasterName']:""?>" readonly="readonly" class="easyui-textbox input_width" data-options="required:true,width:'100%'" /></td>
        </tr>
        <tr>
          <td class="textCol">直接佣金</td>
          <td class="contentCol"><input value="<?=isset($data['DirectBonus'])?$data['DirectBonus']:""?>" readonly="readonly" class="easyui-textbox input_width"  /></td>
          <td class="textCol">直接商户</td>
          <td class="contentCol"><input value="<?=isset($data['DirectMemberNickName'])?base64_decode($data['DirectMemberNickName']):""?>" readonly="readonly" class="easyui-textbox input_width"  /></td>
        </tr>
        <tr>
          <td class="textCol">间接佣金</td>
          <td class="contentCol"><input value="<?=isset($data['DndirectBonus'])?$data['DndirectBonus']:""?>" readonly="readonly" class="easyui-textbox input_width"  /></td>
          <td class="textCol">间接商户</td>
          <td class="contentCol"><input value="<?=isset($data['DndirectMemberNickName'])?base64_decode($data['DndirectMemberNickName']):""?>" readonly="readonly" class="easyui-textbox input_width"  /></td>
        </tr>
        <tr>
          <td class="textCol">客户名称</td>
          <td class="contentCol"><input name="Customer" value="<?=isset($data['Customer'])?$data['Customer']:""?>" class="easyui-textbox input_width" data-options="required:true" /></td>
          <td class="textCol">客户电话</td>
          <td class="contentCol"><input name="Phone" value="<?=isset($data['Phone'])?$data['Phone']:""?>" class="easyui-textbox input_width" data-options="required:true" /></td>
        </tr>
        <tr>
          <td class="textCol">服务区域</td>
          <td class="contentCol" colspan="3"><input name="Region" value="<?=isset($data['Region'])?$data['Region']:""?>" class="easyui-textbox input_width" data-options="required:true,width:'100%'" /></td>
        </tr>
        <tr>
          <td class="textCol">服务地址</td>
          <td class="contentCol" colspan="3"><input name="Address" value="<?=isset($data['Address'])?$data['Address']:""?>" class="easyui-textbox input_width" data-options="required:true,width:'100%'" /></td>
        </tr>
        <tr>
          <td class="textCol">备注</td>
          <td colspan="3"><input class="easyui-textbox" name="Remark" data-options="multiline:true" id="Remark" name="Remark" value="<?=isset($data['Remark'])?$data['Remark']:""?>" style="width:380px;height:100px"></td>
        </tr>
      </table>
    </form>
  </div>
  <div title="服务清单" style="height:417px;">
    <table class="easyui-datagrid" id="ServiceTable"></table>
  </div>
</div>
<script language="javascript">
$("#ServiceTable").datagrid({  
	fit:true,
	singleSelect:true,
	data:<?=json_encode($GoodsList)?>,
	pagePosition:'bottom',
	pagination:false,
	method:'get',
    columns : [[
		{field:'GoodsName',align:'center',title:'服务名称'},
		{field:'Num',align:'left',title:'数量'},
		{field:'Price',title:'价格'},
	]]
});	
</script>