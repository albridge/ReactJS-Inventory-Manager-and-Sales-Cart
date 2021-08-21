<?php
/* @var $this CustomersController */
/* @var $data Customers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cname')); ?>:</b>
	<?php echo CHtml::encode($data->cname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caddress')); ?>:</b>
	<?php echo CHtml::encode($data->caddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cemail')); ?>:</b>
	<?php echo CHtml::encode($data->cemail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cphone1')); ?>:</b>
	<?php echo CHtml::encode($data->cphone1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cphone2')); ?>:</b>
	<?php echo CHtml::encode($data->cphone2); ?>
	<br />


</div>