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

    $("#mi").val('');
    $("#mi").focus();


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
//bar= bar1.split("-").join('');
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




function clearcart()
{
	if(confirm('Warning: Are you absolutely sure you want to clear the cart?')){
	$("#order").load("<?php echo Yii::app()->createUrl('Inventory/clearcart'); ?>");
	$('#getname').val('');
	$('#done').html('');
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
	//if(confirm('Complete and Close transaction?'))
	//{

	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

	//var dtype=$("#sales").val();
	var ptype=$('#ptype').val();
	var id=$('#hideid').val();
	//var tend=$('#tender').val();
	
//alert(dtype); return;

	var tender=$('#tender').val();
	var total=$('#total').val();

	//tenders= tender.split(',').join("");
	//totals= total.split(',').join("");
	//tenders = tenders.replace (/,/g, "");
	//totals = totals.replace (/,/g, "");

	var totals = total.replace(/,/g, '');
	var tenders = tender.replace(/,/g, '');

	//alert("tender "+tenders);
	//alert("total is "+totals);

	if(parseFloat(tenders)<parseFloat(totals))
	{
		alert('Invalid Amount Tendered. Please check amount entered');
		return;
	}

	if(tender!=''){
	var balance=tenders-totals;
	var changed=balance
	$('#balance').val(balance.toFixed(2));
			}else{
				alert('Please enter Amount tendered before checking out');
				return;
			}

	//var changed=$('#balance').val();
	

	
	//alert(changed);
	//return;


    $.post("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // ttype: parseInt(dtype,10),
        payt: ptype,
        name: id,
        tendered: tenders,
        change: balance,
        //city: "Duckburg"
        
    },
    function(data, status){
    //var tender=$('#tender').val();
	//var total=$('#total').val();

	//tenders= tender.split(',').join('');
	//totals= total.split(',').join('');

	
	//alert(status);
	$("#done").html(data);
	
	//newtotal();

	//window.location.replace("<?php echo Yii::app()->createUrl('Inventory/checkout2'); ?>");
	var url = "<?php echo Yii::app()->createUrl('Inventory/checkout3'); ?>";
	$(location).attr('href',url);
    });

	
	

		/*

			$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",function(){
		$('#done').text('Transaction Completed!', function(){
		setTimeout(function(){ $('#done').text(''); },3000);

		});

*/
		//alert('transaction Completed');

	//}
}



function suspend()
{
	//if(confirm('Suspend Sale?'))
	//{

	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");
	var sus=$('#suspend').val();


	//if(sus==3){
	//var dtype=$("#sales").val();
	var ptype=$('#ptype').val();
	var id=$('#hideid').val();
	//alert(ptype);

    $.post("<?php echo Yii::app()->createUrl('Inventory/suspend'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
      //  ttype: dtype,
        payt: ptype,
        name: id,
        //city: "Duckburg"
    },
    function(data, status){
   // var tender=$('#tender').val();
	//var total=$('#total').val();

	//tenders= tender.split(',').join('');
	//totals= total.split(',').join('');

	//if(tender!=''){
	//var balance=tenders-totals;
	//$('#balance').val(balance.toFixed(2));
			//}
	//alert(status);
	//$("#done").html(data);
	
	//newtotal();

	//window.location.replace("<?php echo Yii::app()->createUrl('Inventory/checkout2'); ?>");
	var url = "<?php echo Yii::app()->createUrl('Inventory/sale'); ?>";
	$(location).attr('href',url);
	//alert('done');
    });

	
	

		/*

			$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",function(){
		$('#done').text('Transaction Completed!', function(){
		setTimeout(function(){ $('#done').text(''); },3000);

		});

*/
		//alert('transaction Completed');

	//}
//}
}




function newtotal()
{
	$("#newtotal").load("<?php echo Yii::app()->createUrl('Inventory/newtotal'); ?>");
}

function getchange()
{
	//alert('getchange works');
	var tender=$('#tender').val();
	var total=$('#total').val();
	tenders= tender.split(',').join('');
	totals= total.split(',').join('');
	//alert(total);
	if(tender!=''){
	var balance=tenders-totals;
	$('#balance').val(balance.toFixed(2));
	}
}

function donewcust()
{
	//if(confirm('Add new Customer?'))
	//{

	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

	var name=$("#cname").val();
	//alert(name);
	var email=$("#cemail").val();
	var address=$("#caddress").val();
	var phone1=$("#cphone1").val();
	var phone2=$("#cphone2").val();
	if(name==''){ alert('You have to enter a customer name'); }
	if(name!='')
	{

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

	//}
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
$('#hideid').val(id);
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
         $('#mi2').val('');
    });

}

/*
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
         $("#mi2").val('');
    });

}


*/


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
	//alert(ptype); return;

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


