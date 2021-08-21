<?php
//Yii::setPathOfAlias('ext.yiiext', dirname(__FILE__).'/../extensions/shoppingCart');

	Yii::app()->clientscript
		// use it when you need it!
		
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
		->registerCoreScript( 'jquery' )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
		
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="language" content="en" />
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- Le styles -->
<!-- link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl; ?>/css/bootstrap3.3.7/css/bootstrap.css" / -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
<!-- Le fav and touch icons -->

<style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #invoice, #invoice *, #shower *{
    visibility: visible; font-size: 20px;
  }  
  #invoice {
    position: absolute; font-size:20px;
    left: 0;
    top: 0;
  }
  #noshow *{
  	visibility: hidden;
  }

}

</style>

<script type="text/javascript">
function goit()
{
	alert('Items Return Disabled');
	return false;
}



function printa()
{
	//alert('hit');
	
	var id='hit';
	
	//alert('delete command issued to '+id);
	
	// if(confirm('Print Receipt?'))
	// 		{
    $.post("<?php echo Yii::app()->createUrl('Inventory/printa'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#order").html(data);
    });
			//}
			
            $("#loading").show();
				$.get("<?php echo Yii::app()->createUrl('Inventory/printa'); ?>",function(data,status)
				{
					//alert(status);
                    $("#loading").hide();
				});
			

}


function printa2()
{
	
	
	
	
	//alert('delete command issued to '+id);
	
	if(confirm('Print Receipt?'))
			{
				var id=$("#ttid").text();
				//alert(id);
                $("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/printa2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#order").html(data);
       $("#loading").hide();
    });
			}
			
				/*
				$.get("<?php echo Yii::app()->createUrl('Inventory/printa'); ?>",function(data,status)
				{
					//alert(status);
				});
				*/
			

}




function printa3()
{
	
	var id=$("#ttid").text();
				//alert(id);
	
	
	//alert('delete command issued to '+id);
	
	if(confirm('Print Receipt?'))
			{
				$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/printa3'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
       // tall: all
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#order").html(data);
       $("#loading").hide();
    });
			}
			
				/*
				$.get("<?php echo Yii::app()->createUrl('Inventory/printa'); ?>",function(data,status)
				{
					//alert(status);
				});
				*/
			

}

function printa3_all()
{
    
    var id=$("#ttid").text();
                //alert(id);
    
    
    //alert('delete command issued to '+id);
    
    if(confirm('Print Receipt?'))
            {
                $("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/printa3_all'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
       // tall: all
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // $("#order").html(data);
       $("#loading").hide();
    });
            }
            
                /*
                $.get("<?php echo Yii::app()->createUrl('Inventory/printa'); ?>",function(data,status)
                {
                    //alert(status);
                });
                */
            

}


function rada()
{
	//var ptype=$('#ptype').val();
	//var id=$('#hideid').val();
	
	


	var tender=$('#tender').val();
	var total=$('#total').val();

	//tenders= tender.split(',').join("");
	//totals= total.split(',').join("");
	//tenders = tenders.replace (/,/g, "");
	//totals = totals.replace (/,/g, "");

	var totals = total.replace(/,/g, '');
	var tenders = tender.replace(/,/g, '');

	if(parseFloat(tenders)>parseFloat(totals))
	{
		alert('Invalid Amount Tendered. Please check amount entered');
		return;
	}
	

	if(tender!=''){
	var balance=tenders-totals;
	var changed=balance
	$('#balance').val(balance.toFixed(2));
	$('#balance2').val(balance.toFixed(2));
			}
}


function rada2()
{
	//var ptype=$('#ptype').val();
	//var id=$('#hideid').val();
	
	


	var tender=$('#tendered2').val();
	var total=$('#total').val();

	//tenders= tender.split(',').join("");
	//totals= total.split(',').join("");
	//tenders = tenders.replace (/,/g, "");
	//totals = totals.replace (/,/g, "");

	var totals = total.replace(/,/g, '');
	var tenders = tender.replace(/,/g, '');
/*
	if(parseFloat(tenders)<parseFloat(totals))
	{
		alert('Invalid Amount Tendered. Please check amount entered');
		return;
	}
	*/

	if(tender!=''){
	var balance=tenders-totals;
	var changed=balance
	$('#balance').val(balance.toFixed(2));
	$('#balance2').val(balance.toFixed(2));


			}
}

