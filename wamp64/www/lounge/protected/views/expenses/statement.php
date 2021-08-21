<h1>Income Statement</h1>



<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:50px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Expenses/statement'),
  'enableAjaxValidation'=>false,
  'htmlOptions'=>array('style'=>'margin-left:0px;'),

)); ?>

<?php echo $form->labelEx($model,'Select dates',array('style'=>'margin-left:-30px;')); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Expenses[date1]',
                                'id'=>'coldate',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->created_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'from',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'created_at'); ?>
        
        
        
       
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name'=>'Expenses[date2]',
                                'id'=>'coldate1',
                            'value'=>Yii::app()->dateFormatter->format("y-MM-dd",$model->updated_at),
              
                                'options'=>array(
                                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                                ),
                                'htmlOptions'=>array(
                               'style'=>'margin-left:10px;',
                 'placeholder'=>'to',
                                ),
                        ));  ?>
    <?php echo $form->error($model,'updated_at'); ?>
        
        
        
        <?php echo CHtml::submitButton('Show me', array('style'=>' margin-left:10px;')); ?>
        
          <?php $this->endWidget(); ?>
</div>


<div id="invoice">

	 <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:80px;height:auto; border-radius:5px;")); ?>
    </div>
    <div style="display:block; margin:auto; text-align:center; margin-bottom:20px;">
<?= $pic->address ?><br>
<?= $pic->phone1 ?>
    </div>
  <?php
  if($income!=null || $expense!=null){
   $d1=date('jS M Y',strtotime($date1));
   $d2=date('jS M Y',strtotime($date2));
echo '<h4>Income & Statement Covering Period between '.$d1.' to '.$d2.'</h4>';
   ?>
 <table class="table table-striped table-bordered">
  <tr>
<td colspan="2" style="font-weight:bold; text-transform:uppercase; font-size:24px;">Income</td>
  </tr>
<!--tr>
  <td>Transaction Type</td>
  
<td>Income</td><td>Description</td>
<td>Date</td>
</tr -->
<?php 
$tot_income=0;
foreach($income_details as $inc)
{
  $tot_income+=$inc['amount_paid'];
  ?>
<tr>
<td><?php echo $inc['item_name'] ?></td>

<td><del>N</del> <?php echo number_format($inc['amount_paid'],2); ?></td>
<td><?= $inc['qty'] ?></td>
<!-- td><?php //echo ucwords($inc['description']); ?></td>
<td><?php //echo date('d M Y',strtotime($inc['transaction_date'])); ?></td -->
</tr>

  <?php
}
?>

<tr>
  <td></td>

<td style="border-top:2px solid #000; border-bottom:2px solid #000;"><del>N</del> <?php echo number_format($tot_income,2); ?></td>

</tr>

  <tr>
<td colspan="2" style="font-weight:bold; text-transform:uppercase;  font-size:24px;">Expenditure</td>
  </tr>

  <?php 
$tot_expense=0;
foreach($expense_details as $inc2)
{
  $tot_expense+=$inc2['amount'];
  ?>
<tr>
<td><?php echo ucwords(ExpenseType::model()->find('id=:p',array(':p'=>$inc2['expense_type']))->expense_name); ?></td>

<td><del>N</del> <?php echo number_format($inc2['amount'],2); ?></td>
<!-- td><?php //echo ucwords($inc2['description']); ?></td>
<td><?php //echo date('d M Y',strtotime($inc2['date_paid_out'])); ?></td -->
</tr>

  <?php
}
?>

<tr>
  <td></td>

<td style="border-top:2px solid #000; border-bottom:2px solid #000;"><del>N</del> <?php echo number_format($tot_expense,2); ?></td>

</tr>

<tr>
 

<td colspan="2" style="">&nbsp;</td>

</tr>

<?php
if($tot_income>$tot_expense)
{
  ?>
<tr style="font-weight:bold; text-transform:uppercase;">
  <td>Total Income Less Expenses</td>

<td style="border-top:2px solid #000; border-bottom:8px double #000; border-bottom-style:double;"><del>N</del> <?php echo number_format($tot_income-$tot_expense,2); ?></td>

</tr>
  <?php
}else{
?>

<tr style="font-weight:bold; text-transform:uppercase;">
  <td>Total Loss</td>

<td style="border-top:2px solid #000; border-bottom:2px solid #000;"><del>N</del> <?php echo number_format($tot_expense-$tot_income,2); ?></td>
 
</tr>
<?php } ?>

 </table>


</div>

<div>
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


<div id="graph" style="display:block; overflow:auto; width:auto; height:auto;">
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
      'title' => array('text' => 'Income / Expense between '.$d1.' to '.$d2),
      'xAxis' => array(
         'categories' => array('Income','Expenditure')
      ),	  
	  
      'yAxis' => array(
         'title' => array('text' => 'Naira')
      ),
      'series' => array(
        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
         //array('name' => 'Visits', 'data' => $ben)
		  array('name' => 'Outstanding Balances', 'data' => array((int)$notpaid)),
		  array('name' => 'Expenses', 'data' => array((int)$expense)),
		  array('name' => 'Income', 'data' => array((int)$tot_income))
      )
   )
));



	
	
}
?>


</div>
 
		
       
		
     
