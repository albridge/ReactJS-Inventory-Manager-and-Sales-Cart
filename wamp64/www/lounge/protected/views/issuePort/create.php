<?php
/* @var $this IssuePortController */
/* @var $model IssuePort */

$this->breadcrumbs=array(
	'Issue Ports'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List IssuePort', 'url'=>array('index')),
	array('label'=>'Manage IssuePort', 'url'=>array('admin')),
);
?>

<h1>Create IssuePort</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>