function changed()
{
	//setInterval(function(){ var code=$('#mi').val(); if(code.length>0){ sayip(); } },3000);
	//setInterval(function(){ var code=$('#mi').val(); if(code.length>0){ say(); } },3000);
	//sayip2();
	//say();
	say2();

}

function sayip()
{
	alert('we connected');

}


function sayip2()
{
	var code=$('#mi').val(); if(code.length>0){
		alert('we connected');
	}
		$('#mi').val("");
	$('#mi').focus();

	setTimeout(sayip2,1000);

}

function to_issues(){
    // alert('hello');
    $("#loading").show();
    $("#go_issues").load("<?= Yii::app()->createUrl('inventory/to_issues') ?>",function(data,status){
        $("#loading").hide();
    });
}

function to_cart(){
    // alert('hello');
    $("#loading").show();
    $("#loading2").show();
    $("#order").load("<?= Yii::app()->createUrl('inventory/allcart') ?>",function(data,status){
        $("#loading").hide();
        $("#loading2").hide();
    });
}


function cancel_it(id,barcode,quantity,portid)
{
    
    if(confirm('Cancel it'))
    {
$("#loading").show();
    var items=document.getElementsByClassName('recs');
    for(var i=0; i<items.length; i++)
    {
        items[i].disabled=true;
    }
    $.post("<?= Yii::app()->createUrl('inventory/do_cancel') ?>",
    {
        id:id,
        barcode:barcode,
        quantity:quantity,
        portid:portid
    },
    function(data,status)
    {
        //$("#home").html(data);
        to_issues();
        var items=document.getElementsByClassName('recs');
        for(var i=0; i<items.length; i++)
        {
            items[i].disabled=false;
        }
        $("#loading").hide();
    });
}
}

function receive_it(id,barcode,quantity,portid)
{
    
    if(confirm('Receive it'))
    {
    var items=document.getElementsByClassName('recs');
    for(var i=0; i<items.length; i++)
    {
        items[i].disabled=true;
    }
    $.post("<?= Yii::app()->createUrl('inventory/do_receive') ?>",
    {
        id:id,
        barcode:barcode,
        quantity:quantity,
        portid:portid
    },
    function(data,status)
    {
        //$("#home").html(data);
        to_issues();
        var items=document.getElementsByClassName('recs');
        for(var i=0; i<items.length; i++)
        {
            items[i].disabled=false;
        }
    });
}
}

function update_cart2(id){
//alert($("#mi").val());
$('#'+id).keypress(function(e){
        if(e.which==13){// alert('enter pressed'); 
var bar=$("#"+id).val();
//alert(bar);


//if(code=='13'){ alert('enter pressed');  }
$("#loading").show();
    
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
        disk();

    });


}
});

}

function do_clear()
{
    document.getElementById('orders').value="";
    $("#singles").html("");
}


function addup(tid)
{
    
    document.getElementById('orders').value+=","+tid;

    var ids=$("#orders").val()


     $.post("<?php echo Yii::app()->createUrl('sales/ids'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        ids: ids,
      
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        
        $("#singles").html(data);
        $("#loading").hide();
        

    });
}


function do_merge()
{
    
    

    var ids=$("#orders").val()


     $.post("<?php echo Yii::app()->createUrl('sales/do_merge'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        ids: ids,
      
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        
        $("#singles").html("");
        $("#orders").val("");
        $("#loading").hide();

        var url = "<?php echo Yii::app()->createUrl('sales/merge'); ?>";
    $(location).attr('href',url);
        

    });
}


// store stuff

function update_cart2st(id){
//alert($("#mi").val());
$('#'+id).keypress(function(e){
        if(e.which==13){// alert('enter pressed'); 
var bar=$("#"+id).val();
//alert(bar);


//if(code=='13'){ alert('enter pressed');  }
$("#loading").show();
    
    $.post("<?php echo Yii::app()->createUrl('store/getorder3'); ?>",
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
        disk();

    });


}
});

}

