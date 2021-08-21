<script type="text/javascript">
function say(){
//alert($("#mi").val());
var bar=$("#mi").val();

    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
    });

}




function update_cart(id){
//alert($("#mi").val());
var bar=$("#"+id).val();
//alert(bar);


    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder3'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        quantity: bar,
        id: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
    });


}





function findbar(){
//alert($("#mi2").val());
var bar=$("#mi2").val();
//if(bar.length>2){

    $.post("<?php echo Yii::app()->createUrl('Inventory/vchange'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        title: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#done").html('');
        $("#vchange").html(data);
    });
//}

}



function findbar2(ba){
//alert($("#mi").val());
var bar=ba;

    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
    });

}





function clearcart()
{
	if(confirm('Warning: Are you absolutely sure you want to clear the cart?')){
	$("#order").load("<?php echo Yii::app()->createUrl('Inventory/clearcart'); ?>");
}
}


function del(id)
{
	//alert('delete command issued to '+id);
	
	if(confirm('Delete item from Cart?'))
			{
    $.post("<?php echo Yii::app()->createUrl('Inventory/dele'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#order").html(data);
    });
			}

}



function checkout()
{
	if(confirm('Complete and Close transaction?'))
	{

	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

	var dtype=$("#sales").val();
	var ptype=$('#ptype').val();
    $.post("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        ttype: dtype,
        payt: ptype,
        //city: "Duckburg"
    },
    function(data, status){
       var tender=$('#tender').val();
	var total=$('#total').val();
	if(tender!=''){
	var balance=tender-total;
	$('#balance').val(balance.toFixed(2));
}
	alert(status);
	$("#done").html(data);
	
    });

	
	

		/*

			$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",function(){
		$('#done').text('Transaction Completed!', function(){
		setTimeout(function(){ $('#done').text(''); },3000);

		});

*/
		//alert('transaction Completed');

	}
}




function getchange()
{
	//alert('getchange works');
	var tender=$('#tender').val();
	var total=$('#total').val();
	if(tender!=''){
	var balance=tender-total;
	$('#balance').val(balance.toFixed(2));
	}
}

function donewcust()
{
	if(confirm('Add new Customer?'))
	{

	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

	var name=$("#cname").val();
	//alert(name);
	var email=$("#cemail").val();
	var address=$("#caddress").val();
	var phone1=$("#cphone1").val();
	var phone2=$("#cphone2").val();
	

    $.post("<?php echo Yii::app()->createUrl('Inventory/donewcust'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        dname: name,
        daddress: address,
        dphone1: phone1,
        dphone2: phone2,
        demail: email,        
        //city: "Duckburg"
    },
    function(data, status){
      alert(status);	
	newcust();

	$("#cname").val('');	
	$("#cemail").val('');
	$("#caddress").val('');
	$("#cphone1").val('');
	$("#cphone2").val('');
	
    });		

	}
}



function getcust()
{
	var cust=$('#getname').val();
	

    $.post("<?php echo Yii::app()->createUrl('Inventory/getname'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        name: cust,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#done").html('');
        $("#dcname").html(data);
    });
//}


	
}

function getname(id,name)
{
	//alert(name);
	/*
	 $.post("<?php echo Yii::app()->createUrl('Inventory/getorder2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
    });
*/
$('#getname').val(name);
$('#dcname').html('');
}

function findbar2(ba){
//alert($("#mi").val());
var bar=ba;

    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
        $('#vchange').html('');
    });

}


function placeit(bar,name)
{
	document.getElementById("mi").value=bar;
	document.getElementById("mi2").value=name;
}



function pay()
{
	//var ptype=$("#pay").val();
	//var ptype=$( "#pay option:selected" ).text();
	//var ptype=$('select[pay=selector]').val();

	var e = document.getElementById("ptype");
	var ptype = e.options[e.selectedIndex].text;

	//alert(ptype);
	if(ptype!='Payment Type')
	{	
	$("#checkout").attr("disabled",false);
	$("#checkout2").attr("disabled",false);
	}else{
		//document.getElementById("checkout").disabled=true;
		$("#checkout").attr("disabled",true);
		$("#checkout2").attr("disabled",true);
	}
}


function newcust()
{
	
	/*
	if($('#newcust').css('display') == 'none'){
	//alert(at);
	$("#newcust").show(1000);
	}else{
		$("#newcust").hide(1000);
	}
	*/
	$("#newcust").toggle(1000);
}

