<h1>Stock Bin for <?= ucwords($records[0]['product_name']) ?></h1>

<div>

<table class="table table-bordered table-striped">
<tr style="font-weight:bold; text-transform:uppercase;">
<td>Date</td>
<td>RECEIPTS</td>
<td>issues</td>
<td>balance</td>
</tr>

<?php
foreach($records as $record)
{ $tot+=$record['received']-$record['issued'];
	?>

	<tr>
<td><?= date('jS F Y',strtotime($record['created_at'])) ?></td>
<td><?= $record['received'] ?></td>
<td><?= $record['issued'] ?></td>
<td><?= $tot; ?></td>
</tr>

	<?php
}
?>
</table>
</div>