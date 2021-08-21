<?php
 $dyear=$years;

			$criteria = new CDbCriteria();
      if(!empty($sup)){
       $criteria->condition = 'SUBSTR(created_at,1,10) = :id and supplier=:h';
      // $criteria->order = 'id DESC';
      // $criteria->where='saletype=1'; 
       $criteria->params = array (':id'=>$dyear, ':h'=>$sup);

       $company=suppliers::model()->find('id=:k',array(':k'=>$sup))->company_name;

        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."' and supplier='".$sup."'";
     }else{

       $criteria->condition = 'SUBSTR(created_at,1,10) = :id';
      // $criteria->order = 'id DESC';
      // $criteria->where='saletype=1'; 
       $criteria->params = array (':id'=>$dyear);

        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."'";
     }
       $sales=Sales::model()->findAll($criteria);


       
		 $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();


?>


 <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:0px;">
            
            
        <table border="0" style="width:100%; color:#000;" class="table">
          <tr><td colspan="7">Sales Report for <?php echo date("d-M-Y",Strtotime($dyear)); ?> <?php if(!empty($sup)){ echo "for ". ucwords($company); }  ?></td></tr>
        <tr style="width:100%; text-transform:uppercase; font-weight:bold;;"><td>SN</td><td>Date</td><td>Item</td><td>Qty</td><td>Unit Price</td><td>Record Type</td><td>Transaction ID</td></tr>
        <tr><td colspan="7"><hr></td></tr>

        <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo date("d-M-Y",Strtotime(substr($sale['created_at'],0,10))); ?></td><td><?php echo ucwords($sale['item_name']); ?></td><td><?php echo $sale['qty']; ?></td><td><?php echo number_format($sale['unit_price'],2); ?></td><td>sale</td><td><?php echo $sale['transaction_id']; ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td></td><td></td><td>TOTAL SALES</td><td><del>N</del><?php echo number_format($sales_t,2); ?></td></tr>

          </table>
          </div>