function update_cart2_rest(id){
//alert($("#mi").val());
$('#'+id+"count").keypress(function(e){
        if(e.which==13){// alert('enter pressed'); 
var bar=$("#"+id+"count").val();
// alert(bar);



//if(code=='13'){ alert('enter pressed');  }
$("#loading").show();
    
    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder3_rest'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        quantity: bar,
        id: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
         var obj=JSON.parse(data);
         $("#costa").html(obj.total);
        $("#"+id+"count").val(obj.newquant);
       
        $("#loading").hide();
       

    });


}
});

}


function update_cart3_rest(id){
//alert($("#mi").val());
$('#'+id+"count").keypress(function(e){
        if(e.which==13){// alert('enter pressed'); 
var bar=$("#"+id+"count").val();
// alert(bar);



//if(code=='13'){ alert('enter pressed');  }
$("#loading").show();
    
    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder3_rest2'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        quantity: bar,
        id: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
         var obj=JSON.parse(data);
         $("#"+id+"costa").html(obj.total);
        $("#"+id+"count").val(obj.newquant);
         $("#tot").html(obj.tot);
       
        $("#loading").hide();
       

    });


}
});

}

function say(){
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
   setTimeout(say,1000);




}

function say_rest(id){
//alert($("#mi").val());
var bar=$("#"+id+"mi").val();

if(bar.length>0){
$("#loading").show();
$("#loading2"+id).show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/getorder_rest'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        // $("#done").html('');
        var obj=JSON.parse(data); 
        //$("#order").html(data);
        $("#loading").hide();
        $("#costa").html(obj.total);
        $("#"+id+"count").val(obj.newquant);
        if(obj.out==1)
        {
            alert('Item out of stock');
        }

        $("#loading2"+id).hide();
        
    });

    // $("#mi").val('');
    // $("#mi").focus();
}
   // setTimeout(say,1000);




}

function clearcart()
{
    if(confirm('Warning: Are you absolutely sure you want to clear the cart?')){
        $("#loading").show();
    $("#order").load("<?php echo Yii::app()->createUrl('Inventory/clearcart'); ?>",function(data,status){
        $('#getname').val('');
        $('#done').html('');
        $("#loading").hide();
    });
    
}
}

function clearcart_rest()
{
    if(confirm('Warning: Are you absolutely sure you want to clear the cart?')){
        $("#loading").show();
    $.get("<?php echo Yii::app()->createUrl('Inventory/clearcart'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       
        $("#loading").hide();
        var url = "<?php echo Yii::app()->createUrl('front/index'); ?>";
    $(location).attr('href',url);
    });
    
}
}


function del(id)
{
    //alert('delete command issued to '+id);
    
    //if(confirm('Delete item from Cart?'))
            //{
                $("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/dele'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#order").html(data);
        $("#loading").hide();
        disk();
    });
            //}

}


function del2(id)
{
    //alert('delete command issued to '+id);
    
    //if(confirm('Delete item from Cart?'))
            //{
                $("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('store/dele'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: id,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#order").html(data);
        $("#loading").hide();
        disk();
    });
            //}

}

