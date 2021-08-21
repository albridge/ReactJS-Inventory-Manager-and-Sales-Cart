<h1 style="text-align:center;"> Menu:  <?= ucwords($dcat) ?> </h1>

<div style="display:block; min-height:80px;">
<?php
$cats=Categories::model()->findAll();

foreach($cats as $cat)
{
	?>
<div style="display:block; height:auto;">
	
	<!-- div style="display:block;  widht:90%; height:auto; text-align:center;"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/assets/category/".$cat->photo,"",array("style"=>"width:380px;height:auto; border-radius:5px; border:1px solid #333; text-align:center; margin:auto;")), Yii::app()->createUrl("front/items",array('id'=>$cat->id))); ?></div -->
	
	<div style="display:inline-block; float:left;  text-align:center;   text-transform:capitalize; font-weight:bold; font-size:16px;  margin-bottom:20px; margin-top:20px;"><?php  echo CHtml::link(CHtml::button(ucwords($cat->cat),array('class'=>'btn btn-primary', 'style'=>'margin-right:10px; margin-left:0px;')),Yii::app()->createUrl('front/items',array('id'=>$cat->id))); ?></div>

</div>
	<?php
}
?>
</div>

<div style="position:fixed; margin-top:50px; float:right; min-width:50px; min-height:50px; background-color:#000; color:#fff; padding:10px; border-radius:5px; text-align:center; font-size:1em;">Total:<br><del>N</del><div id="costa" style="font-size:1.5em;"> <?php if(!Yii::app()->shoppingCart->isEmpty()){ echo number_format(Yii::app()->shoppingCart->getCost(),2); } ?></div></div>





<div style="position:fixed; margin-top:110px; text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::link('Send',Yii::app()->createUrl('front/summary'),array('class'=>'btn btn-warning','style'=>'margin:0px; padding:10px; font-size:1.5em; margin-top:30px;')) ?></div>
<div style="position:fixed; margin-top:200px; text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('X',array('class'=>'btn btn-danger','style'=>'margin:0px; font-size:1.5em; padding:10px;','onclick'=>'clearcart_rest()')) ?></div>

<div>
	<?php //var_dump($items);
	$position=null;
	if($items!=null){
foreach($items as $item)
{ $position = Yii::app()->shoppingCart->itemAt($item->id);
	?>
<div style="display:block;">
	
	<!-- div style="display:block;  widht:90%; height:auto; text-align:center;"><?php echo CHtml::image(Yii::app()->baseUrl . "/assets/products/".$item['photo'],"",array("style"=>"width:380px;height:auto; border-radius:5px; border:1px solid #333; text-align:center; margin:auto; cursor:pointer;","onclick"=>"say_rest(".$item->id.")")); ?></div -->
	<div style="display:block; text-align:center; text-transform:capitalize; font-weight:bold; font-size:36px; margin-top:20px; margin-bottom:20px;"><?php echo CHtml::button(CHtml::encode($item->name),
    array('class'=>'linkClass','style'=>'display:inline-block; margin:0px; font-size:36px;', 'onclick'=>'say_rest('.$item->id.');'
        // or you can use 'params'=>array('id'=>$id)
    )); ?></div>
	<div style="display:block; text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px;"><input type="text" id="<?= $item->id ?>count" style="width:50px; color:<?php echo $color; ?>" class="form-control" value="<?php if(Yii::app()->shoppingCart->itemAt($item->id)!=null){  echo $position->getQuantity(); } ?>" onkeyup="update_cart2_rest('<?php  echo $item->id; ?>');" ></div>
	<div style="display:block; text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px;"><?php // echo CHtml::button('Add to cart',array('class'=>'btn btn-primary','style'=>'margin:0px;','onclick'=>'say_rest('.$item->id.')')) ?></div>
	<div style="display:block; text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px;"><input type="hidden" id="<?= $item->id ?>mi" value="<?= $item->id ?>"></div>

</div>

	<?php
}
}
	?>

	

</div>