<h1>List of Debtors</h1>

<div id="invoice">
<table class="table table-striped table-bordered">
	<tr>
		<td colspan="1">DEBTORS LIST</td><td><?= ucwords(Shops::model()->findByPk(Yii::app()->user->shop_id)->name) ?></td>
	</tr>
	<tr>
<td>Cutomer Name</td>
<td>Amount Owed</td>
<td>View Account</td>
	</tr>
<?php 
$tot=0;
foreach($model as $mod)
{
	$sqlo="select distinct(transaction_id), sale_balance from sales where customer_id='".$mod['customer_id']."'";
			$owed = Yii::app()->db->createCommand($sqlo)->queryAll();
			foreach($owed as $owe)
			{
				$tot+=$owe['sale_balance'];
			}
	?>
<tr>
<td><?= $mod['customer_id']!=null ? ucwords(Customers::model()->findByPk($mod['customer_id'])->cname) : 'Walk in customer' ?></td>
<td><del>N</del> <?php  echo number_format($tot,2) ?></td>
<td id="noshow"><?= CHtml::link('View Details',array('inventory/debt_details','id'=>$mod['customer_id']),array('id'=>'norshow')) ?></td>
</tr>

	<?php
}
?>
</table>

</div>

<div>
<?php echo CHtml::button('Print A4',
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