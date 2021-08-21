<?php

class FrontController extends Controller
{
	

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{


		return array(
	
		array('allow',
			'actions'=>array('index','create','update','sell','menu','summary','doctors','doctor',
				'setdoctor','setdoctor2','canceladd','long','sales',
				'sell','zoom'),
			'users'=>array('@'),
		),

			array('allow',
			'actions'=>array('closeit','doclose'),
			'roles'=>array('cashier'),
		),
				array('allow',
			'actions'=>array('items'),
			'roles'=>array('sales'),
		),
				
		array('deny',  // deny all users
			'users'=>array('*'),
		),
	);
	}



public function actionIndex()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		//Yii::app()->shoppingCart->clear();
		// unset(Yii::app()->session['tid']);
		// unset(Yii::app()->session['table']);
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function actionItems($id)
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		// Yii::app()->shoppingCart->clear();
		$category=Categories::model()->findByPk($id)->cat; //echo $id; die;
		//$items=Inventory::model()->findAll(array('order'=>'name asc'),'category=:j',array(':j'=>$id));

		//$items=Inventory::model()->findAll('category=:j',array(':j'=>$id));


		 $criteria=new CDbCriteria();
		 $criteria->condition='category=:t';
		 $criteria->params=array(':t'=>$id);
		 //$criteria->group='transaction_id desc';
		// $criteria->limit='5';
		 $criteria->order='name asc';
		 $items=Inventory::model()->findAll($criteria);

