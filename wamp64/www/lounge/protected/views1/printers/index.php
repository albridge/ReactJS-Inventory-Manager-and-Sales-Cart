<?php
/* @var $this PrintersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Printers',
);

$this->menu=array(
	array('label'=>'Create Printers', 'url'=>array('create')),
	array('label'=>'Manage Printers', 'url'=>array('admin')),
);
?>

<h1>Printers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
