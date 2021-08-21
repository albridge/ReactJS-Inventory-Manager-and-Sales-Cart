<?php
/* @var $this ExpensesController */
/* @var $model Expenses */

$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Expenses', 'url'=>array('index')),
	array('label'=>'Manage Expenses', 'url'=>array('admin')),
);
?>

<h1>Create Expenses</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>