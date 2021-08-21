<script type="text/javascript">

function printit()
{
  window.print();
}

function cran(k){
  alert(k);
}
</script>

<?php 
$this->breadcrumbs=array(
  'Sales',
);
?>

<H4>Return</H4>


  <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div style="padding:10px; background-color:#390; margin-bottom:10px; color:#fff;" class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'config-form',
  'enableAjaxValidation'=>false,
   'action' => Yii::app()->createUrl('Inventory/toreturns'),
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
$criteria->condition='staff=:k and shop_id=:y';
$criteria->params=array(':k'=>Yii::app()->user->id,':y'=>Yii::app()->user->shop_id);
$lid2 = Sales::model()->find($criteria);
$transid=$lid2->transaction_id;
?>

<?php $positions=$track; if($positions!=null){ ?>
<div style="display:block; margin:auto; margin-top:30px; overflow:auto; height:auto; width:100%; font:Arial Black;" id="invoice">


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
<td></td><td>Description</td><td>Price (<del>N</del>)</td><td>Qty</td><td>Total (<del>N</del>)</td>
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





<tr style="text-transform:capitalize;"><td></td><td><?php echo $position->item_name; ?></td> <td><?php $tp=($position->unit_price); echo number_format($tp,2); ?></td> 
  <td><?php echo $position->qty; ?> <input type="text" style="width:60px; margin-left:10px;" onkeyup="singleup('<?= $position->id ?>');" id="<?= $position->id ?>single"  name="qty[]" autocomplete="off"></td> <td><?php echo number_format($position->qty*$tp,2); ?></td></tr>
<input type="hidden" name="transaction_id" value="<?php echo $tid; ?>" />
<?php } ?>



<tr style="font-weight:bold; font-size:16px;"><td></td> <td></td> <td>Total</td> <td><?php echo number_format($position->total,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Ammount Tendered</td> <td><?php echo number_format($position->tendered,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->balance,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Vat</td> <td>5%</td></tr>
</table>

<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text2; ?></span>


</div>







<?php } ?>


