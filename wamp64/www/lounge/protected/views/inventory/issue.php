<script type="text/javascript">
function get_item()
{
	var item=$("#item").val();
	
	$.post("<?= Yii::app()->createUrl('Inventory/get_issue_item'); ?>",
	{
		item:item
	},
	function(data,status)
	{
		$("#gotten").html(data);
	});
}

function show_issued_items(id,name)
{
	$.post("<?= Yii::app()->createUrl('Inventory/show_issued_items'); ?>",
	{
		name:name,
		id:id
	},
	function(data,status)
	{
		$("#dtable").html(data);
		$("#item").val('');
		$("#gotten").html('');
	});
}

function load_issue()
{
	
	$("#dtable").load("<?= Yii::app()->createUrl('Inventory/is_issue') ?>");
}


function clear_issue()
{
	if(confirm('Clear Issues?'))
	{
	$("#dtable").load("<?= Yii::app()->createUrl('Inventory/clear_issue') ?>");
	}
}
</script>
<h1>Select stock</h1>


<div style="float:left; position:relaive;">

<?= CHtml::textField('item','',array('onkeyup'=>'get_item()','id'=>'item')) ?>
<div id="gotten" style="width:400px; position:absolute;"></div>
</div>

<div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl('inventory/send_issue'),
	'htmlOptions' => array(
       
    ),
	
)); ?>
<div style="display:block;">
<?= CHtml::dropDownList('Inventory[shop_id]','',CHtml::listData(Shops::model()->findAll('id!=:f',array(':f'=>1)), 'id', 'name'), array('style'=>'margin-left:10px;','empty'=>'')); ?> 
</div>

<div id="dtable"></div>

<?php $this->endWidget(); ?>
</div>