<?php
/* @var $this DropsController */
/* @var $model Drops */

$this->breadcrumbs=array(
	'Drops'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Drops', 'url'=>array('index')),
	array('label'=>'Create Drops', 'url'=>array('create')),
	array('label'=>'Update Drops', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Drops', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Drops', 'url'=>array('admin')),
);
?>

<h1>View Drops #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'barcode',
		'quantity',
		'product_name',
		'created_at',
		'updated_at',
	),
)); ?>
