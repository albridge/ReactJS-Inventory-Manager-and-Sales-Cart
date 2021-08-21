<script type="text/javascript">


function getnew()
{
	
	
	var id=$("#bard").val();
	if(id.length>5){
	//alert(id);
}
    $.post("<?php echo Yii::app()->createUrl('Inventory/getnew'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#newsupply").html(data);
    });

}



function getnew2()
{
  
  
  var id=$("#named").val();
  //if(id.length>5){  //alert(id);

    $.post("<?php echo Yii::app()->createUrl('Inventory/getnew2'); ?>",
      //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#newsupply").html(data);
    });
  //}

}




function doupdate()
{
	//alert('about to update');

	var id=$("#dpid").val();
	var qty=$("#dqty").val();

    $.post("<?php echo Yii::app()->createUrl('Inventory/updateinv'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        did: id,
        supply: qty
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#newsupply").html(data);
    });
}

window.onload = function() {
  document.getElementById("bard").focus();
};


function showname(id,name)
{
 // alert(name+id);

 // var id=$("#named").val();
  //if(id.length>5){  //alert(id);

    $.post("<?php echo Yii::app()->createUrl('Inventory/showname'); ?>",
      //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#newsupply").html(data);
    });
  //}
}

</script>

<H4>Enter New Supply</H4>

<div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:20px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'get',
 'action' => Yii::app()->createUrl('Inventory/reports'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;',
 'onsubmit'=>"return false;",/* Disable normal form submit */
		),
	'focus'=>array($model,'barcode'),

)); ?>

<?php echo $form->labelEx($model,'Enter Barcode'); ?>
		   <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128, 'id'=>'bard','onkeyup'=>'getnew()')); ?> 
		   <?php echo $form->textField($model,'barcode',array('size'=>60,'maxlength'=>200, 'id'=>'bard', 'onkeyup'=>'getnew()')); ?>   
		<?php echo $form->error($model,'barcode'); ?>


<?php echo $form->labelEx($model,'Enter Item Name'); ?>
           <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128, 'id'=>'bard','onkeyup'=>'getnew()')); ?> 
           <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200, 'id'=>'named', 'onkeyup'=>'getnew2()')); ?>   
        <?php echo $form->error($model,'name'); ?>


        
           <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>
        <?php //echo $form->error($model,'title'); ?>
        
         <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128)); ?>           
        
        
		
        
        
        <?php $this->endWidget(); ?>
        </div>




        <div style="display:block; width:100%; overflow:auto; height:auto; margin-bottom:10px;">
<?php $form=$this->beginWidget('CActiveForm', array(
'method'=>'post',
 'action' => Yii::app()->createUrl('Inventory/updateinv'),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-left:0px;',
		 'onsubmit'=>"return false;",/* Disable normal form submit */
                               //'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
		),

)); ?>

<span  id="newsupply" style="width:100%;"></span>


      
           <?php //echo $form->labelEx($model,'title'); ?>
        <?php //echo $form->dropDownList($model,'title',array('sales'=>'Sales','transactions'=>'Transactions'),array('empty' => '','style'=>'margin-left:0px;')); ?>
        <?php //echo $form->error($model,'title'); ?>
        
         <?php //echo CHtml::textField('Jobs[transaction]', '', array('size'=>60,'maxlength'=>128)); ?>           
        
        
		
        
        
        <?php $this->endWidget(); ?>
        </div>

        