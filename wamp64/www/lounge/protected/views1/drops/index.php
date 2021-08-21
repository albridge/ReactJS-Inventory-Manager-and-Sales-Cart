<?php
/* @var $this DropsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Drops',
);

$this->menu=array(
	array('label'=>'Create Drops', 'url'=>array('create')),
	array('label'=>'Manage Drops', 'url'=>array('admin')),
);
?>

<h1>Drops</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
