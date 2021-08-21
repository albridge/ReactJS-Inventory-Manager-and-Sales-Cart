<style type="text/css">


</style>
<script type="text/javascript">




function say2(){
//alert($("#mi").val());
var bar=$("#mi").val();
if(bar.length>0){
$("#loading").show();
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
        $("#loading").hide();
    });

    $("#mi").val('');
    $("#mi").focus();
}
   




}

function update_cart(id){
//alert($("#mi").val());
var bar=$("#"+id).val();
//alert(bar);
if(bar.length!=0){
	$("#loading").show();
setTimeout(function(){
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
        $("#loading").hide();
    });

},1000);

}
}



function add_discount(id)
{
	// browser.cache.disk.enable=false;
	// browser.cache.memory.enable=false;
	// browser.cache.offline.enable=false;
	$('#d'+id).keyup(function(e){
		if(e.which==13){// alert('enter pressed'); 
		$("#loading").show();
		var bar=$("#d"+id).val();
		var quan=$('#'+id).val();	
		




//if(code=='13'){ alert('enter pressed');  }
	
    $.post("<?php echo Yii::app()->createUrl('Inventory/add_discount'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        discount: bar,
        id: id,
        quantity: quan
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
        $("#loading").hide();

  //       var tot=$("#total").val();
		// tot = tot.replace(/,/g, '');
		// tot = tot.split('.');
		// alert(tot[0]);
		// $("#total").val(tot[0]-bar);
		disk();
		
    });



}
});
}

function disk()
{
	    $("#loading").show();
	    $.get("<?php echo Yii::app()->createUrl('Inventory/disk'); ?>",    	
  
    function(data, status){
    	total=$("#total").val();
	var totals = total.replace(/,/g, '');
	var tes="<?php echo $tpos ?>";
	var temp=totals-data;
      $("#discounted_total").val(temp.toFixed(2));
     $("#loading").hide();
		
		
    });
		 
}






function findbar(){
//alert($("#mi2").val());
var bar=$("#mi2").val();
//bar= bar1.split("-").join('');
//if(bar.length>2){
	$("#loading").show();

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
        $("#loading").hide();

    });
//}

}












function dodisco()
{
	//var code=(e.keyCode ? e.keyCode : e.which);
	//if(code=='13'){ alert('enter pressed');  }
	$('#disco').keypress(function(e){
		if(e.which==13){ alert('enter pressed'); 

	var tot=$('#total').val();
	var bal=$('#balance').val();
	var disc=$('#disco').val();

	var tot = tot.replace(/,/g, '');
	var bal = bal.replace(/,/g, '');

	var di=tot-disc;
	var change=bal+disc;
	alert(disc);

	$('#total').val(di);
	$('#balance').val(change);
		 }
	});
	
}

	function david()
	{
		<?php 
		$tot_discount=0;
		$positions = Yii::app()->shoppingCart->getPositions();
			foreach($positions as $position)
			{
				$tot_discount+=$position->disco;
			}
			//return $tot_discount;
		?>
		return <?php echo $tot_discount; ?>

	}


	function david2(id)
{
	//alert('delete command issued to '+id);
	
	//if(confirm('Delete item from Cart?'))
			//{
				$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/david2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#order").html(data);
        $("#loading").hide();
    });
			//}

}



function discounted()
{
	$("#loading").show();
	   $.get("<?php echo Yii::app()->createUrl('Inventory/david2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#order").html(data);
       var to=$('#total').val();
	var ba=$('#balance').val();
	var di=$('#disco').val();

	var to = to.replace(/,/g, '');
	var ba = ba.replace(/,/g, '');

	var dtotal=parseFloat(to)-parseFloat(data);
	var dib=parseFloat(ba)+parseFloat(data);

	$('#disprice').val('');
	$('#disbal').val('');

	$('#disprice').val(dtotal);
	$('#disbal').val(dib);
    });   
	$("#loading").hide();

}

