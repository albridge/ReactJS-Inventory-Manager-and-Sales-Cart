<?php 
$this->breadcrumbs=array(
    'Sales',
);
?>


<script type="text/javascript">

function printit()
{
    window.print();
}
</script>




<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px; margin-top:30px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/viewsales'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

<?php echo $form->labelEx($model,'Select Date'); ?>
		  <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Inventory[created_at]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->created_at),
							
                                'options'=>array(
                                'showAnim'=>'fold',
								'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
							   'placeholder'=>'Choose date',
                                ),
                        ));  ?>
		<?php echo $form->error($model,'created_at'); ?>
        
           <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>
        <?php //echo $form->error($model,'title'); ?>
        
         <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128)); ?>           
        
        
		<?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>

        <div>

<?php
/*
if($list!=null)
{

    var_dump($list);
}
*/
?>


        </div>



<div style="display:block; margin:auto; margin-top:30px; overflow:auto; height:auto; width:100%; font:Verdana; text-align:right;">
<?php echo CHtml::button('Back to Menu',
    array(
        'submit'=>array('front/index'),
       // 'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;'
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>

<?php echo CHtml::button('Print Total Sales',
    array(
        //'submit'=>array('Inventory/printa3'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa3_all();'
        //'condition'=>'period=:pe',
       // 'params'=>array('id'=>$$positions[0]->transaction_id)
    )
); ?>


<?php //echo CHtml::button('Preview On A4',
//     array(
//        // 'submit'=>array('Inventory/checkout2'),
//       //  'confirm' => 'Are you sure you want to checkout?',
//         'class'=>'btn btn-primary',
//         'style'=>'display:inline-block; margin:0px;',
//         'onclick'=>'printit();'
//         // or you can use 'params'=>array('id'=>$id)
//     )
// ); ?>



<?php echo CHtml::button('Print Report',
    array(
        //'submit'=>array('Inventory/printa3'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa3();'
        //'condition'=>'period=:pe',
       // 'params'=>array('id'=>$$positions[0]->transaction_id)
    )
); ?>

</div>
<span id="ttid" style="display:none;"><?php echo $dyear; ?></span>



        <div style="text-align:center; margin:auto; display:block; width:100%;" id="invoice">

            <span style="margin-top:20px; margin-bottom:20px; display:block; font-weight:bold; font-size:20px;">Sales Report for: <?php  if(isset($dyear)){ echo date("d-M-Y",Strtotime($dyear)); } ?></span>
<?php
if($list!=null)
{

    foreach($list as $li){ ?>

<span style="display:block;"><?php echo $li['item_name']; ?></span>
<span style="display:block; margin-bottom:10px;">@<del>N</del><?php echo number_format($li['unit_price'],2); ?> x <?php echo $li['qty']; ?> = <del>N</del> <?php echo number_format($li['qty']*$li['unit_price'],2); ?></span>

    <?php
	$person=$li->staff;
}
}
?>

<span style="display:block; margin-bottom:5px; font-weight:bold;">Total transactions: <del>N</del> <?php echo number_format($all,2); ?></span>

<span style="display:block; margin-bottom:5px; font-weight:bold;">Returns: <del>N</del> <?php echo number_format($returns,2); ?></span>
<span style="display:block; margin-bottom:5px; font-weight:bold;">Netsale: <del>N</del> <?php echo number_format($netsale,2); ?></span>

        </div>
