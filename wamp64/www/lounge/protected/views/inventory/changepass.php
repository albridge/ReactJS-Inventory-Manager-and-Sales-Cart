<?php

$this->breadcrumbs=array(
	'User',
);

$items=array();
?>


<h1>Change Password</h1>


<?php /*  $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'failed'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); 
	?>
    
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    ));  */
	?>

	<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div style="padding:10px; background-color:#390; margin-bottom:10px; color:#fff;" class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<div style="width:650px; height:auto; overflow:auto; display:block;  ">
<div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'password-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl('inventory/Password'),
	'htmlOptions'=>array('style'=>'width:250px; overflow:auto; height:auto;'),
)); ?>

<div >
		<?php //echo $form->labelEx('Old Password',''); ?>
		<?php echo CHtml::passwordField('User[old_pass]','',array('placeholder'=>'Old Password')); ?>
		<?php //echo $form->error($model,'old_pass'); ?>
	</div>
    
    <div >
		<?php //echo $form->labelEx('New Pass',''); ?>
		<?php echo CHtml::passwordField('User[new_pass]','',array('placeholder'=>'Enter New Password')); ?>
		<?php //echo $form->error($model,'new_pass'); ?>
	</div>
    
    <div >
		<?php //echo $form->labelEx('New Pass',''); ?>
		<?php echo CHtml::passwordField('User[re_new_pass]','',array('placeholder'=>'Repeat New Password')); ?>
		<?php //echo $form->error($model,'new_pass'); ?>
	</div>
    
    <?php echo CHtml::hiddenField('User[id]',Yii::app()->user->id,array('placeholder'=>'Repeat New Password')); ?>
    
    	<div>
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php echo CHtml::submitButton('Change Password', array('style'=>' margin-left:10px;')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>