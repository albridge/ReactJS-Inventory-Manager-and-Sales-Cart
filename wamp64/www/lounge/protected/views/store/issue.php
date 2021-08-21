<script type="text/javascript">

function getitem(){
//alert($("#mi").val());
var item=$("#mi").val();

if(item.length>0){
$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('store/getitem'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        item: item,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#list").html(data);
        $("#loading").hide();
    });

    //$("#mi").val('');
    $("#mi").focus();
}

}



function findbar2(ba,name){
//alert($("#mi").val());
var bar=ba;
$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('store/getorder2'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        barcode: bar,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        $("#done").html('');
        $("#order").html(data);
        $('#list').html('');
         $('#mi').val('');

         $("#total2").val($('#total').val());
         $("#loading").hide();
        
    });

}

function do_issue()
{
var user=$("#use").val();
	$("#loading").show();
    $.post("<?php echo Yii::app()->createUrl('store/move_issue'); ?>",
    	//$("#mainMbMenu").load("<?php echo Yii::app()->createUrl('srequisition/ref2'); ?>");
    {
        user: user,
        //city: "Duckburg"
    },
    function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
     
        $("#order").html(data);
        $('#list').html('');
     

        
         $("#loading").hide();
        
    });
}
</script>

<h1>Issue Stock</h1>


<div>

<input type="text" class="form-control" onkeyup="getitem()" id="mi">
<div id="list"></div>

<div id="order"></div>
</div>