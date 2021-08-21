<?php
/* @var $this CustomersController */
/* @var $model Customers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cname'); ?>
		<?php echo $form->textField($model,'cname',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'cname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caddress'); ?>
		<?php echo $form->textField($model,'caddress',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'caddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cemail'); ?>
		<?php echo $form->textField($model,'cemail',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'cemail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cphone1'); ?>
		<?php echo $form->textField($model,'cphone1',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cphone1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cphone2'); ?>
		<?php echo $form->textField($model,'cphone2',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cphone2'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->