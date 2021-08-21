<h1>Sales</h1>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('front/sales'),
  'enableAjaxValidation'=>false,
  'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

<?php echo $form->labelEx($model,'Select Date'); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Inventory[date1]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-mm-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'Choose date',
                 'autocomplete'=>'off',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'created_at'); ?>

     <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Inventory[date2]',
                                'id'=>'coldate1',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->updated_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'to',
                 'autocomplete'=>'off',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'updated_at'); ?>

   


   
  </div>

        
    <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>


<div>
<?php if($doctors!=null){
foreach($doctors as $doc)
{
	echo CHtml::link($doc['transaction_id']." : ".$doc['table_number']." : ".ucwords(User::model()->findByPk($doc['staff'])->username), Yii::app()->createUrl('inventory/recent',array('id'=>$doc['transaction_id'],'table'=>$doc['table_number'])),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin-bottom:5px;'));
	?>


	<?php
}
}

?>

</div>