function checkout()
{
    //if(confirm('Complete and Close transaction?'))
    //{
//      var customer_name = $("#getname").val();
//      if(customer_name.length<1)
//      {
//          alert('You must enter a customer Name');
//          return;
//      }

        
    //$("#done").load("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>");

    //var dtype=$("#sales").val();
    var ptype=$('#ptype').val();
    var id=$('#hideid').val();
    //var tend=$('#tender').val();
    var item_disc=$("#item_d").val();
    
    

    var tender=$('#tender').val();
    var total=$('#total').val();
    var disco=$('#disco').val();
    var disto=$('#discounted_total').val();

    // disco=parseFloat(disco);
    // if(disco.length<=0){
    //  disco=0;
    // }

    //tenders= tender.split(',').join("");
    //totals= total.split(',').join("");
    //tenders = tenders.replace (/,/g, "");
    //totals = totals.replace (/,/g, "");

    var totals = total.replace(/,/g, '');
    var tenders = tender.replace(/,/g, '');
    var distos = disto.replace(/,/g, '');

    /*
    Please add the line below back if you want to make sure 
    customer pays the full amount when purchasing stuff as is practicable
    in a supermarket setting.
    Add back but simply uncommenting if condition starting with
    if(parseFloat(tenders)<parseFloat(totals))
    */

    if(parseFloat(tenders)>parseFloat(totals) || parseFloat(tenders)>parseFloat(distos))
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

    // disable checkout button once it is clicked

    $("#checkout").attr("disabled",true);
    $("#checkout2").attr("disabled",true);

    // setTimeout($("#checkout").attr("disabled",false),5000);
    // setTimeout($("#checkout2").attr("disabled",false),5000);


// we wanted to enable it again after 3 seconds but i think we dont need it.
        // setTimeout(function(){
        //  $("#checkout").attr("disabled",false);
        //  $("#checkout2").attr("disabled",false);
        // },3000); return;


$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('Inventory/checkout'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // ttype: dtype,
        payt: ptype,
        name: id,
        tendered: tenders,
        change: balance,
        disco: disco,
        dtender:tender
        
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

if(data=='Finished'){
    var url = "<?php echo Yii::app()->createUrl('Inventory/checkout3'); ?>";
    $(location).attr('href',url);
}
else{
    var url = "<?php echo Yii::app()->createUrl('Inventory/sale'); ?>";
    $(location).attr('href',url);
}
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

function checkout_rest()
{
    // if(confirm('Complete and Close transaction?'))
    // {

  //       var rom=document.getElementById("table");
  // var selected_text=rom.options[rom.selectedIndex].text; 
  // var selected_id=rom.options[rom.selectedIndex].value; 

  var table= $("#table").val();
  // var ptype= $("#ptype").val();

if(table.length==0){
    alert('Please select a table number'); return;
}



// if(ptype.length==0){
//     alert('Please select a payment type'); return;
// }



$("#loading").show();
$("#loading3").show();

    $.post("<?php echo Yii::app()->createUrl('Inventory/checkout_rest'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       // ttype: dtype,
        // payt: ptype,
        // name: id,
        // tendered: tenders,
        // change: balance,
        // disco: disco,
        // dtender:tender
        table:table,
        // ptype:ptype
        
    },
    function(data, status){    
    
    $("#done").html(data);
   
if(data=='Finished'){

   // alert('Order sent!');
    var url = "<?php echo Yii::app()->createUrl('Inventory/checkout3'); ?>";
    $(location).attr('href',url);
}
// else{
//     var url = "<?php echo Yii::app()->createUrl('Inventory/sale'); ?>";
//     $(location).attr('href',url);
// }
$("#loading").hide();
$("#loading3").hide();

    });

    
    

        

    //}
}



function lock(id)
{
     $("#loading3").show();
    $("#send").attr('disabled',true);
}

function lock2(id)
{
     var table=$("#table").val();
     if(table.length>1)
     {

    $("#send").attr('disabled',true);
     $("#loading3").show();
     }
     
}


function free_table()
{
    $("#send").attr('disabled',false);
    $("#loading3").hide();
}


function formit()
{
    var num=$("#paid").val();



var pen=num.replace(/,/g,'');
var made=numberwithcommas(pen);
$("#paid").val(made);

}

function numberwithcommas(x)
{
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");
}


function ptype(p)
{
     
    var sel=$("#ptype").val();
     

        $.post("<?php echo Yii::app()->createUrl('Inventory/dtype'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        tid: p,
        dpt: sel
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       
       // $("#loading").hide();
       alert('Payment type changed');
      
    });
}

