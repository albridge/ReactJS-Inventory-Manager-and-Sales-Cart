<?php
/* @var $this ShelvesController */
/* @var $model Shelves */

$this->breadcrumbs=array(
	'Shelves'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shelves', 'url'=>array('index')),
	array('label'=>'Manage Shelves', 'url'=>array('admin')),
);
?>

<h1>Create Shelves</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>