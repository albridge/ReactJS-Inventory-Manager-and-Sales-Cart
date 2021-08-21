<h1>Receive Stock by Days details</h1>

			<div  id="go_issues">
	<table class="table table-bordered table-striped">
		<tr style="text-transform:uppercase; font-weight:bold;">
		<td>Item Name</td>
		<td>Quantity Issued</td>
		<td>Issue Date</td>
		<?php
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin')
		{
			?>
			<td>Branch</td>
			<?php
		}
		?>
		<td>Action</td>
		</tr>
			

		<?php
		if($model!=null)
		{
			
			foreach($model as $mod){
				?>
				<tr>
		<td><?= ucwords(Inventory::model()->findByPk($mod['item_id'])->name) ?></td>
		<td><?= $mod['quantity'] ?></td>
		<td><?= date('jS F Y',strtotime($mod['created_at'])) ?></td>
		<?php
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin')
		{
			?>
			<td><?= ucwords(Shops::model()->findByPk($mod['shop_id'])->name) ?></td>
			<?php
		}
		?>
		<td>
		
		<?php
			if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin' && Yii::app()->user->shop_id==1)
			{
				?>	
				<input type="button" class="btn btn-primary recs" value="Receive" onclick="receive_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">		
				<input type="button" class="btn btn-danger recs" value="Cancel" onclick="cancel_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">
				<?php
			}else{
				?>
				<input type="button" class="btn btn-primary recs" value="Receive" onclick="receive_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">
				<?php
			}
		?>
		</td>
		</tr>

			<?php
		}
		}
		?>
		</table>
		</div>