function settle(a)
{
   // alert(a);
    var ptype=$("#ptype").val();
    var paid=$("#paid").val();
   // alert(ptype);

    if(ptype.length==0){
    alert('Please select a payment type'); return;
}

if(paid.length==0){
    alert('Please enter amount paid'); return;
}


        $("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('front/doclose'); ?>",
        //$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
       ptype: ptype,
        tid: a,
        paid:paid
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       // alert(data);
        $("#loading").hide();
      //  var url = "<?php echo Yii::app()->createUrl('inventory/recent',array('id'=>"+data+")); ?>";
    //$(location).attr('href',url);
    document.location.href="<?php echo Yii::app()->createUrl('inventory/recent') ?>&id="+data;
    });
    

}
function singleup(id)
{

    $('#'+id+"single").keypress(function(e){
        if(e.which==13){ alert('Reversal began'); 

    var quantity=$("#"+id+"single").val();
    //alert(quantity);


    $.post("<?= Yii::app()->createUrl('inventory/doreturns2') ?>",
    {
        id:id,        
        quantity:quantity,        
    },
    function(data,status)
    {
        //$("#home").html(data);
      // alert(data);
      var obj=JSON.parse(data);
      if(obj.done=='done'){
        var url = "<?php echo Yii::app()->createUrl('inventory/toreturns'); ?>";
    $(location).attr('href',url);
      }
    });
    
    }
    });

}
</script>
<style type="text/css">
body{
    background-image: url('<?php echo Yii::app()->baseUrl . "/assets/products/back1.jpg"; ?>');
}

@media (min-width:320px)  { color:red; font-size:30px;/* smartphones, portrait iPhone, portrait 480x320 phones (Android) */ }
@media (min-width:480px)  { color:red; font-size:30px;/* smartphones, Android phones, landscape iPhone */ }
@media (min-width:600px)  { color:red; font-size:30px;/* portrait tablets, portrait iPad, e-readers (Nook/Kindle), landscape 800x480 phones (Android) */ }
@media (min-width:801px)  { color:red; font-size:30px;/* tablet, landscape iPad, lo-res laptops ands desktops */ }
@media (min-width:1025px) { color:red; font-size:30px;/* big landscape tablets, laptops, and desktops */ }
@media (min-width:1281px) { color:red; font-size:30px;/* hi-res laptops and desktops */ }

@media all and (max-width: 699px) and (min-width: 120px), (min-width: 1151px){
    body{
       
    }
    nav{
       
    }
}


</style>
</head>

<body onload="load_issue(), changed()">
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a><?php $sets=Config::model()->find('id=:l',array(':l'=>1)); ?>
				<a class="brand" href="<?= Yii::app()->createUrl('front/menu') ?>" style="color:#fff;"><?php echo ucwords($sets->company_name); //Yii::app()->name ?></a>
				<div class="nav-collapse"><?php //$ses=SchoolSession::model()->find('id=1'); $c=$ses->session_year.' Session '.$ses->term; ?>
					<?php $this->widget('zii.widgets.CMenu',array(
						'htmlOptions' => array( 'class' => 'nav' ),
						'activeCssClass'	=> 'active',
						//'encodeLabel'=>false,						
						'items'=>array(
                      array('label'=>'Options', 'url'=>array('/front/menu'),
                     'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin',
                    array('icon'=>'icon-fa-comments icon-3x', 'url'=>'#'),
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),

                    array('label'=>'Menu', 'url'=>array('/front/index'),
                     'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin',
                    array('icon'=>'icon-fa-comments icon-3x', 'url'=>'#'),
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),

                      array('label'=>'Add to order', 'url'=>array('/front/doctor'),
                     'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin',
                    array('icon'=>'icon-fa-comments icon-3x', 'url'=>'#'),
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),

                        array('label'=>'Close Sale', 'url'=>array('/front/closeit'),
                    // 'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin',
                    array('icon'=>'icon-fa-comments icon-3x', 'url'=>'#'),
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),

                    array('label'=>'View Sale', 'url'=>array('/front/sales'),
                     'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='accounts',
                    array('icon'=>'icon-fa-comments icon-3x', 'url'=>'#'),
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),
						    
				    array('label'=>'<span id="loading">'.CHtml::image(Yii::app()->baseUrl . "/loader/white.gif","",array("style"=>"color:#fff;")).'</span> ', 'url'=>array('/inventory/sale'),                 
                    'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
                    
                    'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            // array(
                            //     'label' => '<i class="icon-bars"></i> New Sale',
                            //     'url' => array('/inventory/sale'),
                            // ),                    
                            ),

                            
                    ),

				

				
				array('label'=>'Shop <span class="caret"></span>', 'url'=>array('/inventory/sale'),					
					'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
					
					'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            array(
                                'label' => '<i class="icon-bars"></i> New Sale',
                                'url' => array('/front/index'),
                            ),                            
                            array(
                                'label' => '<i class="icon-bars"></i> Track Sale',
                                'url' => array('/inventory/tracksale'),
                            ),
                                array(
                                'label' => '<i class="icon-bars"></i> Add to Order',
                                'url' => array('/front/doctor'),
                            ), 
                         array(
                                'label' => '<i class="icon-bars"></i> Suspended Sales',
                                'url' => array('/inventory/Suspended'),
                            ),                      
                             array(
                                'label' => '<i class="icon-bars"></i> Sales Summary',
                                'url' => array('/inventory/viewsales'),
                            ),
                              array(
                                'label' => '<i class="icon-bars"></i> Return Items',
                                'url' => array('/inventory/toreturns'),
                                'onclick'=>'goit()',
                            ),
                                    array(
                                'label' => '<i class="icon-bars"></i> Close Sale',
                                'url' => array('/front/closeit'),
                            ),
                            array(
                                'label' => '<i class="icon-bars"></i> Lounge Recieve Stock',
                                'url' => array('/store/receive'),
                            ), 
                             ),

							
					),



