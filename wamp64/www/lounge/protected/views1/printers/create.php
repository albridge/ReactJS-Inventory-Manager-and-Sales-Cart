<?php
/* @var $this PrintersController */
/* @var $model Printers */

$this->breadcrumbs=array(
	'Printers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Printers', 'url'=>array('index')),
	array('label'=>'Manage Printers', 'url'=>array('admin')),
);
?>

<h1>Create Printers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>