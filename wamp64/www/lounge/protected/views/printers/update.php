<?php
/* @var $this PrintersController */
/* @var $model Printers */

$this->breadcrumbs=array(
	'Printers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Printers', 'url'=>array('index')),
	array('label'=>'Create Printers', 'url'=>array('create')),
	array('label'=>'View Printers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Printers', 'url'=>array('admin')),
);
?>

<h1>Update Printers <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>