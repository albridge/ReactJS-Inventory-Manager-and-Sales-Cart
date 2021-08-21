<h1>Sales Summary</h1>

<ul class="nav nav-tabs">
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Sales Report'), array('reports')); ?> </li>
  <li role="presentation" class="active"><?php echo CHtml::link(CHtml::encode('Sales Summary'), array('reportsweekly')); ?> </li>
  <li role="presentation" class=""><?php echo CHtml::link(CHtml::encode('Payments Analysis'), array('analysis')); ?> </li>
  
    
</ul>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/reportsweekly'),
  'enableAjaxValidation'=>false,
  'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>


<?php echo $form->labelEx($model,'Select dates',array('style'=>'margin-left:-50px;')); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Sales[date1]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-mm-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'from',
                 'autocomplete'=>'off',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'drop_date'); ?>
        
        
        
       
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Sales[date2]',
                                'id'=>'coldate1',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->created_at),
              
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
    <?php echo $form->error($model,'drop_date'); ?>
     <div>
   
    <?php if(Yii::app()->user->role=='admin' && Yii::app()->user->shop_id=='000') //Yii::app()->user->role=='store_admin' || Yii::app()->user->role=='accounts' && 
    {
      echo CHtml::dropDownList('Sales[shop]','', array('5000'=>'All')+CHtml::listData(Shops::model()->findAll('node_id!=:b',array(':b'=>'000')), 'node_id', 'name'), array('empty'=>'')); 
    } else{
      echo CHtml::hiddenField('Sales[shop]',Yii::app()->user->shop_id, array('empty'=>'')); 
    }
echo CHtml::dropDownList('Sales[staff]','', array('5000'=>'All')+CHtml::listData(User::model()->findAll('id!=:b',array(':b'=>'000')), 'id', 'username'), array('empty'=>'')); 
   ?>
  </div>


    <?php //echo $form->labelEx($model,'Supplier',array('style'=>'margin-left:-90px;')); ?>
    <?php //echo CHtml::dropDownList('Sales[item_name]','',CHtml::listData(suppliers::model()->findAll(), 'id', 'company_name'), array('style'=>'margin-left:10px;','empty'=>'')); ?> 
    <?php echo $form->error($model,'item_name'); ?>
        
           <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>
        <?php //echo $form->error($model,'title'); ?>
        
         <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128)); ?>           
        
        
    <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>
        
        
    
        <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px;" id="invoice">

           <?php if($date1!=null && $date2!=null){  ?>
    <h4>Sales for <?php echo date("d-M-Y",Strtotime($date1)); ?> to <?php echo date("d-M-Y",Strtotime($date2))." for ".ucwords(Shops::model()->find('node_id=:bb',array(':bb'=>$shop))->name); if($shop=='5000'){ echo 'All locations'; } ?> <?php if(!empty($sup)){ echo " [".ucwords($company)."]"; }  ?></h4>
    <?php } ?>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?php $pic=Config::model()->findByPk(1); ?>
    </div>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:10px;">
<?php $pic=Config::model()->findByPk(1); 
if(isset(Yii::app()->user->shop_id))
{
  $shoped=Shops::model()->findByPk(Yii::app()->user->shop_id);
}
echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px;")); ?>
    </div>
<span style="display:block; font-weight:bold; text-align:center; text-transform:uppercase; margin-top:0px;"><?php echo $pic->company_name; ?></span>


<span style="display:block; text-align:center; text-transform:capitalize;"><?php echo $pic->address; ?></span>
<span style="display:block;  text-align:center; text-transform:capitalize;">Tel: <?php echo $pic->phone1 ?></span>
    </div>
         <table style="width:100%;" class="table table-bordered table-striped">
        <tr style="text-transform:uppercase; font-weight:bold;">
          <td>SN</td><td>Code</td><td>product description</td><td>Qty sold</td></tr>
          
          

         <?php $sumo=0;
        if($sales!=null){ $i=0; //var_dump($sales); die;
foreach($sales as $sale){ $i++; //$sumo+=$sale['tendered'];

         ?>
       <tr >
        <td><?php echo $i; ?></td>
        <td><?php echo $sale['item_id']; ?></td>
        <td><?php echo ucwords($sale['item_name']); ?></td>
        <td><?php echo $sale['qty']; ?></td>
        <!--td><?php //echo $sale['unit_price'] ?></td> 
        <td><?php //echo number_format($sale['yum'],2); ?></td-->
      </tr>

        <?php
      }}
        ?>
         <tr style="color:#000; font-weight:bold;"><td></td><td></td><td>TOTAL SALES</td><td><del>N</del><?php echo number_format($dtotal,2); ?></td>  </tr>

          </table>
      </div>

       <div style="display:block; margin-top:30px;">

        <?php //echo CHtml::button('Print Report',
//     array(
//         'submit'=>array('Inventory/topdfweek'),
//       //  'confirm' => 'Are you sure you want to checkout?',
//         'class'=>'btn btn-primary',
//         'style'=>'display:inline-block; margin:0px;',
//        // 'onclick'=>'printit();'
//         //'condition'=>'period=:pe',
//         'params'=>array('date1'=>$date1,'date2'=>$date2,'sup'=>$sup)
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
    <h4>Sales for <?php echo date("d-M-Y",Strtotime($date1)); ?> to <?php echo date("d-M-Y",Strtotime($date2)); ?> <?php if(!empty($sup)){ echo " [".ucwords($company)."]"; }  ?></h4>
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
         'categories' => array('Sales','Returns','Netsale')
      ),    
    
      'yAxis' => array(
         'title' => array('text' => 'Naira')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
     
      array('name' => 'Sales', 'data' => array(round((double)$dtotal,2)))
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
    <h3>Fastest Moving Products <?php echo date("d-M-Y",Strtotime($date1)); ?> to <?php echo date("d-M-Y",Strtotime($date2)); ?> <?php if(!empty($sup)){ echo " [".ucwords($company)."]"; }  ?></h3>
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
        