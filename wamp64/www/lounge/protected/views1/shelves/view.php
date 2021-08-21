<?php
/* @var $this ShelvesController */
/* @var $model Shelves */

$this->breadcrumbs=array(
	'Shelves'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Shelves', 'url'=>array('index')),
	array('label'=>'Create Shelves', 'url'=>array('create')),
	array('label'=>'Update Shelves', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Shelves', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shelves', 'url'=>array('admin')),
);
?>

<h1>View Shelves #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
