<?php
/* @var $this PrintersController */
/* @var $model Printers */

$this->breadcrumbs=array(
	'Printers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Printers', 'url'=>array('index')),
	array('label'=>'Create Printers', 'url'=>array('create')),
	array('label'=>'Update Printers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Printers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Printers', 'url'=>array('admin')),
);
?>

<h1>View Printers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'printer_name',
	),
)); ?>
