<script type="text/javascript">
function loadita()
{
alert('var');	
}


function long(){
//alert($("#mi").val());
var bar=$("#item").val();
if(bar.length>0){
$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('front/long'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#done").html('');
        $("#things").html(data);
        $("#loading").hide();
    });

   // $("#mi").val('');
    $("#item").focus();
}else{
    $("#things").html('');  
}
}

function zoom(f){
//alert($("#mi").val());
var bar=f;

$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('front/zoom'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#things").html('');
       $("#vibes").html(data);
         $("#item").val('');
        $("#loading").hide();
    });

    // $("#mi").val('');
    // $("#mi").focus();

   




}
</script>

<h1>Single Sell</h1>

<div>

<div id="things" style="display:block; margin-bottom:20px;">

</div>
<div>
<input name="item" id="item" onkeyup="long()" class="form-control" style="display:block; margin:auto; margin-bottom:30px;">
</div>



<div id="vibes">

<?php
$positions = Yii::app()->shoppingCart->getPositions();
?>
<table class="table table-bordered table-striped">
<tr><td></td><td>Item Name</td><td>Price</td> <td>Qty</td><td>Sub Total</td></tr>
<?php
foreach($positions as $position)
{
    ?>

<tr><td><?php echo CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:180px;height:auto; border-radius:5px; border:1px solid #333; text-align:center; margin:auto;")); ?></td>
    <td><?= ucwords($position->name) ?></td>
    <td><?=  number_format($position->getPrice(),2) ?></td> 
    <td><input type="text" value="<?= $position->getQuantity() ?>" style="width:30px;" onkeyup="update_cart3_rest('<?php  echo $position->id; ?>');" id="<?php  echo $position->id;  ?>count"></td>
    <td id="<?= $position->id ?>costa"><?= number_format($position->getQuantity()*$position->getPrice(),2) ?></td>
</tr>

    <?php
}

?>
  <tr><td colspan="4"></td><td id="tot"><?= number_format(Yii::app()->shoppingCart->getCost(),2) ?></td></tr> 
<?php //if(empty(Yii::app()->session['table'])){ ?>
<tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::dropDownList('Sales[table]','',array_combine(range(1,50),range(1,50)), array('style'=>'margin-left:10px;','empty'=>'','id'=>'table')); ?> </td></tr>
<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::dropDownList('Sales[ptype]','',array('cash'=>'Cash','pos'=>'Pos','transfer'=>'Transfer'), array('style'=>'margin-left:10px;','empty'=>'','id'=>'ptype')); ?> </td></tr -->
<?php //}else{ ?>
<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::textField('Sales[table]', Yii::app()->session['table'], array('size'=>60,'maxlength'=>128,'readonly'=>'readonly')); ?> </td></tr -->
    <?php
//} ?>

<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Checkout',array('class'=>'btn btn-warning','style'=>'margin:0px;','onclick'=>'checkout_rest()')) ?></td>
<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Cancel',array('class'=>'btn btn-danger','style'=>'margin:0px;','onclick'=>'clearcart_rest()')) ?></td>
<td colspan="2" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::link('Continue Ordering',Yii::app()->createUrl('front/index'),array('class'=>'btn btn-primary','style'=>'margin:0px;')) ?></td>
</tr>


</table>
</div>

</div>

