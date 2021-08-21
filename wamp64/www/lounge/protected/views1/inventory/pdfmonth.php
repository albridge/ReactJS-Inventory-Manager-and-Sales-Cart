 <?php
 //$month=$_GET['Sales']['month']; $year=$_GET['Sales']['year'];
          //$val=$year."-".$month;
          //die();
         // $dyear=$_GET['Inventory']['created_at'];
      //$sql="select *from Sales where SUBSTR(created_at,1,7)='".$val."'";
      
    // $sales = Yii::app()->db->createCommand($sql)->queryAll();
     //var_dump($sales); die();
 $val=$vals;

          $criteria = new CDbCriteria();
           $criteria->select = 'sum(qty) as qty, item_name, unit_price';
           $criteria->group = 'item_name,unit_price';
/*
           if(!empty($sup)){
       $criteria->condition = 'SUBSTR(created_at,1,7) = :id and supplier=:k';
     
      // $criteria->order = 'id DESC';
       $criteria->params = array (':id'=>$val, ':k'=>$sup);  
       $company=suppliers::model()->find('id=:k',array(':k'=>$sup))->company_name;

        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."' and supplier='".$sup."'";
     }else{
*/
         $criteria->condition = 'SUBSTR(created_at,1,7) = :id';
     
      // $criteria->order = 'id DESC';
       $criteria->params = array (':id'=>$val);  

        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'";
   //  }

       $sales=Sales::model()->findAll($criteria);


       
     $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();     

       ?>




 <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px;">
  <?php echo $val; ?>
         <table border="0" style="width:100%;" class="table">
          <tr><td colspan="4">Sales Report for <?php echo date("M-Y",Strtotime($val)); ?> <?php if(!empty($sup)){ echo "for ". ucwords($company); }  ?></td></tr>
        <tr style="width:100%; font-weight:bold; text-transform:uppercase;"><td>SN</td><td>Item</td><td>Qty</td><td>Unit Price</td></tr>
         <tr><td colspan="4"><hr></td></tr>




         <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo ucwords($sale['item_name']); ?></td><td><?php echo $sale['qty']; ?></td><td><?php echo number_format($sale['unit_price'],2); ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td>TOTAL SALES</td><td><del>N</del><?php echo number_format((double)$sales_t,2); ?></td><td></td></tr>

          </table>

        </div>