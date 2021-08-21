
<h1>Monthly Sales</h1>


<ul class="nav nav-tabs">
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Daily Sales'), array('reports')); ?> </li>
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Weekly Sales'), array('reportsweekly')); ?> </li>
  <li role="presentation" class="active"><?php echo CHtml::link(CHtml::encode('Monthly Sales'), array('reportsmonthly')); ?></li>
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Yearly Sales'), array('reportsyearly')); ?></li>   
</ul>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/reportsmonthly'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

<?php echo CHtml::dropDownList('Sales[month]','',array('01'=>'January','02'=>'Feburary','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'),array('empty' => 'Select month','style'=>'margin-left:10px;')); ?> 
     
       
         <?php echo CHtml::dropDownList('Sales[year]','',array('2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027'),array('empty' => 'Select year','style'=>'margin-left:10px;')); ?> 
        
        
         <?php //echo $form->labelEx($model,'Supplier',array('style'=>'margin-left:-70px;')); ?>
     <?php //echo CHtml::dropDownList('Sales[item_name]','',CHtml::listData(suppliers::model()->findAll(), 'id', 'company_name'), array('style'=>'margin-left:10px;','empty'=>'')); ?> 
    <?php //echo $form->error($model,'item_name'); ?>
        
		<?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>
        
        
		
        <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:30px;">

          <?php if($period!=null){?>
    <h3>Sales for <?php echo date("M-Y",Strtotime($period)); ?> <?php if(!empty($sup)){ echo "for ".ucwords(suppliers::model()->find('id=:u',array(':u'=>$sup))->company_name); } ?></h3>
    <?php } ?>

         <table border="1" style="width:100%;" class="table">
        <tr style="width:100%; background-color:#000; color:#fff;"><td>SN</td><td>Item</td><td>Qty</td><td>Unit Price</td></tr>




         <?php
        if($sales!=null){ $i=0;
foreach($sales as $sale){ $i++;
         ?>
       <tr style="color:#000;"><td><?php echo $i; ?></td><td><?php echo ucwords($sale['item_name']); ?></td><td><?php echo $sale['qty']; ?></td><td><?php echo $sale['unit_price']; ?></td></tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td>TOTAL SALES</td><td><del>N</del><?php echo number_format((double)$tsales,2); ?></td> <td></td> <td><?php //echo number_format($inv_c,2); ?></td></tr>

          </table>
<?php if($sales!=null){
          $this->widget('CLinkPager', array(
            'currentPage'=>$pages->getCurrentPage(),
            'itemCount'=>$item_count,
            'pageSize'=>$page_size,
            'maxButtonCount'=>5,
            //'nextPageLabel'=>'My text >',
            'header'=>'',
        //'htmlOptions'=>array('class'=>'pages'),
        ));
        }
?>

      </div>

       <div style="display:block; margin-top:30px;">

        <?php echo CHtml::button('Print Report',
    array(
        'submit'=>array('Inventory/topdfmonth'),
      //  'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'display:inline-block; margin:0px;',
       // 'onclick'=>'printit();'
        //'condition'=>'period=:pe',
        'params'=>array('period'=>$period,'sup'=>$sup)
    )
); ?>

      </div>

<?php //echo $returns; ?>
       <div style="display:block; width:auto; height:auto; overflow:auto; margin-top:50px;">
          <?php if($period!=null){?>
    <h4>Sales for <?php echo date("M-Y",Strtotime($period)); ?></h4>
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
     
      array('name' => 'Sales', 'data' => array(round((double)$tsales,2)))
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
    <h3>Fastest Moving Products <?php echo date("M-Y",Strtotime($period)); ?></h3>
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



<?php

if($model != null){
//$monthNum  = $month;
//$dateObj   = DateTime::createFromFormat('!m', $monthNum);
//$monthName = $dateObj->format('F'); // March

?>
  <?php if($period!=null){?>
    <h3>Slowest Moving Products <?php echo date("M-Y",Strtotime($period)); ?></h3>
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
         'categories' => array(ucwords($slowmoving[0]['item_name']), ucwords($slowmoving[1]['item_name']), ucwords($slowmoving[2]['item_name']),  ucwords($slowmoving[3]['item_name']),  ucwords($slowmoving[4]['item_name']), ucwords($slowmoving[5]['item_name']), ucwords($slowmoving[6]['item_name']), ucwords($slowmoving[7]['item_name']), ucwords($slowmoving[8]['item_name']), ucwords($slowmoving[9]['item_name']))
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Slowest moving products')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
      array('name' => 'Sales', 'data' => array((int)$slowmoving[0]['nu'], (int)$slowmoving[1]['nu'], (int)$slowmoving[2]['nu'], (int)$slowmoving[3]['nu'], (int)$slowmoving[4]['nu'], (int)$slowmoving[5]['nu'], (int)$slowmoving[6]['nu'], (int)$slowmoving[7]['nu'], (int)$slowmoving[8]['nu'], (int)$slowmoving[9]['nu']))
      )
   )
));


}
?>
        </div>

        <div style="display:block; margin-top:30px;">
 <a href="<?php echo $_SERVER['REQUEST_URI'];  ?>&export" class="btn btn-success" target="_blank">Export Fastest Products List</a>
</div>


        