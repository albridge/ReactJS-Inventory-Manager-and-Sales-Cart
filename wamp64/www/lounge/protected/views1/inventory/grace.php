<h2>Enter key</h2>
<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'post',
 'action' => Yii::app()->createUrl('Inventory/grace'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>
<?php echo CHtml::textField('Inventory[key]', '', array('size'=>60,'maxlength'=>128)); ?>      

		<?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>