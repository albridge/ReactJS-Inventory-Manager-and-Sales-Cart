<?php
/* @var $this ExpensesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Expenses',
);

$this->menu=array(
	array('label'=>'Create Expenses', 'url'=>array('create')),
	array('label'=>'Manage Expenses', 'url'=>array('admin')),
);
?>

<h1>Expenses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
