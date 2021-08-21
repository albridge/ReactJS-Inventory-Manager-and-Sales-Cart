<div>
<h1>Stock Movement Report</h1>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('store/sout'),
  'enableAjaxValidation'=>false,
  'htmlOptions'=>array('style'=>'margin-left:0px;',
    'autocomplete'=>'Off'),

)); ?>

<?php echo $form->labelEx($model,'Select dates',array('style'=>'margin-left:-30px;')); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Midstore[date1]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'from',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'created_at'); ?>
        
        
        
       
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Midstore[date2]',
                                'id'=>'coldate1',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'to',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'created_at'); ?>
        
        
        
        <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
          <?php $this->endWidget(); ?>
</div>


<table class="table table-bordered table-striped">

	<tr>
<td>Item Name</td>
<td>Opening Quantity</td>
<td>Quantity In</td>
<td>Quantity Out</td>
<td>Closing Quantity</td>
	</tr>
<?php
if($report!=null)
{
	foreach($report as $rep){
		?>
	<tr>
<td><?= Store::model()->findByPk($rep['item_id'])->name ?></td>
<td><?= $rep['current_quantity'] ?></td>
<td><?= $rep['ins'] ?></td>
<td><?= $rep['outs'] ?></td>
<td><?= ($rep['current_quantity']-$rep['outs'])+$rep['ins'] ?></td>
	</tr>


		<?php
	}
}

?>

</table>
</div>