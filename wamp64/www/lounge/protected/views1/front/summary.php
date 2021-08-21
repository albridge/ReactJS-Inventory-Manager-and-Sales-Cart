<h1>Order Summary</h1>

<div>

<?php
$positions = Yii::app()->shoppingCart->getPositions();
?>
<table class="table table-bordered table-striped">
<tr><td>Item Name</td><td>Price</td> <td>Qty</td><td>Sub Total</td></tr>
<?php
foreach($positions as $position)
{
	?>

<tr>
	<td><?= ucwords($position->name) ?></td>
	<td><?=  number_format($position->getPrice(),2) ?></td> 
	<td><input type="text" value="<?= $position->getQuantity() ?>" style="width:60px;" onkeyup="update_cart3_rest('<?php  echo $position->id; ?>');" id="<?php  echo $position->id;  ?>count"></td>
	<td id="<?= $position->id ?>costa"><?= number_format($position->getQuantity()*$position->getPrice(),2) ?></td>
</tr>

	<?php
}

?>
  <tr><td colspan="3"></td><td id="tot"><?= number_format(Yii::app()->shoppingCart->getCost(),2) ?></td></tr> 

<?php //if(empty(Yii::app()->session['table'])){ ?>
<tr><td colspan="4" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><input type="text" class="form-control" name="table" id="table" style="float:left;" placeholder="Table no." autocomplete="Off"> </td> </tr>

<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::dropDownList('Sales[ptype]','',array('cash'=>'Cash','pos'=>'Pos','transfer'=>'Transfer'), array('style'=>'margin-left:10px;','empty'=>'','id'=>'ptype')); ?> </td></tr -->
<?php //}else{ ?>
<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::textField('Sales[table]', Yii::app()->session['table'], array('size'=>60,'maxlength'=>128,'readonly'=>'readonly')); ?> </td></tr -->
	<?php
//} ?>

<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Checkout',array('class'=>'btn btn-warning','style'=>'margin:0px;','onclick'=>'checkout_rest()')) ?></td>
<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Cancel',array('class'=>'btn btn-danger','style'=>'margin:0px;','onclick'=>'clearcart_rest()')) ?></td>
<td colspan="2" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::link('Continue Ordering',Yii::app()->createUrl('front/index'),array('class'=>'btn btn-primary','style'=>'margin:0px;')) ?></td>
</tr>


</table>
</div>

