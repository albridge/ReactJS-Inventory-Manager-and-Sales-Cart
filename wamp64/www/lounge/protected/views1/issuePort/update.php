<?php
/* @var $this IssuePortController */
/* @var $model IssuePort */

$this->breadcrumbs=array(
	'Issue Ports'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List IssuePort', 'url'=>array('index')),
	array('label'=>'Create IssuePort', 'url'=>array('create')),
	array('label'=>'View IssuePort', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage IssuePort', 'url'=>array('admin')),
);
?>

<h1>Update IssuePort <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>