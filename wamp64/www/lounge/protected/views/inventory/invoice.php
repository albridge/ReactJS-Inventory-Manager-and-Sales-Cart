<?php  
//Yii::app()->clientScript->scriptMap['styles.css'] = false;

// echo  $baseUrl = Yii::app()->baseUrl; 
//  $cs = Yii::app()->getClientScript();
 // $cs->registerScriptFile($baseUrl.'/protected/views/inventory/jquery213.js');
  //$cs->registerCssFile($baseUrl.'/protected/views/inventory/bootstrap.css');
?>


<?php
/* @var $this InventoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventories',
);

$this->menu=array(
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<script type="text/javascript">

function printit()
{
	window.print();
}
</script>


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


<?php echo CHtml::button('Print A4',
    array(
       // 'submit'=>array('Inventory/checkout2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printit();'
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>


 <?php echo CHtml::button('Print Pos',
    array(
       // 'submit'=>array('Inventory/checkout2'),
       'confirm' => 'Print Receipt?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'printa();'
        // or you can use 'params'=>array('id'=>$id)
    )
 ); ?>



<?php 



/*

	$plustax=(($position->price*$tax)/100);
					$date=time();
					$sale= new Sales();
					$sale->item_name=$position->name;
					$sale->item_id=$position->getid();
					$sale->transaction_id=$transaction_id;
					$sale->qty=$position->getQuantity();
					$sale->unit_price=($position->price+$plustax);
					$sale->total=Yii::app()->shoppingCart->getCost();
					$sale->staff=Yii::app()->user->id;
					$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->discount=$disc;
					$sale->tax=$tax;
				//	$sale->updated_at=date("Y-m-d H:i:s");

				*/



//$positions = Yii::app()->shoppingCart->getPositions(); ?>

<?php


$criteria=new CDbCriteria(); 
$criteria->order='id desc';
$criteria->condition='staff=:k and shop_id=:u';
$criteria->params=array(':k'=>Yii::app()->user->id,':u'=>Yii::app()->user->shop_id);
$lid2 = Salesx::model()->find($criteria);
$transid=$lid2->transaction_id;
$time=$lid2->created_at;


$criteria=new CDbCriteria(); 
//$criteria->order='id desc';
if($positions[0]->closed==1){
$criteria->condition='transaction_id=:p and shop_id=:ff';
$criteria->params=array(':p'=>$transid,':ff'=>Yii::app()->user->shop_id);
}else{
$criteria->condition='created_at=:p and shop_id=:ff';	
$criteria->params=array(':p'=>$time,':ff'=>Yii::app()->user->shop_id);
}

$positions = Salesx::model()->findAll($criteria);
//$transid=$lid2->transaction_id;
// $pat=array();
// $jim="2,3,4,5,6,4";
// $ann=explode(',', $jim);
// for($x=0; $x<count($ann); $x++)
// {
// 	$pat[$x]=$ann[$x];
// }
// var_dump($pat);
?>
</div>

<div style=" width:100%; " id="invoice">

 <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
 <div id="loader" style="display:none;"><?= CHtml::image(Yii::app()->baseUrl . "/loader/loader11.gif","",array("style"=>"")); ?></div>
<?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px;")); ?>
    </div>
<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase;"><?php echo $conf->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $conf->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $conf->phone1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Date: <?php echo date("d-M-Y g:i:s a",Strtotime($positions[0]->created_at)); ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Receipt Number: <?php echo $transid; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Table Number: <?php echo $positions[0]->table_number; ?></span>
<span style="display:block; text-align:center; margin-top:10px; margin-bottom:20px; font-weight:bold; font-size:16px;">Sales Receipt</span>



<span style="display:block; font-size:16px; margin-bottom:5px; text-transform:capitalize;">
Served by: <?php echo User::model()->find('id=:u and shop_id=:g',array(':u'=>Yii::app()->user->id,':g'=>Yii::app()->user->shop_id))->username; ?>
</span>
<span style="display:block; font-size:16px; margin-bottom:10px; text-transform:capitalize;">
Customer: <?php echo Customers::model()->find('id=:u and shop_id=:y',array(':u'=>$positions[0]->customer_id,':y'=>Yii::app()->user->shop_id))->cname; ?>
</span>

<table class="table">
<tr style="border-bottom:1px solid #000; background-color:#ccc; font-weight:bold;">
<td>Description</td><td>Price (<del>N</del>)</td><td>Qty</td><td>Total (<del>N</del>)</td>
</tr>
<?php 
$alldisc=0;
foreach($positions as $position){
	$alldisc+=$position->discount;
}

	?>

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
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Vat</td> <td>5%</td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Mode of Payment</td> <td><?php echo ucwords($positions[0]->payment_type); ?></td></tr>
</table>

<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text2; ?></span>


</div>

</div>

<script type="text/javascript">
window.onload = function(){	
$("#loading").hide();
 
}
</script>