</script>
<?php
/* @var $this InventoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventories',
);

$this->menu=array(
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<div style="display:block; margin:auto; margin-top:20px; overflow:auto; min-height:300px; width:auto;">
<span style="display:block; overflow:auto; height:auto; width:30%; display:inline-block; ">

<span style="width:auto; display:block; min-height:200px; margin-top:20px; border:1px solid #000; vertical-align:top; background-color:#ccc;">

<input type="button" value="New sale"  id="ram"  onclick="clearcart();" style="display:block; margin:auto;  width:auto; margin-top:10px;" 
class="btn btn-warning">

<input type="text" id="mi" class="form-control" style="display:block; width:auto; margin:auto; margin-top:20px;" autofocus>



<input type="button" value="Get Item"  id="ram"  onclick="say();" style="display:block; margin:auto;  width:auto; margin-top:10px;" 
class="btn btn-success">



<span style="display:block; margin:auto; margin-top:20px; width:80%; text-align:center;">Find Product by name</span>


<?php /* $form=$this->beginWidget('CActiveForm', array(
'method'=>'post',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin:auto;',
		 //'onsubmit'=>"return false;",
		),

)); */?>
 <?php //echo $form->errorSummary($model); ?>
 
		
<?php /* echo $form->textField($model,'item_name',
array('empty'=>'', 'style'=>' margin:auto;','id'=>'mi2',  
                     'ajax'=>array(
                        'type'=>'POST',
                        'url'=>CController::createUrl('Inventory/vchange'),
                        'update'=>'#vchange',
						'data'=>array('item_name'=>'js:this.value'),
						
						 
						
  
        ))

); ?>
        <?php echo $form->error($model,'item_name'); ?>
        
   <div id="vchange"></div>     
        
  */ ?>
        
        
	
       
    
    
 
<?php // $this->endWidget(); ?>
 
<input type="text" id="mi2" class="form-control" style="display:block; width:auto; margin:auto; margin-top:20px;  margin-bottom:20px;" onkeyup="findbar();">



<!-- input type="button" value="Get Item by Name"  id="ram2"  style="display:block; margin:auto;  width:auto; margin-top:10px;" class="btn btn-success" -->

<div style="margin:auto; display:block; overflow:auto; width:100%; text-align:center;" id="vchange"></div>





</span>

<span style="display:block; margin:auto; width:auto; margin-top:20px; font-weight:bold; text-align:center; color:red;">Todays Sales: <del>N</del><?php echo number_format($tdsale,2); ?></span>

</span>







<span style="width:69%; min-height:200px; margin-top:20px; display:inline-block; vertical-align:top; text-align:left;">
	<div style="display:block;" id="done"></div>

	<span id="order" style="width:100%; height:auto; overflow:auto; display:block;">

<?php
	$positions = Yii::app()->shoppingCart->getPositions();
		?>
		<table border="1" cellpadding="1" cellspacing="1" class="table">
			<tr style="font-weight:bold; text-transform:uppercase; color:#fff; background-color:#333;"><td colspan="4">Customers Name: <input type="text" 
				name="cname" class="form-control" style="width:300px;" placeholder="Start Typing" onkeyup="getcust();" id="getname"></td><td>
				<input type="button" value="New Customer" class="form-control btn btn-primary" style="auto; margin-left:0px;" onclick="newcust()"></td>
			</tr>

			<tr><td id="dcname" colspan="5"></td></tr>



				<tr>
					<div style="width:580px; border:1px solid black; height:auto; display:none; padding:30px; background-color:#ccc;" id="newcust">
						<div class="form" style="">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model2); ?>

	<div class="row" style="display:inline-block;">
		<?php echo $form->labelEx($model2,'cname'); ?>
		<?php echo $form->textField($model2,'cname',array('size'=>60,'maxlength'=>200,'id'=>'cname')); ?>
		<?php echo $form->error($model2,'cname'); ?>
	</div>

	<div class="row" style="display:inline-block;">
		<?php echo $form->labelEx($model2,'caddress'); ?>
		<?php echo $form->textField($model2,'caddress',array('size'=>60,'maxlength'=>250,'id'=>'caddress')); ?>
		<?php echo $form->error($model,'caddress'); ?>
	</div>

	<div class="row" style="display:inline-block;">
		<?php echo $form->labelEx($model2,'cemail'); ?>
		<?php echo $form->textField($model2,'cemail',array('rows'=>6, 'cols'=>50,'id'=>'cemail')); ?>
		<?php echo $form->error($model2,'cemail'); ?>
	</div>

	<div class="row" style=" display:inline-block;">
		<?php echo $form->labelEx($model2,'cphone1'); ?>
		<?php echo $form->textField($model2,'cphone1',array('rows'=>6, 'cols'=>50,'id'=>'cphone1')); ?>
		<?php echo $form->error($model2,'cphone1'); ?>
	</div>

	<div class="row" style="display:inline-block;">
		<?php echo $form->labelEx($model2,'cphone2'); ?>
		<?php echo $form->textField($model2,'cphone2',array('rows'=>6, 'cols'=>50,'id'=>'cphone2')); ?>
		<?php echo $form->error($model2,'cphone2'); ?>
	</div>


