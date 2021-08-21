<h2>Reset User Password</h2>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
 'action' => Yii::app()->createUrl('Inventory/resetu'),
)); ?>



	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		 <?php echo CHtml::dropDownList('Inventory[user]','',CHtml::listData(User::model()->findAll(), 'id', 'username'), array('style'=>'margin-left:10px;','empty'=>'')); ?> 
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Reset'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->