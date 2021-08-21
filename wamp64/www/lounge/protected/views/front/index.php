<?php
/* @var $this FrontController */

$this->breadcrumbs=array(
	'Menu Categories',
);
?>
<h1 style="text-align:center;"><?php if(Yii::app()->shoppingCart->getCount()>0){ echo CHtml::link(CHtml::button(Yii::app()->shoppingCart->getCount().' items in cart',array('class'=>'btn btn-primary', 'style'=>'margin-right:10px; margin-left:0px;')),Yii::app()->createUrl('front/summary')); }?>Main Menu<?php if(isset(Yii::app()->session['tid'])){ echo CHtml::link(CHtml::button('Addon Active',array('class'=>'btn btn-primary','style'=>'margin-left:10px;', 'confirm' => 'Cancel Addon?',)),Yii::app()->createUrl('front/canceladd')); }?></h1>
<div style="word-wrap:break-word;">
<?php
$cats=Categories::model()->findAll();

foreach($cats as $cat)
{
	?>
<div style="display:block;">
	
	<!-- div style="display:block;  widht:90%; height:auto; text-align:center;"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/assets/category/".$cat->photo,"",array("style"=>"width:380px;height:auto; border-radius:5px; border:1px solid #333; text-align:center; margin:auto;")), Yii::app()->createUrl("front/items",array('id'=>$cat->id))); ?></div -->
	
		<div style="display:block;  widht:90%; height:auto; text-align:center; "><?php  echo CHtml::link(CHtml::button(ucwords($cat->cat),array('class'=>'btn btn-primary', 'style'=>'margin-right:10px; margin-left:0px; font-size:36px; margin-bottom:10px;')),Yii::app()->createUrl('front/items',array('id'=>$cat->id))); ?></div>
	

</div>
	<?php
}
?>
</div>
