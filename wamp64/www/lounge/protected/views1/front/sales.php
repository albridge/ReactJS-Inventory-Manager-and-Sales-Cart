<h1>Sales</h1>

<div>
<?php
foreach($doctors as $doc)
{
	echo CHtml::link($doc->transaction_id." : ".$doc->table_number." : ".ucwords(User::model()->findByPk($doc->staff)->username), Yii::app()->createUrl('inventory/recent',array('id'=>$doc->transaction_id,'table'=>$doc->table_number)),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin-bottom:5px;'));
	?>


	<?php
}

?>

</div>