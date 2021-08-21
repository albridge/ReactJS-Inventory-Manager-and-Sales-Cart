<?php
/* @var $this PrintersController */
/* @var $data Printers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('printer_name')); ?>:</b>
	<?php echo CHtml::encode($data->printer_name); ?>
	<br />


</div>