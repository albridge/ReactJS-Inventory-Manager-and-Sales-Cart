<?php
/* @var $this ShelvesController */
/* @var $model Shelves */

$this->breadcrumbs=array(
	'Shelves'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Shelves', 'url'=>array('index')),
	array('label'=>'Create Shelves', 'url'=>array('create')),
	array('label'=>'View Shelves', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Shelves', 'url'=>array('admin')),
);
?>

<h1>Update Shelves <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>