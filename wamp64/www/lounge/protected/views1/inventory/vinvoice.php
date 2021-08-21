<script type="text/javascript">
function make_pay()
{
	var tid=$("#tid").val();
	var amount= $("#amount").val();
	

	$.post("<?php echo Yii::app()->createUrl('Inventory/dobalance'); ?>",
    	
    {
       tid:tid,
       amount:amount
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        if(data=='success')
        {
        	alert('Payment Succesful!');
        	var url = "<?php echo Yii::app()->createUrl('Inventory/viewcustomer'); ?>";
	$(location).attr('href',url);
        }else{
        	alert("There was an Error making Payment");
        }
       
       // $("#order").html(data);
    });
}
</script>


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






<?php 


$criteria=new CDbCriteria(); 
//$criteria->order='id desc';
$criteria->condition='transaction_id=:p';
$criteria->params=array(':p'=>$transid);
$positions = Sales::model()->findAll($criteria);
//$transid=$lid2->transaction_id;
?>
</div>

<div style="display:block; margin:auto; margin-top:30px; overflow:auto; height:auto; width:100%; font:Arial Black;" id="invoice">


<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase;"><?php echo $conf->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $conf->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $conf->phone1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Date: <?php echo date("d-M-Y H:i:s",Strtotime($positions[0]->created_at)); ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;">Receipt Number: <?php echo $transid; ?></span>

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
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Balance</td> <td><?php echo number_format($position->sale_balance,2); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Discounted Amount</td> <td><?php echo $alldisc; ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Vat</td> <td>5%</td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Mode of Payment</td> <td><?php echo ucwords($positions[0]->payment_type); ?></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td>Make Payment</td> <td><input type="text" class="form-control" id="amount"></td></tr>
<tr style="font-weight:bold; font-size:14px;"><td></td> <td></td> <td></td> <td><input type="button" value="Pay now" onclick="make_pay()" class="btn btn-primary"></td></tr>
</table>

<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text1; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize; font-weight:bold;"><?php echo $conf->text2; ?></span>

<span><input type="hidden" value="<?= $transid ?>" id="tid"></span>
</div>