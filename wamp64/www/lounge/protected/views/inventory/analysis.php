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
  <li role="presentation" ><?php echo CHtml::link(CHtml::encode('Sales Report'), array('reports')); ?> </li>
  <li role="presentation"><?php echo CHtml::link(CHtml::encode('Sales Summary'), array('reportsweekly')); ?> </li>
   <li role="presentation" class="active"><?php echo CHtml::link(CHtml::encode('Payments Analysis'), array('analysis')); ?> </li>
 
   
</ul>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/analysis'),
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
      


   ?>
  </div>

        
    <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
        
        <?php $this->endWidget(); ?>
        </div>
        
        
  
      <div style="width:100%; height:auto; overflow:auto; display:block; margin-top:50px; margin-bottom:20px;" id="invoice">
            <?php if($period!=null){?>
    <h4>Payments Analysis for period between <?php echo date("d-M-Y",Strtotime($period)); ?> and <?php echo date("d-M-Y",Strtotime($period2))." for ".ucwords(User::model()->find('id=:j',array(':j'=>$shop))->username); if($shop=='5000'){ echo 'Everyone'; } ?>  </h4>
<div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
  <table class="table table-striped table-bordered">
    <tr>
<td>Payment Type</td>
<td>Amount Paid</td>
    </tr>
<?php
    foreach($sales as $sale)
{
  ?>
  <tr>
    <td>
  <?= strtoupper($sale['payment_type']) ?>
</td>
<td><?= number_format($sale['amount_paid'],2) ?></td>
</tr>
<?php
}
    } ?>

    </table>
     

    </div>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:10px;">
<?php $pic=Config::model()->findByPk(1); 


  
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


      
       

        