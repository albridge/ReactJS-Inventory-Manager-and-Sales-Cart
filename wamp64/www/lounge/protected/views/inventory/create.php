<script type="text/javascript">

function dobarcode(){
//alert($("#mi").val());

var bar=$("#bad").val();

    $.post("<?php echo Yii::app()->createUrl('Inventory/dobarcode'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
//$("#done").html('');
        $("#showcode").html(data);
      // $("#showcode").value(data);
      document.getElementById("showcoded").value=bar;
    });

   // $("#mi").val('');
   // $("#mi").focus();


}
</script>


<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<h1>Create Inventory</h1>

<div style="width:400px; display:inline-block;  vertical-align:top;">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>

<!--div style="width:300px; display:inline-block;  vertical-align:top; text-align:center;">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
	//'action'=>Yii::app()->createUrl("Inventory/dobarcode"),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
	'focus'=>array($model,'barcode'),
)); ?>
	<div class="form-group">
	 <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>        
        
         <?php echo CHtml::textField('Jobs[coded]', '', array('size'=>60,'maxlength'=>128,'placeholder'=>'Enter barcode','style'=>'text-align:center;','id'=>'bad')); ?>    
         <?php //echo $form->error($model,'title'); ?>  
         </div>     

         <div class="form-group">
         	<?php echo CHtml::submitButton('Generate Barcode',array('class'=>'btn btn-primary','style'=>'margin-left:10px;','onclick'=>'dobarcode(); return false;')); ?>
         </div>	

         	<?php $this->endWidget(); ?>
         	<div id="showcode">

         	</div>
</div -->



