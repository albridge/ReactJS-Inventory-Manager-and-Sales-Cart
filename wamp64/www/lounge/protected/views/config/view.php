<?php
/* @var $this ConfigController */
/* @var $model Config */

$this->breadcrumbs=array(
	'Configs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Config', 'url'=>array('index')),
	array('label'=>'Create Config', 'url'=>array('create')),
	array('label'=>'Update Config', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Config', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Config', 'url'=>array('admin')),
);
?>

<h1>View Config #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'Product Image',
			'type'=>'raw',
			'value' => CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$model['photo'],"",array("style"=>"width:80px;height:auto; border-radius:5px;"))
			),
		'company_name',
		'address',
		'phone1',
		'phone2',
		'phone3',
		'tax',
		'discount',
		'email',
		'website',
		'text1',
		'text2',
		'print_size',
		'shop',
	),
)); ?>