array('label'=>'Accounts <span class="caret"></span>', 'url'=>array('/inventory/sale'),					
					'visible'=>Yii::app()->user->getState('role')==='sales' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
					
					'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            array(
                                'label' => '<i class="icon-bars"></i> Sales Report Customer',
                                'url' => array('/inventory/viewcustomer'),
                            ),                            
                            array(
                                'label' => '<i class="icon-bars"></i> Shelf Numbers',
                                'url' => array('/shelves/admin'),
                            ),
                                                 
                                   array(
                                'label' => '<i class="icon-bars"></i> Expenses',
                                'url' => array('/Expenses/admin'),
                            ),
                                  array(
                                'label' => '<i class="icon-bars"></i> Expense Type',
                                'url' => array('/expenseType/admin'),
                            ),
                                  array(
                                'label' => '<i class="icon-bars"></i> Merge Sale',
                                'url' => array('/sales/merge'),
                            ), 
                                    array(
                                'label' => '<i class="icon-bars"></i> Split Sale',
                                'url' => array('/sales/split'),
                            ), 
                                    array(
                                'label' => '<i class="icon-bars"></i> Income Statement',
                                'url' => array('/expenses/statement'),
                            ), 
                            //          array(
                            //     'label' => '<i class="icon-bars"></i> Debtors List',
                            //     'url' => array('/inventory/debtors_list'),
                            // ), 
                       
                              ),

							'visible'=>Yii::app()->user->name==='admin' || Yii::app()->user->getState('role')==='store_admin' || Yii::app()->user->getState('role')==='accounts' , 
					),

        // start cashier


