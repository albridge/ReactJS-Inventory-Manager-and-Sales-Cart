<style type="text/css">
.pages{list-style: none;}
.pages li{background-color: #000; color: #fff; display: inline-block; padding: 5px; border-radius: 5px;}

.pages li a:link{color:#fff; padding: 5px;}
.pages li a:visited{color:#fff; padding: 5px;}
.pages li a:hover{background-color:blue; padding: 5px;}
.pages li a:active{background-color: red; padding: 5px;}
</style>

<h1>Sales Report</h1>

<ul class="nav nav-tabs">
  <li role="presentation" class="active"><?php echo CHtml::link(CHtml::encode('Sales Report'), array('reports')); ?> </li>
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Sales Summary'), array('reportsweekly')); ?> </li>
  <li role="presentation" class=""><?php echo CHtml::link(CHtml::encode('Payments Analysis'), array('analysis')); ?> </li>
 
   
</ul>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/reports'),
  'enableAjaxValidation'=>false,
  'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

<?php echo $form->labelEx($model,'Select Date'); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Inventory[date1]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-mm-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'Choose date',
                 'autocomplete'=>'off',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'created_at'); ?>

     <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Inventory[date2]',
                                'id'=>'coldate1',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->updated_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'to',
                 'autocomplete'=>'off',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'updated_at'); ?>

    <div>
   
    <?php if(Yii::app()->user->role=='admin' && Yii::app()->user->shop_id=='000') //|| Yii::app()->user->role=='store_admin' || Yii::app()->user->role=='accounts' && Yii::app()->user->shop_id==1
    {
      echo CHtml::dropDownList('Inventory[shop]',null, array('5000'=>'All')+CHtml::listData(Shops::model()->findAll('node_id!=:jj',array(':jj'=>'000')), 'node_id', 'name'), array('empty'=>'')); 

    } else{
      echo CHtml::hiddenField('Inventory[shop]',Yii::app()->user->shop_id, array('empty'=>'')); 
    }

     echo CHtml::dropDownList('Inventory[staff]',null, array('5000'=>'All')+CHtml::listData(User::model()->findAll(), 'id', 'username'), array('empty'=>'')); 
       echo CHtml::dropDownList('Inventory[ptype]',null, array(''=>'All','cash'=>'cash','pos'=>'pos','transfer'=>'transfer'), array('empty'=>'')); 


   ?>
  </div>

        
    <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>
        
        
  
      <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px; margin-bottom:20px;" id="invoice">
            <?php if($period!=null){?>
    <h4>Results for period between <?php echo date("d-M-Y",Strtotime($period)); ?> and <?php echo date("d-M-Y",Strtotime($period2))." for ".ucwords(User::model()->find('id=:j',array(':j'=>$shop))->username); if($shop=='5000'){ echo 'Everyone'; } ?>  </h4>
    <?php } ?>
     <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?php  ?>
    </div>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:10px;">
<?php $pic=Config::model()->findByPk(1); 
if(isset(Yii::app()->user->shop_id))
{
  $shoped=Shops::model()->findByPk(Yii::app()->user->shop_id);
}
echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px;")); ?>
   
<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase; margin-top:0px;"><?php echo $pic->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $pic->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $pic->phone1 ?></span>
    </div>
        <table style="width:100%;" class="table table-bordered table-striped">
       
        <?php
        $total_sales=0;
        $marg=0;
        $total_vat=0;
        if($sales!=null){ $i=0; //var_dump($sales); die;
foreach($sales as $sale){ $i++;
  $total_sales+= $sale['amount_paid'];
         ?>
          <tr style="font-weight:bold; text-transform:uppercase;">
          <td>Transaction Details</td><td>Qty Sold</td><td>Cost Price</td> <td>Selling Price</td><td>Margin</td><td>Sales Amount</td><td>Amount Paid</td><td>Discount</td><td>VAT</td> </tr>
       <tr>
        <td style="font-weight:bold;"><?php echo 'INVOICE '.$sale['transaction_id'].' <br> Customer: '.Customers::getCustomer($sale['customer_id']).'<br> Sales Rep: '.ucwords(User::model()->findByPk($sale['staff'])->username).' - ('.$sale['staff'].') <br> Table: '.$sale['table_number'].' <br> Payment: '.ucfirst($sale['payment_type']).'<br>View Invoice: '.CHtml::link('View Invoice', array('Inventory/recent','id'=>$sale['transaction_id'])) ?></td>
     
        
        <td></td>
         <td></td>
        <td></td>
         <td></td>
         <td><?php echo number_format($sale['total'],2); ?></td>       
        <td><?php echo number_format($sale['tendered'],2); ?></td>
         <td><?php // $sale['discount'] ?></td>
         <td><del>N</del> <?php $vat=($sale['tendered']*5)/100; $total_vat+=$vat; echo number_format($vat,2) ?></td>
      </tr>
<?php  $item=Sales::model()->findAll('transaction_id=:hu',array(':hu'=>$sale['transaction_id'])); ?>
<?php foreach($item as $ite){
if(!empty($ite['unit_price']) && !empty($ite['supply_price'])) { $marg+=$ite['unit_price']-$ite['supply_price']; }
 ?>
          <tr style="color:#000;">
        <td><?= ucwords($ite['item_name'].'<br>Product Code: '.$ite['id']) ?></td>
     
        
        <td><?php echo $ite['qty']; ?></td>
         <td><?php echo $ite['supply_price']; ?></td>
        <td><?php echo $ite['unit_price']; ?></td>
         <td><?php if(!empty($ite['unit_price']) && !empty($ite['supply_price'])) { echo number_format(($ite['unit_price']-$ite['supply_price']),2); } ?></td>
         <td></td>       
        <td></td>
         <td><?= $ite['discount'] ?></td>
         <td><?= date('jS F Y H:i:s A',strtotime($ite['created_at'])) ?></td>
      </tr>
      <?php } ?>

        <?php
      }

     

    }
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><TD></TD><td></td><td>TOTAL SALES</td><td><?= number_format($marg,2) ?> </td><td></td>
          <td><del>N</del><?php echo number_format($total_sales,2); ?></td>
          <td></td><td><del>N</del> <?= number_format($total_vat,2) ?></td> </tr>
<tr><td colspan="8">You had <?php echo count($cust); ?> transactions in this period</td><td></td></tr>
          </table>

          <?php
          // the pagination widget with some options to mess
//           if($sales!=null){
// $this->widget('CLinkPager', array(
//             'currentPage'=>$pages->getCurrentPage(),
//             'itemCount'=>$item_count,
//             'pageSize'=>$page_size,
//             'maxButtonCount'=>5,
//             //'nextPageLabel'=>'My text >',
//             'header'=>'',
//         //'htmlOptions'=>array('class'=>'pages'),
//         ));
// }
?>
      </div>
 </div>

     <div style="display:block; margin-top:30px;">

        <?php //echo CHtml::button('Print Report',
//     array(
//         'submit'=>array('Inventory/topdf'),
//       //  'confirm' => 'Are you sure you want to checkout?',
//         'class'=>'btn btn-primary',
//         'style'=>'display:inline-block; margin:0px;',
//        // 'onclick'=>'printit();'
//         //'condition'=>'period=:pe',
//         'params'=>array('period'=>$period,'sup'=>$sup)
//     )
// ); ?>

<?php echo CHtml::button('Print Preview',
    array(
       // 'submit'=>array('Inventory/checkout2'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
        'onclick'=>'print();'
        // or you can use 'params'=>array('id'=>$id)
    )
); ?>

      </div>


       <div style="display:block; width:auto; height:auto; overflow:auto; margin-top:50px;">
          <?php if($period!=null){?>
    <h4>Sales for period between <?php echo date("d-M-Y",Strtotime($period)).' and '.date("d-M-Y",Strtotime($period2)); ?> <?php if(!empty($company)){ echo "for ". ucwords($company); } ?> </h4>
    <?php } ?>
        <?php
        $this->Widget('ext.highcharts.HighchartsWidget', array(
'scripts' => array(
      'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
      'modules/exporting', // adds Exporting button/menu to chart
     // 'themes/dark-unica'        // applies global 'grid' theme to all charts
    ),
   'options' => array(
   
   //'chart' => array('type' => 'bar'),
   'chart' => array('type' => 'column'),
    'credits' => array('enabled' => false),   
      'title' => array('text' => 'Sales'),
      'xAxis' => array(
         'categories' => array('Sales')
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Naira')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
      array('name' => 'Sales', 'data' => array(round((double)$total_sales,2)))
      )
   )
));



?>


<?php

if($model != null){
//$monthNum  = $month;
//$dateObj   = DateTime::createFromFormat('!m', $monthNum);
//$monthName = $dateObj->format('F'); // March

?>
  <?php if($period!=null){?>
    <h3>Fastest Moving Products for period between <?php echo date("d-M-Y",Strtotime($period)).' and '.date("d-M-Y",Strtotime($period2)); ?> <?php if(!empty($company)){ echo "for ". ucwords($company); } ?></h3>
    <?php } ?>


<?php
$nos=array();

//foreach($model as $no){ array_push($nos, (int)$no['nu']); } 
//var_dump($nos); die;
//for($x=0; $x<count($model['nu']); $x++){  array_push($nos, (int)$model[$x]['nu']); }

$this->Widget('ext.highcharts.HighchartsWidget', array(
'scripts' => array(
      'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
      'modules/exporting', // adds Exporting button/menu to chart
     // 'themes/dark-unica'        // applies global 'grid' theme to all charts
    ),
   'options' => array(
   
   //'chart' => array('type' => 'bar'),
   'chart' => array('type' => 'column'),
    'credits' => array('enabled' => false),   
      'title' => array('text' => 'Product Frequency'),
      'xAxis' => array(
         'categories' => array(ucwords($fastmoving[0]['item_name']), ucwords($fastmoving[1]['item_name']), ucwords($fastmoving[2]['item_name']),  ucwords($fastmoving[3]['item_name']),  ucwords($fastmoving[4]['item_name']), ucwords($fastmoving[5]['item_name']), ucwords($fastmoving[6]['item_name']), ucwords($fastmoving[7]['item_name']), ucwords($fastmoving[8]['item_name']), ucwords($fastmoving[9]['item_name']))
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Fastest moving products')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
      array('name' => 'Sales', 'data' => array((int)$fastmoving[0]['nu']-(int)$fastmovingr[0]['nu'], (int)$fastmoving[1]['nu']-(int)$fastmovingr[1]['nu'], (int)$fastmoving[2]['nu']-(int)$fastmovingr[2]['nu'], (int)$fastmoving[3]['nu']-(int)$fastmovingr[3]['nu'], (int)$fastmoving[4]['nu']-(int)$fastmovingr[4]['nu'], (int)$fastmoving[5]['nu']-(int)$fastmovingr[5]['nu'], (int)$fastmoving[6]['nu']-(int)$fastmovingr[6]['nu'], (int)$fastmoving[7]['nu']-(int)$fastmovingr[7]['nu'], (int)$fastmoving[8]['nu']-(int)$fastmovingr[8]['nu'], (int)$fastmoving[9]['nu']-(int)$fastmovingr[9]['nu']))
      )
   )
));


}
?>



        </div>
       

        