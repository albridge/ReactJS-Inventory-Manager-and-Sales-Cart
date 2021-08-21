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


// <?php //echo CHtml::button('Print Receipt',
//     array(
//        // 'submit'=>array('Inventory/checkout2'),
//       //  'confirm' => 'Are you sure you want to checkout?',
//         'class'=>'btn btn-primary',
//         'style'=>'display:inline-block; margin:0px;',
//         'onclick'=>'printa();'
//         // or you can use 'params'=>array('id'=>$id)
//     )
// ); ?>



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
$criteria->condition='staff=:k and shop_id=:h';
$criteria->params=array(':k'=>Yii::app()->user->id,':h'=>Yii::app()->user->shop_id);
$lid2 = Sales::model()->find($criteria);
$transid=$lid2->transaction_id;


$criteria=new CDbCriteria(); 
//$criteria->order='id desc';
$criteria->condition='transaction_id=:p and shop_id=:w';
$criteria->params=array(':p'=>$transid,':w'=>Yii::app()->user->shop_id);
$positions = Sales::model()->findAll($criteria);
//$transid=$lid2->transaction_id;
?>
</div>

<div style="display:block; margin:auto; margin-top:30px; overflow:auto; height:auto; width:100%; font-family:Bell Gothic; text-align:center;" id="invoice">
 <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px;")); ?>
    </div>

<span style="display:block; text-align:center; text-transform:uppercase; width:100%"><?php echo $conf->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize; width:100%;"><?php echo $conf->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; width:100%;">Tel: <?php echo $conf->phone1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; width:100%;">Date: <?php echo date("d-M-Y g:i:s a",Strtotime($positions[0]->created_at)); ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; width:100%;">Receipt Number: <?php echo $transid; ?></span>

<span style="display:block; text-align:center; margin-top:10px; margin-bottom:20px; font-size:16px; width:100%;">Sales Receipt</span>



<span style="display:block; font-size:16px; margin-bottom:5px; text-transform:capitalize;">
Served by: <?php echo user::model()->find('id=:u',array(':u'=>Yii::app()->user->id))->username; ?>
</span>
<span style="display:block; font-size:16px; margin-bottom:10px; text-transform:capitalize;">
Customer: <?php echo customers::model()->find('id=:u',array(':u'=>$details[0]->customer_id))->cname; ?>
</span>



<div style="display:block; overflow:auto; height:auto;">

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

<span style="display:block; width:100%;"><?php echo $position->item_name; ?></span>
<span style="display:block; margin-bottom:10px; width:100%;">@<del>N</del><?php $tp=($position->unit_price); echo number_format($tp,2); ?> x<?php echo $position->qty; ?> = <del>N</del>
<?php echo number_format($position->qty*$tp,2); ?></span>
<?php } ?>

<span style="font-size:16px; display:block; width:100%;">Total <del>N</del><?php echo number_format($position->total,2); ?></span>
<span style="display:block; width:100%">Ammount Tendered: <del>N</del> <?php echo number_format($position->tendered,2); ?></span>
<?php if($position->tendered<$position->total || $position->tendered==$position->total){ ?>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->sale_balance,2); ?></td></tr>
<?php } ?>
<?php if($position->tendered>$position->total){ ?>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Refund</td> <td><?php echo number_format($position->refund,2); ?></td></tr>
<?php } ?>
<span style="display:block; width:100%;"> Vat: 5%</span>
<span style="display:block; margin-bottom:10px; width:100%;">Mode of Payment: <?php echo ucwords($positions[0]->payment_type); ?></span>


<span style="display:block;  text-align:center; text-transform:capitalize; display:block; width:100%"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; display:block; width:100%;"><?php echo $conf->text2; ?></span>

</div>
</div>