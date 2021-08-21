<?php
/* @var $this IssuePortController */
/* @var $model IssuePort */

$this->breadcrumbs=array(
	'Issue Ports'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IssuePort', 'url'=>array('index')),
	array('label'=>'Create IssuePort', 'url'=>array('create')),
	array('label'=>'Update IssuePort', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IssuePort', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IssuePort', 'url'=>array('admin')),
);
?>

<h1>View IssuePort #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_id',
		'barcode',
		'quantity',
		'description',
		'created_at',
		'updated_at',
	),
)); ?>