function color()
{
	//$('#stype').attr('backgroundcolor','red');
	var col=$('#sales').val();
	
	if(col==2){
	document.getElementById("b1").style.backgroundColor="#900";
}else{
	document.getElementById("b1").style.backgroundColor="#333";
}
}




function stock(r)
{
	alert(r);
}



function setcat()
{
	var at=$("#car").val();
	//alert(at);


    $.post("<?php echo Yii::app()->createUrl('Inventory/pickcat'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        cat: at,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#done").html('');
        $("#cat").html(data);
    });
}


</script>
<?php
/* @var $this InventoryController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	'Inventories',
);
*/

$this->menu=array(
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>
<?php
	//SUBSTR(created_at,1,10)='".$dyear."'
		
		 ?>


<div id="whole" style="display:block; margin:auto; margin-top:20px; overflow:auto; min-height:300px; width:auto;">
<span id="left" style="display:block; overflow:auto; height:auto; width:30%; display:inline-block;">

<span style="display:block; margin-top:20px;">
		<table border="1" cellpadding="1" cellspacing="1" class="table">
			<tr id="b11" style="font-weight:bold; text-transform:capitalize; color:#fff; background-color:#333;">
<td>	<input type="button" style="width:100%; margin-left:0px;" id="suspend" onclick="suspend();" class="btn btn-primary" value="Suspend Sale"></td>				</tr>
		</table>

	</span>
	

<span style="width:auto; display:block; height:370px; margin-top:20px; overflow:auto; border:1px solid #000; vertical-align:top; padding:5px;">
<div id="cat" style="height:auto; widht:auto; display:block;">
	<input type="text" id="sales" style="display:none;" value="1">
<?php //if($stock!=null){
	foreach($stock as $st)
{ ?>
	<span class="btn btn-primary" style="display:inline-block; margin-top:5px;" onclick="findbar2('<?php echo $st->name; ?>');"><?php echo $st->name; ?></span>
	<?php
}

//}

 ?>

</div>







</span>

<span id="newtotal" style="display:block; margin:auto; width:auto; margin-top:20px; font-weight:bold; text-align:center; color:red;">Todays Sales: <del>N</del><?php echo number_format($tdsale,2); ?>
</span>


<span style="height:auto; border:1px solid #ccc; width:98%; display:block; margin:auto; margin-top:20px;">
	<span style="display:block; background-color:#333; color:#fff; text-align:center; text-transform:uppercase; padding:3px;">last 5 transactions</span>
	<?php foreach($lastsales as $sale){ ?>
	<span style="background-color:#0868B2; padding:5px; text-align:center; display:block; margin-bottom:1px; ;">

<?php  echo CHtml::link(CHtml::encode($sale->total), array('Inventory/recent', 'id'=>$sale->transaction_id),array('style'=>'color:#fff;')); ?>
	</span>
	<?php } ?>
</span>

</span>







<span id="right" style="width:69%; min-height:200px; margin-top:20px; display:inline-block; vertical-align:top; text-align:left;">
	<div style="display:block;" id="done"></div>

	
<?php
	$positions = Yii::app()->shoppingCart->getPositions();
		?>
<input type="hidden" id="hideid" style="width:10px;">
<!--input type="hidden" id="kdiscount" style="width:10px;" value="<?php echo $discount; ?>" -->

		<table border="1" cellpadding="1" cellspacing="1" class="table">
			<tr id="b1" style="font-weight:bold; text-transform:capitalize; color:#fff; background-color:#333;">

				<td>	

					<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	'enableAjaxValidation'=>false,
	//'htmlOptions' => array(
       // 'enctype' => 'multipart/form-data',
  //  ),
	'focus'=>array($model,'barcode'),
)); ?>

<?php echo $form->labelEx($model,'category',array('style'=>'margin-left:-80px;')); ?>
		<?php //echo $form->dropDownList($model1,'category', CHtml::listData(Categories::model()->findAll(), 'id', 'cat'), array('empty'=>'')); ?>
		 <?php echo CHtml::dropDownList('Inventory[item_name]','',CHtml::listData(Categories::model()->findAll(), 'id', 'cat'), array('style'=>'margin-left:10px;','empty'=>'','onchange'=>'setcat();','id'=>'car')); ?> 
   

		<?php echo $form->error($model,'category'); ?>



<?php $this->endWidget(); ?>



				</td>

				<td colspan="3">Customer Name: <input type="text" 
				name="cname" class="form-control" style="width:200px;" placeholder="Enter Customer Name" onkeyup="getcust();" id="getname"></td>

				<td>
				<input type="button" value="New Customer" class="form-control btn btn-primary" style="auto; margin-left:0px;" onclick="newcust()"></td>
			</tr>

			



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



		</table>


