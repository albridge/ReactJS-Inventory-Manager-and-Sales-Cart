<h1>Yearly Sales</h1>

<ul class="nav nav-tabs">
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Sales Report'), array('reports')); ?> </li>
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Sales Summary'), array('reportsweekly')); ?> </li>
 
  <li role="presentation" class="active"><?php echo CHtml::link(CHtml::encode('Yearly Sales'), array('reportsyearly')); ?></li>   
</ul>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/reportsyearly'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

 <?php echo CHtml::dropDownList('Sales[year]','',array('2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027'),array('empty' => 'Select year','style'=>'margin-left:10px;')); ?> 
     
        
            <?php //echo $form->labelEx($model,'Supplier',array('style'=>'margin-left:-70px;')); ?>
  
 <?php //echo CHtml::dropDownList('Sales[item_name]','',CHtml::listData(suppliers::model()->findAll(), 'id', 'company_name'), array('style'=>'margin-left:10px;','empty'=>'')); ?> 
    <?php //echo $form->error($model,'item_name'); ?>



           <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>
        <?php //echo $form->error($model,'title'); ?>
        
         <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128)); ?>           
        
        
		<?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>
        
        
		<?php /*
        <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px;">
         <table border="1" style="width:100%;" class="table">
        <tr style="width:100%; background-color:#000; color:#fff;"><td>SN</td><td>Date</td><td>Item</td><td>Price</td><td>Transaction ID</td></tr>
         

         <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo substr($sale['created_at'],0,10); ?></td><td><?php echo ucwords($sale['item_name']); ?></td><td><?php echo $sale['unit_price']; ?></td><td><?php echo $sale['transaction_id']; ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td></td><td></td><td>TOTAL SALES</td><td><del>N</del><?php echo number_format($tsales,2); ?></td></tr>

          </table>
      </div>
*/ ?>

       <div style="display:block; width:auto; height:auto; overflow:auto; margin-top:50px;">
          <?php if($period!=null){?>
    <h4>Sales for <?php echo $period; ?> <?php if(!empty($sup)){ echo "for ".ucwords(suppliers::model()->find('id=:y',array(':y'=>$sup))->company_name); } ?></h4>
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
         'categories' => array('Sales','Returns','Net Sale')
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Naira')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
      array('name' => 'Sales', 'data' => array(round((double)$tsales,2), round((double)$returns,2),round((double)$netsale,2)))
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
    <h3>Fastest Moving Products <?php echo $period; ?> <?php if(!empty($sup)){ echo "for ".ucwords(suppliers::model()->find('id=:y',array(':y'=>$sup))->company_name); } ?></h3>
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
     
      array('name' => 'Sales', 'data' => array((int)$fastmoving[0]['nu'], (int)$fastmoving[1]['nu'], (int)$fastmoving[2]['nu'], (int)$fastmoving[3]['nu'], (int)$fastmoving[4]['nu'], (int)$fastmoving[5]['nu'], (int)$fastmoving[6]['nu'], (int)$fastmoving[7]['nu'], (int)$fastmoving[8]['nu'], (int)$fastmoving[9]['nu']))
      )
   )
));


}
?>
        </div>

<?php //var_dump($yearlyr); ?>

        <div style="display:block; width:auto; height:auto; margin-top:30px; overflow:auto;">
        <?php 

       /*
    if($monthly!=null){
    $mons=array(); $amts=array(); $adv=array();     
    foreach($monthly as $m){  array_push($mons,date('M', strtotime('2000-'.$m['month']))); }
    foreach($monthly as $m){ array_push($amts, (int)$m['amt']); }
    foreach($yearly as $m){ array_push($adv, (int)$m['ad']); }
}

    
  */   
//echo SUBSTR('2016-02-10',5,2);
  $mols=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $this->Widget('ext.highcharts.HighchartsWidget', array(
'scripts' => array(
      'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
      'modules/exporting', // adds Exporting button/menu to chart
     // 'themes/dark-unica'        // applies global 'grid' theme to all charts
    ),
   'options' => array(
   
   //'chart' => array('type' => 'bar'),
   'chart' => array('type' => 'line'),
    'credits' => array('enabled' => false),   
      'title' => array('text' => 'Sales for the year '.$period.(!empty($sup)) ? ucwords(Suppliers::model()->find('id=:y',array(':y'=>$sup))->company_name) : "none" ),
      'xAxis' => array(
        // 'categories' => array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')
     'categories' => $mols
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Naira')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
     /* array('name' => 'Sales / transactions', 'data' => array((int)$monthly[0]['amt'], (int)$monthly[1]['amt'], (int)$monthly[2]['amt'], (int)$monthly[3]['amt'], (int)$monthly[4]['amt'], (int)$monthly[5]['amt'], (int)$monthly[6]['amt'], (int)$monthly[7]['amt'], (int)$monthly[8]['amt'], (int)$monthly[9]['amt'], (int)$monthly[10]['amt'], (int)$monthly[11]['amt']))
      )*/
    
     
     array('name' => 'Sales', 'data' => array(round((double)$jan,2),round((double)$feb,2),round((double)$mar,2),round((double)$apr,2),round((double)$may,2),round((double)$jun,2),round((double)$jul,2),round((double)$aug,2),round((double)$sep,2),round((double)$oct,2),round((double)$nov,2),round((double)$dec,2))),
     // array('name' => 'Returns', 'data' => [round((double)$janr,2),round((double)$febr,2),round((double)$marr,2),round((double)$aprr,2),round((double)$mayr,2),round((double)$junr,2),round((double)$julr,2),round((double)$augr,2),round((double)$sepr,2),round((double)$octr,2),round((double)$novr,2),round((double)$decr,2)]),
    // array('name' => 'Netsale', 'data' => [round((double)$jannet,2),round((double)$febnet,2),round((double)$marnet,2),round((double)$aprnet,2),round((double)$maynet,2),round((double)$junnet,2),round((double)$julnet,2),round((double)$augnet,2),round((double)$sepnet,2),round((double)$octnet,2),round((double)$novnet,2),round((double)$decnet,2)]),
     
      )
   )
));


//var_dump($monthly);
?>
        </div>
        