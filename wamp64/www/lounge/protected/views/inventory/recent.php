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


<?php $positions=$details; if($positions!=null){ ?>
<div style=" width:100%; " id="invoice">


<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase; margin-top:20px;"><?php echo $conf->company_name; ?></span>
     <div style="display:block; margin:auto; text-align:center; ">
<?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px;")); ?>
    </div>



<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $conf->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $conf->phone1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Date: <?php echo date("d-M-Y g:i:s a",Strtotime($positions[0]->created_at)); ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Receipt Number:<span id="ttid"><?php echo $positions[0]->transaction_id; ?></span></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Table Number:<span id="ttu"><?php echo $positions[0]->table_number; ?></span></span>

<span style="display:block; text-align:center; margin-top:10px; margin-bottom:20px; font-weight:bold; font-size:16px;">Sales Receipt</span>



<span style="display:block; font-size:16px; margin-bottom:5px; text-transform:capitalize;">
Served by: <?php echo User::model()->find('id=:u',array(':u'=>$details[0]->staff))->username; ?>
</span>
<span style="display:block; font-size:16px; margin-bottom:10px; text-transform:capitalize;">
Customer: <?php echo Customers::model()->find('id=:u',array(':u'=>$details[0]->customer_id))->cname; ?>
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
<?php if($position->tendered<$position->total || $position->tendered==$position->total){ ?>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->sale_balance,2); ?></td></tr>
<?php } ?>
<?php if($position->tendered>$position->total){ ?>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Refund</td> <td><?php echo number_format($position->refund,2); ?></td></tr>
<?php } ?>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Discounted Amount</td> <td><?php echo $alldisc; ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->balance,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Vat</td> <td>5%</td></tr>
</table>

<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text2; ?></span>


</div>
<?php } ?>

<div style="display:inline-block;">

<?php
if(Yii::app()->user->role=='sales'){
 echo CHtml::button('Add to Order',
    array(
        'submit'=>array('front/setdoctor2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-success',
        'style'=>'display:inline-block; margin:0px;',
       // 'onclick'=>'printa2();'
        //'condition'=>'period=:pe',
        'params'=>array('tid'=>$positions[0]->transaction_id,'table'=>$positions[0]->table_number)
    )
); 
}
?>
</div>

<?php if($position->closed==1){  ?>
<div style="display:inline-block;">
<?php echo CHtml::button('Print Preview',
    array(
       // 'submit'=>array('Inventory/checkout2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'print();'
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>

</div>

<div style="display:inline-block;">

 <?php } ?>

 <?php if($position->closed==0 &&  Yii::app()->user->role=='cashier'
  )
 {  ?>
<div style="display:inline-block;">
<?php echo CHtml::button('Reverse Sale',
    array(
        'submit'=>array('Inventory/toreturnsgo'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        //'onclick'=>'print();'
        'params'=>array('tid'=>$positions[0]->transaction_id)
    )
); ?>

</div>

<div style="display:inline-block;">

 <?php } ?>

<?php 

if($position->closed==0 && Yii::app()->user->role=='cashier'){ 
 /* echo CHtml::button('Close Sale',
    array(
        'submit'=>array('front/doclose'),
       'confirm' => 'Close this Sale?',
        'class'=>'btn btn-danger',
        'style'=>'display:inline-block; margin:0px;',
       // 'onclick'=>'printa();'
        'params'=>array('id'=>$position->transaction_id)
    )
 );
*/
  ?>


<span><input type="button" value="Close Sale" onclick="settle('<?= $position->transaction_id ?>')" class="btn btn-danger" style="margin-left:5px;"></span>
<span style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px;"><?php echo CHtml::dropDownList('Sales[ptype]','',array('cash'=>'Cash','pos'=>'Pos','transfer'=>'Transfer'), array('style'=>'margin-left:10px;','empty'=>'','id'=>'ptype','onchange'=>'ptype('.$position->transaction_id.')')); ?> </span>
<span style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px;"> <input type="text" id="paid" class="form-control" placeholder="Enter Payment" onkeyup="formit()"> </span>
<input type="hidden" value="<?= $position->transaction_id ?>" id="tata">

  <?php
}

?>

<?php 
if(Yii::app()->user->role=='cashier'){
if($position->print==1){
echo CHtml::button('Print Receipt',
    array(
        //'submit'=>array('Inventory/printa2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-warning',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa2();'
        //'condition'=>'period=:pe',
       // 'params'=>array('id'=>$$positions[0]->transaction_id)
    )
);
}else{
  echo CHtml::button('Print Receipt',
    array(
        //'submit'=>array('Inventory/printa2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa2();'
        //'condition'=>'period=:pe',
       // 'params'=>array('id'=>$$positions[0]->transaction_id)
    )
);
}
}



 ?>

</div>


