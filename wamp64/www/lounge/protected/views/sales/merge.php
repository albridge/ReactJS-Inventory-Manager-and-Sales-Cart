<div style="display:block; overflow:auto; height:auto;">
<h1>Select Sales to Merge</h1>

<div style="display:inline-block; float:left; width:60%; height:auto; overflow:auto;">
<?php
foreach($sales as $doc)
{

echo CHtml::button($doc->transaction_id." : ".$doc->table_number." : ".ucwords(User::model()->findByPk($doc->staff)->username), array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin-bottom:5px;','onclick'=>'addup('.$doc->transaction_id.')'));
	
}

?>

</div>

<div style="display:inline-block; float:left; width:38%; min-height:300px; height:auto; overflow:auto; border:1px solid #ccc;">
<table class="table table-bordered table-striped">
<tr>
<td colspan="2">
Select Tables to Merge
</td>


</tr>


<tr>
<td id="singles" colspan="2">

</td>


</tr>
<tr>
<td></td>

<td><input type="hidden" id="orders"></td>
</tr>

<tr>
<td>
<input type="button" value="Do Merge" class="btn btn-success" style="margin:auto;" onclick="do_merge()">
</td>

<td>
<input type="button" value="Cancel" class="btn btn-danger" style="margin:auto;" onclick="do_clear()">
</td>
</tr>



</table>

	</div>


<div style="display:inline-block; float:left; width:60%; height:auto; overflow:auto;">
	&nbsp;
</div>



	<div style="display:inline-block; float:left; width:38%;  height:auto; overflow:auto; border:1px solid #ccc;">



	</div>

</div>