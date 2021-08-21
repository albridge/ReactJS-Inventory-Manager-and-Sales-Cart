<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Update Inventory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Inventory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<h1>View Inventory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array( /*
		array(
			'name'=>'Product Image',
			'type'=>'raw',
			'value' => CHtml::image(Yii::app()->baseUrl . "/assets/products/".$model['photo'],"",array("style"=>"width:80px;height:auto; border-radius:5px;"))
			), */
		'id',
		array(
			'name'=>'Supplier',
			'value'=>ucwords(Suppliers::model()->find("id=:k",array(":k"=>$model["supplier"]))->company_name),
			//'value'=>$model['supplier'],
			),
		'barcode',
		'name',
		'description',
		'quantity',
		'price',
		'supply_price',
		'reorder',
		'created_at',
		'updated_at',
	),
)); ?>