<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>
*/ ?>
<div style="display:block; margin-top:20px;">
	<div class="row" style="display:inline-block;">
		<input type="button" value="Save New Customer Details" onclick="donewcust()" class="form-control btn btn-primary" style="width:auto; margin-left:0px;">
	</div>

	<div class="row" style="display:inline-block;">
		<input type="button" value="Cancel" onclick="newcust()" class="form-control btn btn-danger" style="width:auto;">
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
					</div>
				</tr>







			<tr style="font-weight:bold; text-transform:uppercase; color:#fff; background-color:#333;"><td>SN</td><td>Item Name</td><td>Qty</td><td>ST</td><td>Price</td><td></td></tr>
			<?php $i=0; $flag=0;
			foreach($positions as $position) { $i++; $color='#000'; 
if($position->quantity<$position->getQuantity()){ $flag=1; $color='red'; }
			?>


		<tr>
			<td style=""><?php echo $i; ?></td>
			<td><?php echo ucfirst($position->name); ?></td>
			<td style="color:<?php echo $color; ?>"><input style="color:<?php echo $color; ?>; width:30px;" type="text" value="<?php echo $position->getQuantity(); ?>"  
				class="form-control" 
				onkeyup="update_cart('<?php echo $position->getid(); ?>');" id="<?php echo $position->getid(); ?>"></td>
			<td><?php echo $position->quantity; ?></td>
			<td><?php echo number_format($position->price,2); ?></td>
			<td><span onclick="del('<?php echo $position->getid(); ?>');" style="cursor:pointer; color:blue;" title="Delete">X</span></td>
		</tr>
			
				<?php
			}
			?>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Sub Total</td><td id="sub"><?php echo Yii::app()->shoppingCart->getCost(); ?>
			</td><td></td></tr>

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Tax</td><td><input type="text" style="width:70px;" class="form-control" id="tax" value="<?php  $ttax=$sub=($tax/100)*Yii::app()->shoppingCart->getCost(); echo abs($ttax); ?>" disabled="disabled"></td></tr>

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Total</td><td><input type="text" style="width:70px;" class="form-control" value="<?php echo ($sub+Yii::app()->shoppingCart->getCost()); ?>" id="total" disabled="disabled"></td></tr>

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Amount Tendered</td><td><input type="text" style="width:70px;" class="form-control" id="tender"></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Change/Balance</td><td><input type="text" style="width:70px;" class="form-control" id="balance" disabled="disabled"></td></tr>
			<?php
			if($flag==1){  ?>
			<tr style="font-weight:bold;"><td style=""></td><td><input type="button" class="btn btn-primary" value="Get Change" onclick="getchange();" id="change" style="margin-left:0px;"></td><td></td><td>
				<select style="width:130px;"  onchange="pay();" id="ptype">
  <option value=" ">Payment Type</option>
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit_card">Debit Card</option>
  <option value="check">Check</option>
</select></td><td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout" disabled="disabled" style="margin-left:0px;"></td></tr>
			<?php }else{ ?>
			<tr style="font-weight:bold; background-color:#ccc;"><td style=""><input type="hidden" value="1" name="salestype" id="sales" style="width:30px;"></td><td><input type="button" class="btn btn-primary" value="Get Change" onclick="getchange();" id="change2" style="margin-left:0px;"></td>
				<td></td><td>
				<select style="width:130px;" onchange="pay();" id="ptype">
  <option value=" ">Payment Type</option>
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit_card">Debit Card</option>
  <option value="check">Check</option>
</select></td><td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout2" disabled="disabled" style="margin-left:0px;"></td></tr>
			
			<?php } ?>
		</table>
</span>



<?php //$positions = Yii::app()->shoppingCart->getPositions(); var_dump($positions[0]->name[0]); 
 //$position = Yii::app()->shoppingCart->itemAt(1); echo $position->id;
 ?>
</span>

<span id="clearcart" style="width:98%; height:auto; margin-top:100px; display:block; clear:both; vertical-align:top; text-align:center;">
<input type="button" value="Clear Cart"  id="ram"  onclick="clearcart();" style="display:block; margin:auto;  width:auto; margin-top:50px; margin-bottom:20px;" class="btn btn-danger">
</span>

</div>