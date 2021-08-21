<h1>Receive Stock by Days</h1>

<div>
	<div id="loading" style="display:none;"><?= CHtml::image(Yii::app()->baseUrl . "/loader/loader11.gif","",array("style"=>"")); ?></div>
<table class="table table-bordered table-striped">
<tr>
<td>Date</td>
</tr>

<?php
foreach($model as $mod)
{
	?>
 <tr>
<td><?= CHtml::link(date('jS F Y',strtotime($mod['created_at'])),array('inventory/see_days_details','date'=>$mod['created_at'])) ?></td>
 </tr>
	<?php
}
?>

</table>
</div>