function checkout_top()
{
	//if(confirm('Complete and Close transaction?'))
	//{

		
	//$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

	//var dtype=$("#sales").val();
	var ptype=$('#ptype').val();
	var id=$('#hideid').val();
	//var tend=$('#tender').val();
	
//alert(id);

	var tender=$('#tendered2').val();
	var total=$('#total').val();

	//tenders= tender.split(',').join("");
	//totals= total.split(',').join("");
	//tenders = tenders.replace (/,/g, "");
	//totals = totals.replace (/,/g, "");

	var totals = total.replace(/,/g, '');
	var tenders = tender.replace(/,/g, '');

	if(parseFloat(tenders)<parseFloat(totals))
	{
		alert('Invalid Amount Tendered. Please check amount entered');
		return;
	}

	if(tendered2!=''){
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

	// disable checkout button once it is clicked

	$("#checkout").attr("disabled",true);
	$("#checkout2").attr("disabled",true);


// we wanted to enable it again after 3 seconds but i think we dont need it.
		// setTimeout(function(){
		// 	$("#checkout").attr("disabled",false);
		// 	$("#checkout2").attr("disabled",false);
		// },3000); return;


    $.post("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // ttype: dtype,
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
	if(confirm('Suspend Sale?'))
	{
$("#loading").show();
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
       // ttype: dtype,
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
	$("#loading").hide();
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
}




function newtotal()
{
	$("#loading").show();
	$("#newtotal").load("<?php echo Yii::app()->createUrl('Inventory/newtotal'); ?>",function(data,status){
		$("#loading").hide();
	});
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
	if(confirm('Add new Customer?'))
	{
$("#loading").show();
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
    	$("#loading").hide();
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
}



function getcust()
{
	var cust=$('#getname').val();
	
$("#loading").show();
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
        $("#loading").hide();
       
    });
//}	
}


function get_outstanding(cust)
{

  $("#loading").show();
    $.get("<?php echo Yii::app()->createUrl('Inventory/get_outstanding'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        cust: cust,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#done").html('');
        // $("#c_outstanding").val(parseFloat(data).toFixed(2));

        $("#c_outstanding").val(parseFloat(data).toLocaleString('en'));
       $("#loading").hide();
       
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
  get_outstanding(id);
}

function findbar2(ba){
//alert($("#mi").val());
var bar=ba;
$("#loading").show();
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

         $("#total2").val($('#total').val());
         $("#loading").hide();
        
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


</script>
<?php
/* @var $this InventoryController */
/* @var $dataProvider CActiveDataProvider */



$this->menu=array(
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>
<?php
	//SUBSTR(created_at,1,10)='".$dyear."'
		
		 ?>


<div id="whole" style="display:block; margin:auto; margin-top:20px; overflow:auto; min-height:300px; width:auto;">
	<!--span style="display:block; float:right;">
		<tr>	

	<td>Total</td>
	<td><input type="text" class="form-control" style="display:inline-block;" id="total2" disabled="disabled"></td>

	<td>Tendered</td>
	<td><input type="text" class="form-control" style="display:inline-block;" id="tendered2" onkeyup="rada2();"></td>

	<td>Balance</td>
	<td><input type="text" class="form-control" style="display:inline-block;" id="balance2" disabled="disabled"></td>

	<td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout_top();" id="checkout2"  style="margin-left:0px; display:inline-block;"></td>
	
</tr>

</span -->
<span id="left" style="display:block; overflow:auto; height:auto; width:30%; display:inline-block;">

<span style="display:block; margin-top:20px;">
	<!--div id="loading" style="display:none;"><?= CHtml::image(Yii::app()->baseUrl . "/loader/loader11.gif","",array("style"=>"")); ?></div -->
		<table border="1" cellpadding="1" cellspacing="1" class="table">
			<tr id="b11" style="font-weight:bold; text-transform:capitalize; color:#fff; background-color:#333;">
				<td>Outstanding: </td>
<td>	<!--input type="button" style="width:100%; margin-left:0px;" id="suspend" onclick="suspend();" class="btn btn-primary" value="Suspend Sale" -->
	<input type="text" class="form-control" id="c_outstanding" style="margin:auto; display:block; font-weight:bold; color:red; text-align:right;" readonly=true></td>				</tr>
		</table>

	</span>
	

<span style="width:auto; display:block; min-height:200px; margin-top:20px; border:1px solid #000; vertical-align:top; background-color:#4682b4; color:#fff;">

<input type="button" value="Clear Cart"  id="ram"  onclick="clearcart();" style="display:block; margin:auto;  width:auto; margin-top:10px;" 
class="btn btn-danger">

<input type="text" id="mi" class="form-control" style="display:block; width:auto; margin:auto; margin-top:20px;" onchange="changed()"  autofocus>



<!--input type="button" value="Get Item"  id="ram"  onclick="say();" style="display:block; margin:auto;  width:auto; margin-top:10px;" 
class="btn btn-success" -->



<span style="display:block; margin:auto; margin-top:20px; width:80%; text-align:center;">Find Product by name</span>


<?php /* $form=$this->beginWidget('CActiveForm', array(
'method'=>'post',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin:auto;',
		 //'onsubmit'=>"return false;",
		),

)); */?>
 <?php //echo $form->errorSummary($model); ?>
 <?php //echo "april 30th 2016 ".strtotime('april 30 2016');
?>
		
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
 
<input type="text" id="mi2" class="form-control" style="display:block; width:auto; margin:auto; margin-top:0px;  margin-bottom:20px;" placeholder="Type product name" onkeyup="findbar();">



<!-- input type="button" value="Get Item by Name"  id="ram2"  style="display:block; margin:auto;  width:auto; margin-top:10px;" class="btn btn-success" -->

<div style="margin:auto; display:block; overflow:auto; width:100%; text-align:center;" id="vchange"></div>





</span>

<span id="newtotal" style="display:block; margin:auto; width:auto; margin-top:20px; font-weight:bold; text-align:center; color:red;">Todays Sales: <del>N</del><?php echo number_format($tdsale,2); ?>
</span>


<span style="height:auto; border:1px solid #ccc; width:98%; display:block; margin:auto; margin-top:20px;">
	<span style="display:block; background-color:#333; color:#fff; text-align:center; text-transform:uppercase; padding:3px;">last 5 transactions</span>
	<?php foreach($lastsales as $sale){ ?>
	<span style="background-color:#0868B2; padding:5px; text-align:center; display:block; margin-bottom:1px; color:#fff;">

<?php  echo CHtml::link(CHtml::encode($sale->total), array('Inventory/recent', 'id'=>$sale->transaction_id),array('style'=>'color:#fff;')); ?>
	</span>
	<?php } ?>
</span>

<span>
<?php //echo CHtml::button('Backup Database',
//     array(
//         'submit'=>array('Inventory/backup'),
//        'confirm' => 'Are you sure you want backup your whole database?',
//         'class'=>'btn btn-success',
//         'style'=>'display:block; margin:auto; margin-top:20px;',
//         //'onclick'=>'printa();'
//         // or you can use 'params'=>array('id'=>$id)
//     )
// ); ?>
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
				<td colspan="3">Customer Name: <input type="text" 
				name="cname" class="form-control" style="width:200px; position:relative;" placeholder="Enter Customer Name" onkeyup="getcust();" id="getname">
				<div id="dcname" style="position:absolute; width:300px; margin-left:5%;"></div>
			</td>
<td>	<select style="width:130px;" id="sales" onchange="color();">
 
  <option value="1">Sales</option>
  <!--option value="2">Return</option -->   
</select></td>
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






<span id="order" style="width:100%; height:auto; overflow:auto; display:block; overflow-x:hidden;">
	<?php // start of divison pick ?>

<div id="loading2" style="display:none;"><?= CHtml::image(Yii::app()->baseUrl . "/loader/loader11.gif","",array("style"=>"")); ?></div>

		

</span>

<?php // end of pick division ?>

<?php //$positions = Yii::app()->shoppingCart->getPositions(); //var_dump($positions[0]->name[0]); 
 //var_dump($positions);
// foreach($positions as $position)
// {
// 	echo $position->getDisco();
// }
 //$position = Yii::app()->shoppingCart->itemAt(1); echo $position->id;
 //echo "david". Yii::app()->shoppingCart->getCost();
 ?>
</span>




</div>

<script type="text/javascript">
window.onload = function(){
	to_cart();

	total=$("#total").val();
	var totals = total.replace(/,/g, '');
	var tes="<?php echo $tpos ?>";
	var temp=totals-tes;
  $("#discounted_total").val(temp);

 
}
</script>