		$this->render('items',array('dcat'=>$category,'items'=>$items));
	}

	public function actionSummary()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		$this->render('summary');
	}

	public function actionDoctor()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}

		 Yii::app()->shoppingCart->clear();

		$criteria = new CDbCriteria();
		if(Yii::app()->user->role=='admin')
		{
			$criteria->condition = 'closed = :g'; // step 1
			$criteria->params = array(':g' => 0); // step 2
		}else{
			$criteria->condition = 'closed = :g and staff=:k'; // step 1
			$criteria->params = array(':g' => 0, ':k'=>Yii::app()->user->id); // step 2
		}
		
		//$criteria->order='name asc';
		$criteria->group='transaction_id';

		$doctors=Salesx::model()->findAll($criteria);
		$this->render('doctor',array('doctors'=>$doctors));
	}

	public function actionSetdoctor($tid,$table)
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		Yii::app()->session['tid']=$tid;
		Yii::app()->session['table']=$table;
		// echo Yii::app()->session['table']; die;
		$this->redirect(array('front/index'));
	}


	public function actionSetdoctor2()
	{
		$tid=$_POST['tid'];
		$table=$_POST['table'];
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		Yii::app()->session['tid']=$tid;
		Yii::app()->session['table']=$table;
		// echo Yii::app()->session['table']; die;
		$this->redirect(array('front/index'));
	}

	public function actionCanceladd()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		unset(Yii::app()->session['tid']);
		unset(Yii::app()->session['table']);
		$this->redirect(array('front/index'));
	}

	public function actionCloseit()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}

		$criteria = new CDbCriteria();
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='cashier')
		{
			$criteria->condition = 'closed = :g'; // step 1
			$criteria->params = array(':g' => 0); // step 2
		}else{
			$criteria->condition = 'closed = :g and staff=:k'; // step 1
			$criteria->params = array(':g' => 0, ':k'=>Yii::app()->user->id); // step 2
		}
		//$criteria->order='name asc';
		$criteria->group='transaction_id';


		$doctors=Salesx::model()->findAll($criteria);
		$this->render('close',array('doctors'=>$doctors));
	}


	public function actionDoclose()
	{
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}
		//$id=$_POST['id']; 
		$id=$_POST['tid'];
		$ptype=$_POST['ptype']; 
		$npaid=$_POST['paid'];
		$paid=str_replace(',', '', $npaid);
		

					$update=Salesx::model()->findAll('transaction_id=:g',array(':g'=>$id));

			if(($update[0]->amount_paid+$paid)>$update[0]->total){
				?>


<script type="text/javascript">
alert('Overpay');
</script>
				<?php
				die;
			}
	



			$transaction = Yii::app()->db->beginTransaction();
			
			// var_dump($doit) ;
			try{


			for($v=0; $v<count($update); $v++){
			$update[$v]->tendered+=$paid;
			$update[$v]->amount_paid+=$paid;
			$update[$v]->sale_balance-=$paid;
			if(!$update[$v]->save())
			{
				//throw new Exception( 'could not update sale balance');
			}
		}


$record=Salesx::model()->findAll('transaction_id=:g',array(':g'=>$id));
			for($x=0; $x<count($record); $x++){
				if($record[$x]->sale_balance==0){
			$record[$x]->closed=1;
		}
			//$record[$x]->ptype=$ptype;
			if(!$record[$x]->save()){ throw new Exception( 'could not save1'); }
		


			$copy=$record[$x]->attributes;
			$model =  new Sales;
			$model->setAttributes($copy);
			if(!$model->save()){ throw new Exception( 'could not save2'); }




			$inv=Inventory::model()->find('id=:h',array(':h'=>$record[$x]->item_id));

			$inv->quantity-=$record[$x]->qty;
			if(!$inv->save()){ throw new Exception( 'could not inventory');

			 }	

			
		}


			

		
// var_dump($record);
		// foreach($record as $link)
		// {
					
		// 			$link['closed']=1;
		// 			$link['ptype']=$ptype;
		// 			if(!$link->save())
		// 			{
		// 				var_dump($link->getErrors()); die;
		// 			}
		// }

			$transaction->commit();	

					
					
				} catch (Exception $e) {
    $transaction->rollBack();
}

	
		echo $id;

		//$this->redirect(array('inventory/recent','id'=>$id));
	}


	public function actionSales()
	{
		if(empty(Yii::app()->user->id))
		{
			
			$this->redirect(array('site/login',array('model'=>$model)));
		}

		$model=new Inventory;

		if(isset($_GET['Inventory']))
				{	

					$dyear=$_GET['Inventory']['date1'];
			$date2=$_GET['Inventory']['date2'];

			
			

		$criteria = new CDbCriteria();
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='accounts')
		{
			// $criteria->condition = 'closed = :g'; // step 1
			// $criteria->params = array(':g' => 0); // step 2
			$sales_sql="select transaction_id, table_number, staff from salesx where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."'   group by transaction_id order by id desc";
		}else{
			// $criteria->condition = 'staff=:k'; // step 1
			// $criteria->params = array(':k'=>Yii::app()->user->id); // step 2
			$sales_sql="select transaction_id, table_number, staff from salesx where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".Yii::app()->user->id."'   group by transaction_id order by id desc";
		}

		$doctors = Yii::app()->db->createCommand($sales_sql)->queryAll();
		
		// //$criteria->order='name asc';
		// $criteria->group='transaction_id';

		// $doctors=Salesx::model()->findAll($criteria);
		$this->render('sales',array('doctors'=>$doctors,'model'=>$model));
	}else{
		$this->render('sales',array('model'=>$model));
	}
	}


	public function actionMenu()
	{
			if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}

		$this->render('menu');
	}

	public function actionSell()
	{
		$this->render('long');
	}

	public function actionLong()
	{
		
		
		$name=$_POST['barcode'];
		if(!empty($name)){
		$criteria = new CDbCriteria();
		$criteria->condition = 'name LIKE :title and shop_id=:g'; // step 1
		$criteria->limit = '5';
		$criteria->params = array(':title' => '%'.$name.'%',':g'=>Yii::app()->user->shop_id); // step 2
		$result = Inventory::model()->findAll($criteria);

		foreach($result as $res)
		{
			?>
<span style="display:block; background-color:blue; color:#fff; padding:5px; border-bottom:1px solid #fff; cursor:pointer;" onclick="zoom('<?= $res->id ?>')"><?= $res->name ?></span>

			<?php
		}
	}
	}


	public function actionZoom()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		//$this->renderPartial('ocalc',array(
			//'dataProvider'=>$dataProvider,
		//));


			

		$bad=$_POST['barcode'];
		
	$response=Inventory::model()->find('id=:bcode',array(':bcode'=>$bad));


		//$check=Yii::app()->shoppingCart->itemAt((int)$response->id);

	$check=Yii::app()->shoppingCart->itemAt($response->id);  //echo $check->quantity;
	//if(($response->quantity>0) || ($check->quantity>$response->quantity))
		//if(($response->quantity>0) && ($response->quantity>=$check->quantity))
	$positions = Yii::app()->shoppingCart->getPositions();
	$itq=0;

	foreach($positions as $pos)
	{
		if($pos->barcode==$bad)
		{
			$itq=$pos->getQuantity();
		}
	}
	
	
