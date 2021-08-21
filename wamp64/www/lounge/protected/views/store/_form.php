<?php
/* @var $this InventoryController */
/* @var $model Inventory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
	'focus'=>array($model,'barcode'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Supplier'); ?>
		<?php echo $form->dropDownList($model,'supplier', CHtml::listData(Suppliers::model()->findAll(), 'id', 'company_name'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'supplier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barcode'); ?>
		<?php echo $form->textField($model,'barcode',array('size'=>60,'maxlength'=>200,'id'=>'showcoded','autofocus'=>'true')); ?>
		<?php echo $form->error($model,'barcode'); ?>
	</div>

	<div>
		

	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->dropDownList($model,'category', CHtml::listData(Categories::model()->findAll(), 'id', 'cat'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit'); ?>
		<?php echo $form->dropDownList($model,'unit', CHtml::listData(Units::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shelf_number'); ?>
		<?php echo $form->dropDownList($model,'shelf_number', CHtml::listData(Shelves::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'shelf_number'); ?>
	</div>


	 <div class="row">
        <?php echo $form->labelEx($model,'Product Image'); ?>
        <?php echo $form->fileField($model, 'photo'); ?>  
        <?php echo $form->error($model,'photo'); ?>
</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Supply price'); ?>
		<?php echo $form->textField($model,'supply_price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'supply_price'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'Selling Price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Re-order Quantity'); ?>
		<?php echo $form->textField($model,'reorder',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'reorder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_countable'); ?>
		<?php echo $form->dropDownList($model,'is_countable',array('0'=>'Not Coutable','1'=>'Coutable'), array('empty'=>'')); ?>

		<?php echo $form->error($model,'is_countable'); ?>
	</div>

<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>
*/ ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->