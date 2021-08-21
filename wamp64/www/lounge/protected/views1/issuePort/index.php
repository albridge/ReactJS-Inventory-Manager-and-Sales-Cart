<?php
/* @var $this IssuePortController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Issue Ports',
);

$this->menu=array(
	array('label'=>'Create IssuePort', 'url'=>array('create')),
	array('label'=>'Manage IssuePort', 'url'=>array('admin')),
);
?>

<h1>Issue Ports</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
