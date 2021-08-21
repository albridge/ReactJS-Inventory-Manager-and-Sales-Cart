<h1>Close Sale</h1>

<div>
<?php
foreach($doctors as $doc)
{
	//echo CHtml::button($doc->transaction_id." : ".$doc->table_number." : ".ucwords(User::model()->findByPk($doc->staff)->username), array('class'=>'btn btn-primary'));

  if($doc->print==1){
	echo CHtml::button('Close Sale '.$doc->transaction_id." : ".$doc->table_number." : ".ucwords(User::model()->findByPk($doc->staff)->username),
    array(
        'submit'=>array('inventory/forclose'),
       //'confirm' => 'Close this Sale?',
        'class'=>'btn btn-warning',
        'style'=>'display:inline-block; margin:0px; font-size:2em; padding:10px; margin-bottom:5px;',
       // 'onclick'=>'printa();'
        'params'=>array('id'=>$doc->transaction_id)
    )
 );
}else{
  echo CHtml::button('Close Sale '.$doc->transaction_id." : ".$doc->table_number." : ".ucwords(User::model()->findByPk($doc->staff)->username),
    array(
        'submit'=>array('inventory/forclose'),
       //'confirm' => 'Close this Sale?',
        'class'=>'btn btn-danger',
        'style'=>'display:inline-block; margin:0px; font-size:2em; padding:10px; margin-bottom:5px;',
       // 'onclick'=>'printa();'
        'params'=>array('id'=>$doc->transaction_id)
    )
 );
}
	?>


	<?php
}

?>

</div>