array('label'=>'Cashier <span class="caret"></span>', 'url'=>array('/inventory/sale'),                 
                    'visible'=>Yii::app()->user->getState('role')==='cashier' || Yii::app()->user->getState('role')==='store_admin',
                    
                    'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            array(
                                'label' => '<i class="icon-bars"></i> Close Sale',
                                'url' => array('/front/closeit'),
                            ),                            
                  
                                  array(
                                'label' => '<i class="icon-bars"></i> View Sales',
                                'url' => array('/front/sales'),
                            ),
                                  array(
                                'label' => '<i class="icon-bars"></i> Merge Sale',
                                'url' => array('/sales/merge'),
                            ), 
                                    array(
                                'label' => '<i class="icon-bars"></i> Split Sale',
                                'url' => array('/sales/split'),
                            ), 
                        
                            //          array(
                            //     'label' => '<i class="icon-bars"></i> Debtors List',
                            //     'url' => array('/inventory/debtors_list'),
                            // ), 
                       
                              ),

                            'visible'=>Yii::app()->user->getState('role')==='cashier' || Yii::app()->user->getState('role')==='store_admin',
                    ),



        // stop cashier

                    array('label'=>'Reports <span class="caret"></span>', 'url'=>array('/inventory/sale'),					
					
					
					'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            array(
                                'label' => '<i class="icon-bars"></i> Sales Report Customer',
                                'url' => array('/inventory/viewcustomer'),
                            ),                         
                        
                                  array(
                                'label' => '<i class="icon-bars"></i> Income Statement',
                                'url' => array('/expenses/statement'),
                            ),
                                array(
                                'label' => '<i class="icon-bars"></i> Re-order Report',
                                'url' => array('/inventory/reorder'),
                            ),

                                 array(
                                'label' => '<i class="icon-bars"></i> Stock Position Sales',
                                'url' => array('/inventory/stocklist'),
                            ),
                                        array(
                                'label' => '<i class="icon-bars"></i> Stock Position Store',
                                'url' => array('/inventory/stocklist2'),
                            ),
                            array(
                                'label' => '<i class="icon-bars"></i> Sales Reports',
                                'url' => array('/inventory/reports'),
                            ),
                               array(
                                'label' => '<i class="icon-bars"></i> Stock Issue Report',
                                'url' => array('/store/report'),
                            ),
                                           array(
                            'label' => '<i class="icon-bars"></i> Stock Movement Report',
                            'url' => array('/store/sout'),
                            'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin' || Yii::app()->user->getState('role')==='accounts',
                        ),
                              
                              ),

							 'visible'=>Yii::app()->user->name==='admin' || Yii::app()->user->getState('role')==='store_admin' || Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='accounts',      
					),
			
			
				array('label'=>'Contacts <span class="caret"></span>', 'url'=>array('/Suppliers/admin'),
					'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
							//'visible'=>Yii::app()->user->getState('role')==='fin',
					'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
					 'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                            array(
                                'label' => '<i class="icon-bars"></i> Customers',
                                'url' => array('/Customers/admin'),
                            ),                            
                            array(
                                'label' => '<i class="icon-bars"></i> Suppliers',
                                'url' => array('/suppliers/admin'),                        
                            ),                         
                              ),
					),

                    array('label'=>'Supplies <span class="caret"></span>', 'url'=>array('/Suppliers/admin'),
                    'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin',
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                     'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                     array('label'=>'<i class="icon-bars"></i>Inventory', 'url'=>array('/store/admin'),
                            'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
                            ),
                    array('label'=>'<i class="icon-bars"></i>New Supply', 'url'=>array('/inventory/newsupply'),
                    'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),                         
                    // array('label'=>'<i class="icon-bars"></i>Supply Logs', 'url'=>array('/drops/admin'),
                    // 'visible'=>Yii::app()->user->name==='admin' || Yii::app()->user->getState('role')==='store_admin',
                    //         //'visible'=>Yii::app()->user->getState('role')==='fin',
                    // ), 
                  array(
                            'label' => '<i class="icon-bars"></i> Re-order Report',
                            'url' => array('/inventory/reorder'),
                        ),

                        //      array(
                        //     'label' => '<i class="icon-bars"></i> Stock Position',
                        //     'url' => array('/inventory/stocklist'),
                        // ), 
                        // array(
                        //         'label' => '<i class="icon-bars"></i> Issue Stock',
                        //         'url' => array('/inventory/issue'),
                        //          'visible'=>Yii::app()->user->name==='admin',
                        //     ), 
                        //   array(
                        //         'label' => '<i class="icon-bars"></i> All Issued Stock List',
                        //         'url' => array('/inventory/all_issued'),
                        //          'visible'=>Yii::app()->user->name==='admin',
                        //     ),  
                        //  array(
                        //         'label' => '<i class="icon-bars"></i> Receive Stock',
                        //         'url' => array('/inventory/see_issues'),
                        //     ),
                          // array(
                          //       'label' => '<i class="icon-bars"></i> Receive Stock by days',
                          //       'url' => array('/inventory/see_days'),
                          //   ), 
                             array(
                                'label' => '<i class="icon-bars"></i> Issue to sales point',
                                'url' => array('/store/issue'),
                            ),   
                               array(
                                'label' => '<i class="icon-bars"></i> Recieve Stock from Store',
                                'url' => array('/store/receive'),
                                'visible'=>Yii::app()->user->getState('role')==='sales',
                            ),  
                              array(
                                'label' => '<i class="icon-bars"></i> View Store Inventory',
                                'url' => array('/store/admin'),
                            ),  
                     
                                   
                              ),
                    ),	


                    array('label'=>'Set Up <span class="caret"></span>', 'url'=>array('/inventory/sale'),                   
                    'visible'=>Yii::app()->user->getState('role')==='admin',
                    
                    'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                           
                                                      
                            array(
                                'label' => '<i class="icon-bars"></i> Shelf Numbers',
                                'url' => array('/shelves/admin'),
                            ),
                              array(
                                'label' => '<i class="icon-bars"></i> Shops',
                                'url' => array('/shops/admin'),
                            ),
                                array(
                                'label' => '<i class="icon-bars"></i> Locations',
                                'url' => array('/locations/admin'),
                            ),                                 
                         array(
                                'label' => '<i class="icon-bars"></i>Categories',
                                'url' => array('/categories/admin'),                        
                            ),

                         array(
                                'label' => '<i class="icon-bars"></i>Printers',
                                'url' => array('/printers/admin'),                        
                            ),   
                            array('label'=>'<i class="icon-bars"></i>Users', 'url'=>array('/User/admin'),
                    'visible'=>Yii::app()->user->name==='admin' || Yii::app()->user->getState('role')==='store_admin',
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),
                         array('label'=>'<i class="icon-bars"></i>Config', 'url'=>array('/config/admin'),
                                'visible'=>Yii::app()->user->name==='admin',
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ), 
                            array('label'=>'<i class="icon-bars"></i>Units', 'url'=>array('/units/admin'),
                                'visible'=>Yii::app()->user->name==='admin',
                            //'visible'=>Yii::app()->user->getState('role')==='fin',
                    ),                        
                              ),

                            
                    ),


     array('label'=>ucwords(Yii::app()->user->name).'<span class="caret"></span>', 'url'=>array('/inventory/sale'),                 
                    
                    
                    'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            ),
                        'itemOptions' => array('class'=>'dropdown user'),
                        'items' => array(
                           array('label'=>'<i class="icon-bars"></i> Change Password', 'url'=>array('/inventory/changepass'),
                    // 'visible'=>Yii::app()->user->getState('role')==='store' || Yii::app()->user->getState('role')==='admin' || Yii::app()->user->getState('role')==='store_admin',
                    ),           
                    array('label'=>'<i class="icon-bars"></i> Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                              ),                           
                    ),
			
				
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				
						),

						 'encodeLabel' => false,
                'htmlOptions' => array(
                    'class'=>'nav pull-right',
                        ),
                'submenuHtmlOptions' => array(
                    'class' => 'dropdown-menu',
                )
					)); ?>
					
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	
	<div class="cont">
	<div class="container-fluid">
	  <?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'homeLink'=>false,
				'tagName'=>'ul',
				'separator'=>'',
				'activeLinkTemplate'=>'<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
				'inactiveLinkTemplate'=>'<li><span>{label}</span></li>',
				'htmlOptions'=>array ('class'=>'breadcrumb')
			)); ?>
		<!-- breadcrumbs -->
	  <?php endif?>
	
	<?php echo $content ?>
	
	
	</div><!--/.fluid-container-->
	</div>
	
	<div class="extra">
	  <div class="container">
		<div class="row">
		
			
			
			
			
			
			</div> <!-- /row -->
		</div> <!-- /container -->
	</div>
	<div  class="col-md-12">
	<div class="footer">
	  <div class="container">
		<div class="row">
			
			<div id="footer-terms" class="col-md-6" style="word-wrap:break-word; text-align:center;">
				Software Designed and Built by Taire Stephen. 08032874778, 08035143000. Email: tairestephen@gmail.com
			</div> <!-- /.span6 -->
		 </div> <!-- /row -->
	  </div> <!-- /container -->
	</div>
</div>
	<script type="text/javascript">
window.onload = function(){   
$("#loading").hide();
 
}
</script>
</body>
</html>
