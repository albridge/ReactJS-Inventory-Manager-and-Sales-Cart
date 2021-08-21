<?php
/* @var $this ShopsController */
/* @var $model Shops */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shops-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->dropDownList($model,'location', CHtml::listData(Locations::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->