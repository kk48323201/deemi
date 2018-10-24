<form method="post" enctype="multipart/form-data" id="form-information">
  <table class="infobox" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
    <input type="hidden" name="TrainingID" id="TrainingID" value="<?=isset($data['TrainingID'])?$data['TrainingID']:"0"?>" />
    <tr>
      <td class="textCol">名称</td>
      <td class="contentCol"><input type="text" name="TrainingName" id="TrainingName" class="easyui-textbox input_width" value="<?=isset($data['TrainingName'])?$data['TrainingName']:""?>" data-options="width:'100%',required:true"  /></td>
    </tr>
  </table>
</form>