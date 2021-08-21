<?php
/* @var $this DropsController */
/* @var $model Drops */

$this->breadcrumbs=array(
	'Drops'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Drops', 'url'=>array('index')),
	array('label'=>'Manage Drops', 'url'=>array('admin')),
);
?>

<h1>Create Drops</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>