<?php
/* @var $this DropsController */
/* @var $model Drops */

$this->breadcrumbs=array(
	'Drops'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Drops', 'url'=>array('index')),
	array('label'=>'Create Drops', 'url'=>array('create')),
	array('label'=>'View Drops', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Drops', 'url'=>array('admin')),
);
?>

<h1>Update Drops <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>