<div id="dcname"></div>



<span id="order" style="width:100%; height:auto; overflow:auto; display:block;">


		<table border="1" cellpadding="1" cellspacing="1" class="table">
			





			<tr style="font-weight:bold; text-transform:uppercase; color:#fff; background-color:#333;"><td></td><td>Item Name</td><td>Qty</td><td>ST</td><td>Price</td><td></td></tr>
			<?php $i=0; $flag=0;
			
			foreach($positions as $position) { $i++; $color='#000'; 
			$stock=Inventory::model()->find('id=:u',array(':u'=>$position->getid()))->quantity;
//if($position->quantity<$position->getQuantity()){ $flag=1; $color='red'; }
if($stock<$position->getQuantity()){ $flag=1; $color='red'; }
			?>


		<tr>
			<td style=""><?php //echo (!empty($position->photo)) ? CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:50px;height:auto; border-radius:5px;")) : "No Image"; ?></td>
			<td><?php echo ucfirst($position->name); ?></td>
			<!-- td style="color:<?php echo $color; ?>"><input style="color:<?php echo $color; ?>; width:30px;" type="text" value="<?php echo $position->getQuantity(); ?>"  
				class="form-control" 
				onkeyup="update_cart('<?php echo $position->getid(); ?>');" id="<?php echo $position->getid(); ?>"></td -->
				<TD><select style="width:60px; color:<?php echo $color; ?>" id="<?php echo $position->getid(); ?>" onchange="update_cart('<?php echo $position->getid(); ?>');">
					<option value="<?php echo $position->getQuantity(); ?>" selected="selected"><?php echo $position->getQuantity(); ?></option>
 <?php for($x=1; $x<1001; $x++){ ?>
  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
  <?php } ?>
  
</select></TD>
			<!--td><?php echo $position->quantity; ?></td-->
			<td><?php echo Inventory::model()->find('id=:u',array(':u'=>$position->getid()))->quantity; ?></td>
			<td><?php echo number_format($position->price,2); ?></td>
			<td><span onclick="del('<?php echo $position->getid(); ?>');" style="cursor:pointer; color:blue;" title="Delete">X</span></td>
		</tr>
			
				<?php
			}
			?>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Sub Total</td><td id="sub"><?php echo number_format(Yii::app()->shoppingCart->getCost(),2); ?>
			</td><td></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discount</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $discount; ?>" disabled="disabled">%</td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discounted Total</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $dp=(Yii::app()->shoppingCart->getCost()-(Yii::app()->shoppingCart->getCost()*$discount)/100); ?>" disabled="disabled"></td></tr>
			

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Tax</td><td><del>N</del><input type="text" style="width:70px;" class="form-control" id="tax" value="<?php  $ttax=$sub=($tax*$dp)/100; echo round($ttax,2); ?>" disabled="disabled"></td></tr>

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Total</td><td><input type="text" style="width:70px;" class="form-control" value="<?php echo number_format(($ttax+$dp),2); ?>" id="total" disabled="disabled"></td></tr>

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Amount Tendered</td><td><input type="text" style="width:70px;" class="form-control" id="tender" onkeyup="rada()"></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Change/Balance</td><td><input type="text" style="width:70px;" class="form-control" id="balance" disabled="disabled"></td></tr>
			
			<?php
			if($flag==1){  ?>
			<tr style="font-weight:bold;"><td style=""></td><td><input type="button" class="btn btn-primary" value="Get Change" onclick="getchange();" id="change" style="margin-left:0px;"></td><td></td><td>
				<select style="width:130px;"  onchange="pay();" id="ptype">
  <option value=" ">Payment Type</option>
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit card">Debit Card</option>
  <option value="check">Check</option>
  <option value="credit card">Credit Card</option>
  <option value="return">Return</option>
</select></td><td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout" disabled="disabled" style="margin-left:0px;"></td></tr>
			<?php }else{ ?>
			<tr style="font-weight:bold; background-color:#333;"><td style=""></td><td><input type="button" class="btn btn-primary" value="Get Change" onclick="getchange();" id="change2" style="margin-left:0px;"></td>
				<td></td><td>
				<select style="width:130px;" onchange="pay();" id="ptype">
  <option value=" ">Payment Type</option>
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit card">Debit Card</option>
  <option value="check">Check</option>
    <option value="credit card">Credit Card</option>
      <option value="return">Return</option>
</select></td><td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout2" disabled="disabled" style="margin-left:0px;">
<?php /* echo CHtml::button('Checkout',
    array(
        'submit'=>array('Inventory/checkout2'),
        'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'margin-left:0px;'
        // or you can use 'params'=>array('id'=>$id)
    )
); */?>
</td></tr>
			
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