WEB_SITE = "/";
XuanRan();
function rebulidDialog(divID){
	var obj = $('#'+divID).dialog({onOpen:function(){}});
	if(obj){
		obj.dialog('destroy');
		$('body').append('<div id="'+divID+'"></div>');
	}
}
var PUBLIC_BIGATTR = new Array();
var PUBLIC_BIGATTR_INDEX = 0;
var PUBLIC_SMALLATTR_INDEX = 0;
/*初始化商品規格*/
function EditGoodsInitial(){
	if($(".BigDom").length > -1){PUBLIC_BIGATTR_INDEX=$(".BigDom").length;}
	if($(".SmallDomTextBox").length > -1){PUBLIC_BIGATTR_INDEX=$(".SmallDomTextBox").length;}
}
function AddBigAttr(obj){
	if($("table tr.BigDom").length > 2){
		$.messager.alert('标题','最多3个规格项目');
		return false;
	}
	idstr = 'Attr-'+PUBLIC_BIGATTR_INDEX;
	html = '<tr class="BigDom"><td><input name="Attr['+PUBLIC_BIGATTR_INDEX+'][BigAttr]" id="'+idstr+'">&nbsp;选择规格项目</td></tr>';
	html += '<tr class="SmallDom"><td><input class="SmallDomTextBox" name="Attr['+PUBLIC_BIGATTR_INDEX+'][SmallAttr][]" value="" style="margin-bottom:3px;"/><a href="javascript:;" class="easyui-linkbutton" onClick="AddSmallAttr(this,'+PUBLIC_BIGATTR_INDEX+')" BigAttrID="">添加规格值</a></td></tr>';
	$(".AddBigDom").before(html);
	$("#"+idstr).combobox({
		url:WEB_SITE+"adminc.php/Goods/index?do=AttrNameListData",
		valueField:'AttrID',
    	textField:'AttrName',
		editable:false,
		icons:[{
			iconCls:'icon-cancel',
			handler: function(e){RemoveBigAttr(e);}
		}],
	});
	PUBLIC_BIGATTR_INDEX++;
	XuanRan();
}
function RemoveBigAttr(e){
	$(e.data.target).parents('tr').next().remove();
	$(e.data.target).parents('tr').remove();
	CreateAttrTable();
}
function AddSmallAttr(obj,BigIndex){
	html = '<input class="SmallDomTextBox" name="Attr['+BigIndex+'][SmallAttr][]" value=""/>';
	$(obj).before(html);
	PUBLIC_SMALLATTR_INDEX++;
	XuanRan();
}
function XuanRan(){	
	$('.easyui-textbox').textbox();
	$('.easyui-linkbutton').linkbutton();
	$('.SmallDomTextBox').textbox({
		width:'130px;',
		cls:'SmallDomText',
		buttonText:'',
		buttonIcon:'fa fa-close',
		onClickButton:function(){
			$(this).textbox('destroy');
			CreateAttrTable();
		}
	});
}
function CreateAttrTable(){
	$("#GoodsFormPriceAttrTableFrame").html('<table id="GoodsFormPriceAttrTable" data-options="singleSelect:true"></table>');
	TableDom = $("#GoodsFormPriceAttrTable");
	if($(".BigDom input").length <1){
		//$("#GoodsFormPriceAttrTable").datagrid('destroy');
		return false;
	}
	ii = 1;
	var columns=new Array();
	$(".BigDom input").each(function(){
		
		var input_name = $(this).attr('textboxname');
		if(typeof(input_name)=="undefined"){return true;} 
		if(input_name.search(/BigAttr/i) > 0){
			BigDom = $('#'+$(this).attr('id'));
			var column={};  
                column["title"]=BigDom.combobox('getText');  
                column["field"]='a'+ii;
				column["width"]=160;
				columns.push(column);
			ii++;
		}
	});
	AttrPriceColumn = {};
	AttrPriceColumn["title"] = '价格(元)';
	AttrPriceColumn["field"] = 'AttrPrice';
	AttrPriceColumn["width"]=160;
	columns.push(AttrPriceColumn);
	QtyColumn = {};
	QtyColumn["title"] = '库存';
	QtyColumn["field"] = 'AttrQty';
	QtyColumn["width"]=160;
	columns.push(QtyColumn);
	AttrCostColumn = {};
	AttrCostColumn["title"] = '成本价';
	AttrCostColumn["field"] = 'AttrCost';
	AttrCostColumn["width"]=160;
	columns.push(AttrCostColumn);
	
	var AttrArr = new Array();
	var TableBodyData = new Array();
	var Big_x = 0;
	$(".SmallDom").each(function(BigIndex,BigItem){
		SmallArrtIndex = $(".SmallDom").index(BigItem);
		AttrArr[SmallArrtIndex] = new Array();
		var Small_x = 0;
		$(BigItem).find(".SmallDomTextBox").each(function(SmallIndex,SmallItem){
			id = $(SmallItem).attr("id");
			//组合值
			json = {'text':$(SmallItem).textbox('getValue'),'Big':Big_x,'Small':Small_x};
			AttrArr[SmallArrtIndex].push(json);
			Small_x++;
		});
		Big_x++;
	});
	rows = doExchange(AttrArr);
	
	for(i=0;i<rows.length;i++){
		
		var BodyData = {};
		AttrValue = '';
		if(rows[i].constructor === Array){
			for(x=0;x<rows[i].length;x++){
				if(AttrValue==''){
					AttrValue += rows[i][x].Big+'-'+rows[i][x].Small;
				}else{
					AttrValue += ','+rows[i][x].Big+'-'+rows[i][x].Small;
				}
				rx = 1+x;
				BodyData['a'+rx] = rows[i][x].text;
			}
		}else{
			AttrValue = '0-'+i;
			BodyData['a1'] = rows[i].text;
		}
		BodyData['AttrPrice'] =  '<input type="text" name="AttrPrice[]" data-options="required:true,width:120" class="easyui-textbox" value="" />';
		BodyData['AttrQty'] =  '<input type="text" name="AttrQty[]" data-options="required:true,width:120" class="easyui-textbox" value="" />';
		BodyData['AttrCost'] =  '<input type="text" name="AttrCost[]" data-options="required:true,width:120" class="easyui-textbox" />'+'<input type="hidden" name="AttrIndex[]" value="'+AttrValue+'" />';
		TableBodyData.push(BodyData);
	}

	TableDom.datagrid({
		singleSelect:true,
		width:'100%',height:400,
		columns:[columns],
		singleSelect:true,
	});
	TableDom.datagrid('loadData',TableBodyData)
	XuanRan();
}
function writeObj(obj){ 
 var description = ""; 
 for(var i in obj){ 
 var property=obj[i]; 
 description+=i+" = "+property+"\n"; 
 } 
 alert(description); 
} 
/*返回组合的数组*/
function doExchange(arr){
	var len = arr.length;
	// 当数组大于等于2个的时候
	if(len >= 2){
		// 第一个数组的长度
		var len1 = arr[0].length;
		// 第二个数组的长度
		var len2 = arr[1].length;
		// 2个数组产生的组合数
		var lenBoth = len1 * len2;
		//  申明一个新数组
		var items = new Array(lenBoth);
		// 申明新数组的索引
		var index = 0;
		for(var i=0; i<len1; i++){
			for(var j=0; j<len2; j++){
				if(arr[0][i] instanceof Array){
					items[index] = arr[0][i].concat(arr[1][j]);
				}else{
					items[index] = [arr[0][i]].concat(arr[1][j]);
				}
				index++;
			}
		}
		var newArr = new Array(len -1);
		for(var i=2;i<arr.length;i++){
			newArr[i-1] = arr[i];
		}
		newArr[0] = items;
		return doExchange(newArr);
	}else{
		return arr[0];
	}
}

function closeThisDialog(id){
	$("#"+id).dialog('destroy');
<<<<<<< HEAD
=======
}

//返回带<span>的颜色文字
function getColorText(text, color){
	var c = '';
	switch (color){
		case 'green' :
			c =  "#00ee00";
			break;
		case 'red' :
			c = "#FF0000";
			break;
		case 'blue':
			c ="#7cdef9";
			break;
		case 'orange':
			c ="#FFA500";
			break;	
		default:
			c = color;
			break;
	}
	return "<span style='color:"+c+"'>"+text+"</span>";
}
// 用户状态
function getStatus(status) {
	status = status.toString();
	switch (status) {
		case "1" :
			res = getColorText('启用', 'green');
			break;
		case "0" :
			res = getColorText('禁止', 'red');
			break;
		default :
			res = status;
			break;
	}
	return res;
>>>>>>> cba603039869577b5b052addcd5fa659e29533a2
}