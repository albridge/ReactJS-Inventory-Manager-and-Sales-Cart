<script type="text/javascript">

function printit()
{
	window.print();
}
</script>

<?php 
$this->breadcrumbs=array(
	'Sales',
);
?>

<H4>Track Sale</H4>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>false,
	 'action' => Yii::app()->createUrl('Inventory/tracksale'),
	'method'=>'get',
)); ?>	

	<?php echo $form->errorSummary($model); ?>	

	<div class="row" style="display:inline-block;">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>



	<div class="row" style="display:inline-block;">
	<?php echo CHtml::button('Show Receipt',
    array(
        'submit'=>array('Inventory/tracksale'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'margin-left:30px;',
        'method'=>'get',
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->


<?php  ?>

<?php


$criteria=new CDbCriteria(); 
$criteria->order='id desc';
$criteria->condition='staff=:k and shop_id=:g';
$criteria->params=array(':k'=>Yii::app()->user->id,':g'=>Yii::app()->user->shop_id);
$lid2 = Sales::model()->find($criteria);
$transid=$lid2->transaction_id;
$conf=Config::model()->findByPk(1);
?>

<?php $positions=$track; if($positions!=null){ ?>
<div style="margin-top:30px;  width:100%; font:Arial Black;" id="invoice">
<div id="loader" style="display:none;"><?= CHtml::image(Yii::app()->baseUrl . "/loader/loader11.gif","",array("style"=>"")); ?></div>

<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase;"><?php echo $conf->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $conf->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $conf->phone1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Date: <?php echo date("d-M-Y g:i:s a",Strtotime($positions[0]->created_at)); ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Receipt Number: <span id="ttid"><?php echo $positions[0]->transaction_id; ?></span></span>

<span style="display:block; text-align:center; margin-top:10px; margin-bottom:20px; font-weight:bold; font-size:16px;">Sales Receipt</span>



<span style="display:block; font-size:16px; margin-bottom:5px; text-transform:capitalize;">
Served by: <?php echo User::model()->find('id=:u',array(':u'=>Yii::app()->user->id))->username; ?>
</span>
<span style="display:block; font-size:16px; margin-bottom:10px; text-transform:capitalize;">
Customer: <?php echo Customers::model()->find('id=:u',array(':u'=>$positions[0]->customer_id))->cname; ?>
</span>

<table class="table">
<tr style="border-bottom:1px solid #000; background-color:#ccc; font-weight:bold;">
<td>Description</td><td>Price (<del>N</del>)</td><td>Qty</td><td>Total (<del>N</del>)</td>
</tr>


<?php foreach($positions as $position){
	/*
	$minusdisc=0;
	if($discount>0){
					$minusdisc=$position->unit_price-(($position->unit_price*$discount)/100);
				}else{
					$minusdisc=$position->unit_price;
				}

$plustax=(($minusdisc*$tax)/100);


$totalwd=$total;
$totaltax=($totalwd*$tax)/100;
$total2=$totalwd+$totaltax;
*/
 ?>

<tr style="text-transform:capitalize;"><td><?php echo $position->item_name; ?></td> <td><?php $tp=($position->unit_price); echo number_format($tp,2); ?></td> <td><?php echo $position->qty; ?></td> <td><?php echo number_format($position->qty*$tp,2); ?></td></tr>
<?php } ?>

<tr style="font-weight:bold; font-size:16px;"><td></td> <td></td> <td>Total</td> <td><?php echo number_format($position->total,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Ammount Tendered</td> <td><?php echo number_format($position->tendered,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->balance,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Vat</td> <td>5%</td></tr>
</table>

<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text2; ?></span>


</div>


<div style="display:inline-block; margin-top:20px;">
<?php echo CHtml::button('Print A4',
    array(
       // 'submit'=>array('Inventory/checkout2'),
       //'confirm' => 'Print Receipt?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'print();'
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>

</div>

<div style="display:inline-block;">
<?php echo CHtml::button('Print Pos',
    array(
        //'submit'=>array('Inventory/printa2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa2();'
        //'condition'=>'period=:pe',
       // 'params'=>array('id'=>$$positions[0]->transaction_id)
    )
); ?>

</div>

<?php } ?>


