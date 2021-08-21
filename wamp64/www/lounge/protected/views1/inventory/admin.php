<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#inventory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Inventories.<?php if(Yii::app()->user->name=='admin'){ ?> | Stock Value: <del>N</del><?php echo number_format($stockv,2); ?> | Stock Cost <del>N</del><?php echo number_format($stockc,2); ?><?php } ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inventory-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/*array(
			'name'=>'photo',
			'type'=>'raw',
			'value' => CHtml::image(Yii::app()->baseUrl . "/assets/products/".$data->photo,"",array("style"=>"width:80px;height:auto; border-radius:5px;"))
			),*/
/*
		 array(
              'name'=>'photo',
              'type' => 'raw',
              'value' => '(!empty($data->photo)) ? CHtml::image(Yii::app()->baseUrl . "/assets/products/" . $data->photo,"",array("style"=>"width:80px;height:auto; border-radius:5px;")) : "No Image"'

           ), */

		'barcode',
		'name',
		'description',
		'quantity',
		'price',
		'is_countable',
		'category',
		array('header'=>'Category Name','value'=>'ucwords(Categories::model()->findByPk($data->category)->cat)'),
		/*
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

 <div style="display:block; margin-top:30px;">

        <?php echo CHtml::button('Print Report',
    array(
        'submit'=>array('Inventory/printall'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
       // 'onclick'=>'printit();'
        //'condition'=>'period=:pe',
        //'params'=>array('date1'=>$date1,'date2'=>$date2,'sup'=>$sup)
    )
); ?>

      </div>
