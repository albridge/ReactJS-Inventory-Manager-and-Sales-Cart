<?php

$date1=$d1;
			$date2=$d2;
if(!empty($sup)){
$sql="select *from Sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."'  and supplier='".$sup."'";
 $company=suppliers::model()->find('id=:k',array(':k'=>$sup))->company_name;

 $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."'  and supplier='".$sup."'";
    
}else{
  $sql="select *from Sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' ";
  $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."'";
    
}
			//$sql="select *from Sales where created_at='".$dyear."'";
		 	$sales = Yii::app()->db->createCommand($sql)->queryAll();
		 	//var_dump($sales); die();

		 	  $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();




		 	?>



		 	 <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px;">
         <table border="0" cellpadding="1" cellspacing="1" style="width:100%;" class="table">
         	 <tr><td colspan="6">Sales Report from <?php echo date("d-M-Y",Strtotime($date1)); ?> to <?php echo date("d-M-Y",Strtotime($date2)); ?><?php if(!empty($sup)){ echo " [".ucwords($company)."]"; }  ?></td></tr>
        <tr style="width:100%;"><td>SN</td><td>Date</td><td>Item</td><td>Qty</td><td>Unit Price</td><td>Transaction ID</td></tr>
          
          <tr><td colspan="6"><hr></td></tr>

         <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo date("d-M-Y",Strtotime(substr($sale['created_at'],0,10))); ?></td><td><?php echo ucwords($sale['item_name']); ?></td><td><?php echo $sale['qty']; ?></td><td><?php echo number_format($sale['unit_price'],2); ?></td><td><?php echo $sale['transaction_id']; ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td></td><td></td><td>TOTAL SALES</td><td><del>N</del><?php echo number_format($sales_t,2); ?></td></tr>

          </table>
      </div>

