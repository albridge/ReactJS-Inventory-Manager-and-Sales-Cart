<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cat'); ?>
		<?php echo $form->textField($model,'cat',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cat'); ?>
	</div>


	 <div class="row">
        <?php echo $form->labelEx($model,'Category Image'); ?>
        <?php echo $form->fileField($model, 'photo'); ?>  
        <?php echo $form->error($model,'photo'); ?>
</div>

	<div class="row">
		<?php echo $form->labelEx($model,'printer'); ?>
		<?php echo $form->dropDownList($model,'printer', CHtml::listData(Printers::model()->findAll(), 'id', 'printer_name'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'printer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broad'); ?>
		<?php echo $form->dropDownList($model,'broad', array(1=>'BAR',2=>'KITCHEN'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'broad'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->