<?php

$this->breadcrumbs=array(
	'sales',
);

$items=array();
?>

<H4>Suspended Sales</H4>
<table class="table">
	<tr style="font-weight:bold; background-color:#333; color:#fff;"><td>Transaction ID</td><td>Item List</td><td>Total (<del>N</del>)</td><td>Customer Name</td><td></td></tr>
<?php
/*
foreach($lists as $li)
{
	array_push($items, $li->name);
}
var_dump($items);
*/

foreach($lists as $list)
{
	?>
<tr style="padding:10px; background-color:#ccc; margin-bottom:1px;">
	
	<td><?php  echo CHtml::link(CHtml::encode($list->cart_id), array('Inventory/tocart', 'id'=>$list->cart_id)); ?></td>
	<td><?php $items=Suspended::model()->findAll('cart_id=:l',array(':l'=>$list->cart_id)); foreach($items as $item){ echo ucwords($item->name).", "; } ?></td>
	
	<td><?php echo number_format($list->total,2); ?></td>	
	<td><?php echo customers::model()->find('id=:p',array(':p'=>$list->customer_id))->cname; ?></td>
	<td></td>
</tr>
	<?php
}

?>

</table>