//{
		
		if($response->quantity>$itq)
		{
		Yii::app()->shoppingCart->put($response); //1 item with id=1, quantity=1.
				}else{
						?>
				<script type="text/javascript">
				alert('<?php echo ucfirst($response->name); ?> is out of stock!');
				</script>
				<?php
						
					}



$positions = Yii::app()->shoppingCart->getPositions();
?>
<table class="table table-bordered table-striped">
<tr><td></td><td>Item Name</td><td>Price</td> <td>Qty</td><td>Sub Total</td></tr>
<?php
foreach($positions as $position)
{
	?>

<tr><td><?php echo CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:180px;height:auto; border-radius:5px; border:1px solid #333; text-align:center; margin:auto;")); ?></td>
	<td><?= ucwords($position->name) ?></td>
	<td><?=  number_format($position->getPrice(),2) ?></td> 
	<td><input type="text" value="<?= $position->getQuantity() ?>" style="width:30px;" onkeyup="update_cart3_rest('<?php  echo $position->id; ?>');" id="<?php  echo $position->id;  ?>count"></td>
	<td id="<?= $position->id ?>costa"><?= number_format($position->getQuantity()*$position->getPrice(),2) ?></td>
</tr>

	<?php
}

?>
  <tr><td colspan="4"></td><td id="tot"><?= number_format(Yii::app()->shoppingCart->getCost(),2) ?></td></tr> 
<?php //if(empty(Yii::app()->session['table'])){ ?>
<tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::dropDownList('Sales[table]','',array_combine(range(1,50),range(1,50)), array('style'=>'margin-left:10px;','empty'=>'','id'=>'table')); ?> </td></tr>
<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::dropDownList('Sales[ptype]','',array('cash'=>'Cash','pos'=>'Pos','transfer'=>'Transfer'), array('style'=>'margin-left:10px;','empty'=>'','id'=>'ptype')); ?> </td></tr -->
<?php //}else{ ?>
<!-- tr><td colspan="5" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin:auto; margin-bottom:20px;"><?php echo CHtml::textField('Sales[table]', Yii::app()->session['table'], array('size'=>60,'maxlength'=>128,'readonly'=>'readonly')); ?> </td></tr -->
	<?php
//} ?>

<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Checkout',array('class'=>'btn btn-warning','style'=>'margin:0px;','onclick'=>'checkout_rest()')) ?></td>
<tr><td colspan="3" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::button('Cancel',array('class'=>'btn btn-danger','style'=>'margin:0px;','onclick'=>'clearcart_rest()')) ?></td>
<td colspan="2" style="text-align:center; text-transform:capitalize; font-weight:bold; font-size:16px; margin-bottom:20px; "><?= CHtml::link('Continue Ordering',Yii::app()->createUrl('front/index'),array('class'=>'btn btn-primary','style'=>'margin:0px;')) ?></td>
</tr>


</table>
<?php
			
					// $this->redirect(array('allcart'));
		
		}
}