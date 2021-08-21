<div>
<h1>Recieve Stock</h1>
<table class="table table-striped table-bordered">
	<tr>
<td>ITEM NAME</td>
<td>QUANTITY</td>
<td>ACTION</td>
	</tr>
<?php
foreach($stock as $sto)
{
	?>
	<tr>
<td><?= $sto->name ?></td>
<td><?= $sto->quantity ?></td>
<td><?= CHtml::link('Recieve',array('store/shift','id'=>$sto->id),array('class'=>'btn btn-primary')) ?></td>
</tr>
	<?php
}
?>

</table>


</div>