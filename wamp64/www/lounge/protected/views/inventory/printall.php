<?php



  $sql="select *from inventory";
  $sales_sql="select sum(price*quantity) from inventory";
    

			//$sql="select *from Sales where created_at='".$dyear."'";
		 	$sales = Yii::app()->db->createCommand($sql)->queryAll();
		 	//var_dump($sales); die();

		 	  $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();




		 	?>



		 	 <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px;">
         <table border="0" cellpadding="1" cellspacing="1" style="width:100%;" class="table">
         	 <tr><td colspan="4">Store Inventory as of <?php echo date("d-M-Y",time()); ?> </td></tr>
        <tr style="width:100%;"><td>SN</td><td>Item</td><td>Qty</td><td>Unit Price</td></tr>
          
          <tr><td colspan="4"><hr></td></tr>

         <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo ucwords($sale['name']); ?></td><td><?php echo $sale['quantity']; ?></td><td><?php echo number_format($sale['price'],2); ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td>TOTAL STOCK VALUE</td><td><del>N</del><?php echo number_format($sales_t,2); ?></td></tr>

          </table>
      </div>

