<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'password'); ?>
		<?php //echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>150)); ?>
		<?php //echo $form->error($model,'password'); ?>
	</div>
<?php if(Yii::app()->user->role==='admin'){ ?>
		<div class="row">
		<?php echo $form->labelEx($model,'shop_id'); ?>
		<?php echo $form->dropDownList($model,'shop_id', CHtml::listData(Shops::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'shop_id'); ?>
	</div>
	<?php }else{ ?>
	<div class="row">
		<?php //echo $form->labelEx($model,'shop_id'); ?>
		<?php echo $form->hiddenField($model,'shop_id', array('size'=>'60', 'maxlength'=>150,'readonly'=>true,'value'=>Yii::app()->user->shop_id)); ?>
		<?php //echo $form->error($model,'shop_id'); ?>
	</div>

	<?php } ?>


	<?php if(Yii::app()->user->role==='admin'){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', CHtml::listData(Roles::model()->findAll('role!=:l',array(':l'=>'admin')), 'role', 'role'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>
	<?php }else{ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', CHtml::listData(Roles::model()->findAll('role!=:l and role!=:h',array(':l'=>'admin',':h'=>'store_admin')), 'role', 'role'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>
	<?php } ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->