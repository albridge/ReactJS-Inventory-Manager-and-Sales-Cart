<?php
/* @var $this ConfigController */
/* @var $model Config */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textArea($model,'company_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone1'); ?>
		<?php echo $form->textField($model,'phone1',array('size'=>35,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'phone1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone2'); ?>
		<?php echo $form->textField($model,'phone2',array('size'=>35,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'phone2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone3'); ?>
		<?php echo $form->textField($model,'phone3',array('size'=>35,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'phone3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tax'); ?>
		<?php echo $form->textField($model,'tax'); ?>
		<?php echo $form->error($model,'tax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	 <div class="row">
        <?php echo $form->labelEx($model,'Product Image'); ?>
        <?php echo $form->fileField($model, 'photo'); ?>  
        <?php echo $form->error($model,'photo'); ?>
</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text1'); ?>
		<?php echo $form->textArea($model,'text1',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text2'); ?>
		<?php echo $form->textArea($model,'text2',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text2'); ?>
	</div>

		<div class="row">

        <?php echo $form->labelEx($model,'shop'); ?>
        <?php echo $form->dropDownList($model,'shop',array(1=>'shop1',2=>'shop2'),array('empty' => 'Shop Type','style'=>'margin-left:10px;')); ?>
        <?php echo $form->error($model,'shop'); ?>
        
        </div>

        	<div class="row">

        <?php echo $form->labelEx($model,'print_size'); ?>
        <?php echo $form->dropDownList($model,'print_size',array(1=>'58mm',2=>'76mm'),array('empty' => 'Receipt Size','style'=>'margin-left:10px;')); ?>
        <?php echo $form->error($model,'print_size'); ?>
        
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->