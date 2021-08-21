<script type="text/javascript">

function getcust2()
{
	var cust=$('#getname').val();
	

    $.post("<?php echo Yii::app()->createUrl('Inventory/getname2'); ?>",
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


function getname2(id,name)
{
	//alert(name);
	$('#getname').val(name);
	$('#hideid').val(id);
	$('#dcname').html('');
	
	 $.post("<?php echo Yii::app()->createUrl('Inventory/custdeal'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
       
        $("#order").html(data);
    });


}

function getdeals(id,name)
{
	//alert(name);

	 $.post("<?php echo Yii::app()->createUrl('Inventory/custdeal'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        id:id
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        // $("#done").html('');
         $("#transactions").html(data);
          $("#dcname").html('');
    });
}


</script>
<h1>View Customers Transactions</h1>

<div>
<label>Customer Name
<input type="text" name="cname" class="form-control" style="width:200px;" placeholder="Enter Customer Name" onkeyup="getcust2();" id="getname">
</label>
<div id="dcname"></div>
<div id="transactions"></div>
</div>