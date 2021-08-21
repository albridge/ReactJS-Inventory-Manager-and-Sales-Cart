<h1>Stock List</h1>

<div id="invoice" style="width:100%">
	     <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:80px;height:auto; border-radius:5px;")); ?>
    </div>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?= $pic->address ?><br>
<?= $pic->phone1 ?>
    </div>
    <h2>Stock Position Sales points</h2>
<table class="table table-bordered table-striped">
	<tr style="font-weight:bold;">
<td>Product Name</td>
<td>Quantity</td>
<td>CP</td>
<td>SP</td>
<td>VALUE (CP)</td>
<td>VALUE (SP)</td>

    </tr>
<?php
$totc=0;
$tots=0;
foreach($stocks as $stock)
{ $totc+=$stock->supply_price*$stock->quantity;
    $tots+=$stock->price*$stock->quantity;
    ?>
    <tr>
<td><?= ucwords($stock->name) ?></td>
<td><?= $stock->quantity ?></td>
<td><?= number_format($stock->supply_price,2) ?></td>
<td><?= number_format($stock->price,2) ?></td>
<td><?= number_format($stock->supply_price*$stock->quantity,2) ?></td>
<td><?= number_format($stock->price*$stock->quantity,2) ?></td>

</tr>
    <?php
}
?>
 <tr style="font-weight:bold;">
<td colspan="3"></td>
<td>TOTAL</td>
<td><?= number_format($totc,2) ?></td>
<td><?= number_format($tots,2) ?></td>
</tr>
</table>
</div>

<div>
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