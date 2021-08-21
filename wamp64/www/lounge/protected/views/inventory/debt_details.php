<h1>Debt Details</h1>

<div id="invoice">

<table class="table table-bordered table-striped">
	<tr>
<td>Invoice ID</td>
<td>Customer Name</td>
<td>Total Due</td>
<td>Amount Paid</td>
<td>Discount</td>
<td>Balance</td>
	</tr>
	<?php
	$tot=0;
	foreach($model as $deal)
	{ $tot+=$deal['sale_balance'];
?>
<tr>
<td><span id="noshow"> <?= CHtml::link($deal['transaction_id'],Yii::app()->createUrl('/inventory/viewinvoice',array('id'=>$deal['transaction_id'],'target'=>'_blank'))) ?></span>
<span id="shower" style="display:block"><?= $deal['transaction_id'] ?></span>
</td>

<td><?= Customers::getCustomer($deal['customer_id']) ?></td>
<td><?= $deal['total'] ?></td>
<td><?= $deal['tendered'] ?></td>
<td><?= $deal['discount'] ?></td>
<td><?= $deal['sale_balance'] ?></td>
</tr>

<?php
	}
	?>

	<tr>
<td colspan="5">TOTAL</td>
<td><del>N</del> <?= number_format($tot,2) ?></td>
	</tr>
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