<h1>Options Menu</h1>

<div>

<!-- div style="display:block; margin-bottom:5px;"><?= CHtml::link('Single Sell',Yii::app()->createUrl('front/sell'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div -->
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Main Menu',Yii::app()->createUrl('front/index'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('View Sales',Yii::app()->createUrl('front/sales'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Change Password',Yii::app()->createUrl('inventory/changepass'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Sales summary',Yii::app()->createUrl('inventory/viewsales'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>

<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Add to order',Yii::app()->createUrl('front/doctor'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Close Sale',Yii::app()->createUrl('front/closeit'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>
<!-- div style="display:block; margin-bottom:5px;"><?= CHtml::link('Return items',Yii::app()->createUrl('inventory/toreturns'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div -->
<div style="display:block; margin-bottom:5px;"><?= CHtml::link('Log out',Yii::app()->createUrl('site/logout'),array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin:auto; display:block;')) ?></div>


</div>