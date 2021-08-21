<?php
/* @var $this ExpenseTypeController */
/* @var $data ExpenseType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expense_name')); ?>:</b>
	<?php echo CHtml::encode($data->expense_name); ?>
	<br />


</div>