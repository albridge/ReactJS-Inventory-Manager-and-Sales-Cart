<div style="display:block; margin;auto; margin-top:50px; font-size:45px; text-align:center;" id="mark">
	<div><?php $pic=Config::model()->findByPk(1); echo CHtml::image(Yii::app()->baseUrl . "/assets/conf/".$pic['photo'],"",array("style"=>"width:auto;height:40px; border-radius:5px; margin-bottom:30px;")); ?>
	</div>
You are logged in!
</div>