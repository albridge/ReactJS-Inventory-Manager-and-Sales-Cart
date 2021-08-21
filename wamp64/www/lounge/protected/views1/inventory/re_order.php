<h1>Re-order Report</h1>

<div>
<?php
//var_dump($reel);
?>
<table class="table table-bordered table-striped">
	<tr>
<td>Item Name</td>
<td>Item Id</td>
<td>Item Quantity</td>
<td>Reorder Quantity</td>
<td>Product Code</td>
	</tr>
<?php
foreach($reel as $row)
{
	?>
<tr>
<td><?= ucwords($row[0]) ?></td>
<td><?= $row[1] ?></td>
<td><?= $row[3] ?></td>
<td><?= $row[2] ?></td>
<td><?= $row[4] ?></td>
</tr>
	<?php
}
?>
</table>
</div>