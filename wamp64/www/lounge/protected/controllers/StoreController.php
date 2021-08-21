<?php

class StoreController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('issue','getitem','getorder2','allcart','allcart2','dele','getorder3','move_issue',
					'receive','shift','dele','report','sout','sin','cancel'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create'),
				'roles'=>array('admin','store'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('update',),
				'roles'=>array('admin','store'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// if(Yii::app()->user->shop_id!=1)
		// {
		// 	die('You are not allowed to do this');
		// }
		$model=new Store;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Store']))
		{
			$model->attributes=$_POST['Store'];
			$model->staff=Yii::app()->user->id;
			$model->shop_id=Yii::app()->user->shop_id;
			$model->created_at=date("Y-m-d H:i:s");

			$check=Store::model()->find('name=:j and shop_id=:r',array(':j'=>$model->name,':r'=>Yii::app()->user->shop_id));
			if($check!=null)
			{
				die('Product with name '.$model->name.' already exists');
			}

			$model->name=ucwords($model->name);

			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$model->photo=$uploadedFile;
			$fileName=$model->photo; 
			//var_dump($uploadedFile); die;
			if($uploadedFile!=null && !empty($uploadedFile)){
			  $uploadedFile->saveAs(Yii::app()->basePath.'/../assets/products/'.$fileName);  // image will uplode to rootDirectory/banner/
			}


			if($model->save()){
				$drop=new Drops();
				$drop->barcode=$model->barcode;
				$drop->quantity=$model->quantity;
				$drop->product_name=$model->name;
				$drop->staff=Yii::app()->user->id;
				$drop->shop_id=Yii::app()->user->shop_id;
				$drop->received=$model->quantity;
				$drop->issued=0;
				$drop->item_id=$model->id;
				if(!$drop->save())
				{
					var_dump($drop->getErrors()); die;
				}


				$in= new Buys;
				$in->item_id=$model->id;
				$in->current_quantity=0;
				$in->ins=$model->quantity;
				$in->created_at=date('Y-m-d');
				if(!$in->save())
				{
					var_dump($in->getErrors());
					die('can not save');
				}


				$this->redirect(array('view','id'=>$model->id));
			}
			/*
			try {
			if($model->save())
      		$this->redirect(array('view','id'=>$model->id));
				}
			catch(CDbException $e) {
        $model->addError(null, "<font color='red'>Please use a different barcode</font>");  //$model->addError(null, $e->getMessage());  
				}
				*/
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// if(Yii::app()->user->shop_id!=1)
		// {
		// 	die('You are not allowed to do this!');
		// }
		$model=$this->loadModel($id);
		$ch=$model->photo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Store']))
		{
			$model->attributes=$_POST['Store'];
			$model->updated_at=date("Y-m-d H:i:s");
			$model->name=ucwords($model->name);

			$model->photo=$ch;
			$uploadedFile=CUploadedFile::getInstance($model,'photo')->name; //die;
			
			if(!empty($uploadedFile)){
				$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$model->photo=$uploadedFile;
			$fileName=$model->photo;
			//var_dump($uploadedFile); die;
			  $uploadedFile->saveAs(Yii::app()->basePath.'/../assets/products/'.$fileName);  // image will uplode to rootDirectory/banner/
			}

			if($model->save()){
				$inv=Inventory::model()->find('item_id=:k',array(':k'=>$id));

				if($inv!=null){
					$inv->name=$model->name;
				$inv->price=$model->price;
				$inv->supply_price=$model->supply_price;
				$inv->unit=$model->unit;
				$inv->barcode=$model->barcode;
				$inv->category=$model->category;
				$inv->photo=$model->photo;
				$inv->supplier=$model->supplier;
				$inv->is_countable=$model->is_countable;
				$inv->shop_id=$model->shop_id;
				$inv->description=$model->description;
				$inv->staff=$model->staff;

				if(!$inv->save()){
	die('could not save to inventory');
}
}

				$this->redirect(array('view','id'=>$model->id));

			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->redirect(array('admin'));
		die;
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Store');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Store('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Store']))
			$model->attributes=$_GET['Store'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Store the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Store::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Store $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='store-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionIssue()
	{
		$this->render('issue');
	}

	public function actionGetitem()
	{
		$name=$_POST['item'];

		if(!empty($name)){
			$criteria = new CDbCriteria();
$criteria->condition = 'name LIKE :title'; // step 1
$criteria->params = array(':title' => '%'.$name.'%'); // step 2
$result = Store::model()->findAll($criteria);


			//$new=Inventory::model()->find('barcode=:kl',array(':kl'=>$bar));
			if($result!=null){

				foreach($result as $res)
		{
			?>
			<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
			text-align:center; cursor:pointer; width:50%; margin:auto;" onclick="findbar2('<?php echo $res->id; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
			<?php
		}


				
			}
		}
	}




	public function actionAllcart()
		{
			$positions=Yii::app()->shoppingCart->getPositions();
			
			?>
			<div style="height:300px; overflow:auto; overflow-x:hidden;">

		<table border="1" class="table" style="margin-bottom:0px;">
			





			<tr style="font-weight:bold; text-transform:uppercase;"><td></td><td>Item Name</td><td>Qty</td><td>CUR STK QTY</td><td>GEN STK QTY</td> <td>Price</td><td>Discount</td><td>Line Total</td> <td></td></tr>
			<?php $i=0; $flag=0;
			$tpos=0;
			
			foreach($positions as $position) { $i++; $color='#000'; 
			$stock=Store::model()->find('id=:u',array(':u'=>$position->getid()))->quantity;
//if($position->quantity<$position->getQuantity()){ $flag=1; $color='red'; }
if($stock<$position->getQuantity()){ $flag=1; $color='red'; ?><script type="text/javascript">
$("#checkout").attr("disabled",true);
</script> <?php }
			?>


		<tr>
			<td style=""><?php echo $i; //echo (!empty($position->photo)) ? CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:50px;height:auto; border-radius:5px;")) : "No Image"; ?></td>
			<td><?php echo ucfirst($position->name); ?></td>
			<!-- td style="color:<?php //echo $color; ?>"><input style="color:<?php //echo $color; ?>; width:30px;" type="text" value="<?php //echo $position->getQuantity(); ?>"  
				class="form-control" 
				onkeyup="update_cart('<?php //echo $position->getid(); ?>');" id="<?php //echo $position->getid(); ?>"></td -->
				<TD><input type="text" style="width:50px; color:<?php echo $color; ?>" class="form-control" value="<?php echo $position->getQuantity(); ?>" onkeyup="update_cart2st('<?php echo $position->getid(); ?>');" id="<?php echo $position->getid(); ?>" ></TD>
			<!--td><?php echo $position->quantity; ?></td-->
			<td><?php //echo Inventory::model()->find('shop_id=:f and barcode=:du',array(':f'=>Yii::app()->user->shop_id,':du'=>$position->barcode))->quantity;
			$sosum="select sum(quantity) from inventory where shop_id='".Yii::app()->user->shop_id."' and id='".$position->id."'";
			$mo_sum = Yii::app()->db->createCommand($sosum)->queryScalar();
			echo $mo_sum; 
			 ?></td>
			<td><?php //echo Inventory::model()->find('barcode=:u',array(':u'=>$position->barcode))->quantity; ?> <?php //$position->getid()))->quantity;
			$sosum1="select sum(quantity) from inventory where id='".$position->id."'";
			$mo_sum1 = Yii::app()->db->createCommand($sosum1)->queryScalar();
			echo $mo_sum1; 
			 ?>
			 </td>
			<td><?php echo number_format($position->price,2); ?></td>
			<td><input type="text" id="<?php echo "d".$position->id; ?>" style="width:60px;" onkeyup="add_discount('<?php echo $position->id; ?>')" value="<?php $tpos+=$position->disco; echo $position->disco; ?>"></td>
			<td><?= ($position->getQuantity()*$position->price)-$position->disco ?></td>
			<td><span onclick="del('<?php echo $position->getid(); ?>');" style="cursor:pointer; color:blue;" title="Delete">X</span></td>
		</tr>


			
				<?php
			}
			?>


			<tr>
				<td><?=  CHtml::dropDownList('Inventory[staff]',null, CHtml::listData(User::model()->findAll(), 'id', 'username'), array('empty'=>'','id'=>'use'));  ?></td>
				<td><input type="button" class="btn btn-primary" value="Issue Stock" onclick="do_issue();" id="checkout"  style="margin-left:0px;"></td>
			</tr>
			<!--tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Sub Total</td><td id="sub"><?php echo number_format(Yii::app()->shoppingCart->getCost(),2); ?>
			</td><td></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discount</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $discount; ?>" disabled="disabled">%</td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discounted Total</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $dp=(Yii::app()->shoppingCart->getCost()-(Yii::app()->shoppingCart->getCost()*$discount)/100); ?>" disabled="disabled"></td></tr>
			

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Tax</td><td><del>N</del><input type="text" style="width:70px;" class="form-control" id="tax" value="<?php  $ttax=$sub=($tax*$dp)/100; echo round($ttax,2); ?>" disabled="disabled"></td></tr -->

			</table>
</div>
			



			<table style="width:100%;">
			
			
			

		</table>

			<?php
		}


		// second all cart

		public function actionAllcart2()
		{
			$positions=Yii::app()->shoppingCart->getPositions();
			
			?>
			<div style="height:300px; overflow:auto; overflow-x:hidden;">

		<table border="1" class="table" style="margin-bottom:0px;">
			





			<tr style="font-weight:bold; text-transform:uppercase;"><td></td><td>Item Name</td><td>Qty</td><td>CUR STK QTY</td><td>GEN STK QTY</td> <td>Price</td><td>Discount</td><td>Line Total</td> <td></td></tr>
			<?php $i=0; $flag=0;
			$tpos=0;
			
			foreach($positions as $position) { $i++; $color='#000'; 
			$stock=Store::model()->find('id=:u',array(':u'=>$position->getid()))->quantity;
//if($position->quantity<$position->getQuantity()){ $flag=1; $color='red'; }
if($stock<$position->getQuantity()){ $flag=1; $color='red'; ?><script type="text/javascript">
$("#checkout").attr("disabled",true);
</script> <?php }
			?>


		<tr>
			<td style=""><?php echo $i; //echo (!empty($position->photo)) ? CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:50px;height:auto; border-radius:5px;")) : "No Image"; ?></td>
			<td><?php echo ucfirst($position->name); ?></td>
			<!-- td style="color:<?php //echo $color; ?>"><input style="color:<?php //echo $color; ?>; width:30px;" type="text" value="<?php //echo $position->getQuantity(); ?>"  
				class="form-control" 
				onkeyup="update_cart('<?php //echo $position->getid(); ?>');" id="<?php //echo $position->getid(); ?>"></td -->
				<TD><input type="text" style="width:50px; color:<?php echo $color; ?>" class="form-control" value="<?php echo $position->getQuantity(); ?>" onkeyup="update_cart2st('<?php echo $position->getid(); ?>');" id="<?php echo $position->getid(); ?>" ></TD>
			<!--td><?php echo $position->quantity; ?></td-->
			<td><?php //echo Inventory::model()->find('shop_id=:f and barcode=:du',array(':f'=>Yii::app()->user->shop_id,':du'=>$position->barcode))->quantity;
			$sosum="select sum(quantity) from store where shop_id='".Yii::app()->user->shop_id."' and id='".$position->id."'";
			$mo_sum = Yii::app()->db->createCommand($sosum)->queryScalar();
			echo $mo_sum; 
			 ?></td>
			<td><?php //echo Inventory::model()->find('barcode=:u',array(':u'=>$position->barcode))->quantity; ?> <?php //$position->getid()))->quantity;
			$sosum1="select sum(quantity) from store where id='".$position->id."'";
			$mo_sum1 = Yii::app()->db->createCommand($sosum1)->queryScalar();
			echo $mo_sum1; 
			 ?>
			 </td>
			<td><?php echo number_format($position->price,2); ?></td>
			
			<td><?= ($position->getQuantity()*$position->price)-$position->disco ?></td>
			<td><span onclick="del2('<?php echo $position->getid(); ?>');" style="cursor:pointer; color:blue;" title="Delete">X</span></td>
		</tr>


			
				<?php
			}
			?>


			<tr>
				<td><?=  CHtml::dropDownList('Inventory[staff]',null, CHtml::listData(User::model()->findAll(), 'id', 'username'), array('empty'=>'','id'=>'use'));  ?></td>
				<td><input type="button" class="btn btn-primary" value="Issue Stock" onclick="do_issue();" id="checkout"  style="margin-left:0px;"></td>
			</tr>
			<!--tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Sub Total</td><td id="sub"><?php echo number_format(Yii::app()->shoppingCart->getCost(),2); ?>
			</td><td></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discount</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $discount; ?>" disabled="disabled">%</td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discounted Total</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $dp=(Yii::app()->shoppingCart->getCost()-(Yii::app()->shoppingCart->getCost()*$discount)/100); ?>" disabled="disabled"></td></tr>
			

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Tax</td><td><del>N</del><input type="text" style="width:70px;" class="form-control" id="tax" value="<?php  $ttax=$sub=($tax*$dp)/100; echo round($ttax,2); ?>" disabled="disabled"></td></tr -->

			</table>
</div>
			



			<table style="width:100%;">
			
			
			

		</table>

			<?php
		}





		public function actionGetorder2()
	{
			

		$bad=$_POST['barcode'];
		
	$response=Store::model()->find('id=:bcode',array(':bcode'=>$bad));


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
					$this->redirect(array('allcart2'));
		
		}



	public function actionGetorder3()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		//$this->renderPartial('ocalc',array(
			//'dataProvider'=>$dataProvider,
		//));


			

		$qtyf=$_POST['quantity'];
		$idf=$_POST['id'];
		if($qtyf<1){ $qtyf=1; } // please
		
	//$response=Inventory::model()->find('name=:bcode',array(':bcode'=>$bad));
		//$book = Book::model()->findByPk(1);
		$check=Yii::app()->shoppingCart->itemAt($idf); 
		if($check->quantity>=$qtyf)
		{
			$check->disco=0;
		Yii::app()->shoppingCart->update($check,$qtyf); //1 item with id=1, quantity=2.
	}
	//$check=Yii::app()->shoppingCart->itemAt($response->id);  //echo $check->quantity;
	
		
		//Yii::app()->shoppingCart->put($response); //1 item with id=1, quantity=1.
		$positions = Yii::app()->shoppingCart->getPositions();
			
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
		$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
	
		$this->redirect(array('allcart2'));
		
		}




		public function actionDele()
		{
			$id=$_POST['barcode'];
			Yii::app()->shoppingCart->remove($id);
			//var_dump($id); die();
			
			

			$this->redirect(array('allcart2'));

		}


		public function actionMove_issue()
		{
			$user=$_POST['user'];
			$positions=Yii::app()->shoppingCart->getPositions();

			$transaction_id=time().rand(1,9);

			foreach($positions as $position){
				$check=Midstore::model()->find('item_id=:j and receive=:m and status=:k',array(':j'=>$position->getid(),':m'=>$user,':k'=>0));
				// if($check!=null)
				// {
				// 	$check->quantity+=$position->getQuantity();
				// 	$check->save();
				// }else{
				$hold=Store::model()->findByPk($position->getid())->quantity;


			$store =  new Midstore;

			$store->name=$position->name;
			$store->barcode=$position->barcode;
			$store->description=$position->description;
			$store->quantity=$position->getQuantity();
			$store->supply_price=$position->supply_price;
			$store->reorder=$position->reorder;
			$store->staff=$position->staff;
			$store->price=$position->price;
			$store->category=$position->category;
			$store->supplier=$position->supplier;
			$store->photo=$position->photo;
			$store->single_item_discount=$position->single_item_discount;
			$store->shelf_number=$position->shelf_number;
			$store->shop_id=$position->shop_id;
			$store->transaction_id=$transaction_id;
			$store->receive=$user;
			$store->item_id=$position->getid();
			$store->unit=$position->unit;
			$store->is_countable=$position->is_countable;
			$store->created_at=date('Y-m-d');
			$store->start_quantity=$hold;
			if(!$store->save()){ var_dump($store->getErrors()); die; 
			}else{
				Yii::app()->shoppingCart->clear();
			}

			

		//}

		}

		}


		public function actionReceive()
		{
			$stock=Midstore::model()->findAll('receive=:r and status=:s',array(':r'=>Yii::app()->user->id,':s'=>0));
			$this->render('receive',array('stock'=>$stock));
		}


		public function actionShift($id)
		{
			$target=Midstore::model()->find('id=:g',array(':g'=>$id));
			$check=Inventory::model()->find('item_id=:u',array(':u'=>$target->item_id));
			$store=Store::model()->findByPk($target->item_id)->quantity;
			$hold=$check->quantity;
			if($check!=null)
			{
				$check->quantity+=$target->quantity;
				if(!$check->save()){ var_dump($check->getErrors()); die; }
			}else{
				$data = $target->attributes;
				$move = new Inventory;
				$move->setAttributes($data);
				//$move->start_quantity=$hold;	


				if(!$move->save())
				{
					var_dump($move->getErrors()); die;
				}
			}



			$in= new Buys;
				$in->item_id=$target->item_id;
				$in->current_quantity=$store;
				$in->outs=$target->quantity;
				$in->created_at=date('Y-m-d');
				if(!$in->save())
				{
					var_dump($in->getErrors());
					die('can not save');
				}



			$store=Store::model()->findByPk($target->item_id);
				$store->quantity-=$target->quantity;

				
				$store->save();

			$target->status=1;
			if(!$target->save())
			{
				var_dump($target->getErrors());  die;
			}


			$this->redirect(array('store/receive'));
		}


		public function actionReport()
		{
			$model = new Midstore;
			if(isset($_GET['Midstore'])){ 
				$model->attributes=$_GET['Midstore'];
				//var_dump($_GET['Expenses']); die;
				$date1=$_GET['Midstore']['date1'];
				$date2=$_GET['Midstore']['date2']; 
		 // $entry_sql="select sum(outs) as ins, outs, created_at, id, status, start_quantity, name from midstore where substr(created_at,1,10) between '".$date1."' and '".$date2."' and status=1  group by item_id";
				$entry_sql="select  created_at, id, name, quantity, staff,receive, start_quantity from midstore where substr(created_at,1,10) between '".$date1."' and '".$date2."' and status=1";
		 $report = Yii::app()->db->createCommand($entry_sql)->queryAll(); 
		 //var_dump($report); die;
			
			$this->render('report',array('report'=>$report,'model'=>$model));
		}else{
			$this->render('report',array('model'=>$model));
		}
		}

		public function actionSout()
		{
			$model = new Midstore;
			 if(isset($_GET['Midstore'])){
				$model->attributes=$_GET['Midstore'];
				//var_dump($_GET['Expenses']); die;
				$date1=$_GET['Midstore']['date1'];
				$date2=$_GET['Midstore']['date2']; 
		 // $entry_sql="select sum(outs) as ins, outs, created_at, id, status, start_quantity, name from midstore where substr(created_at,1,10) between '".$date1."' and '".$date2."' and status=1  group by item_id";
				$entry_sql="select sum(ins) as ins, sum(outs) as outs, created_at, id, current_quantity, item_id from buys where substr(created_at,1,10) between '".$date1."' and '".$date2."'  group by item_id";
		 $report = Yii::app()->db->createCommand($entry_sql)->queryAll(); 
			
			$this->render('sout',array('report'=>$report,'model'=>$model));
		}else{
			$this->render('sout',array('model'=>$model));
		}
		}


		public function actionCancel($id)
		{
			$target=Midstore::model()->find('id=:g',array(':g'=>$id));
			$target->status=3;
			if(!$target->save())
			{
				var_dump($target->getErrors());  die;
			}

			$this->redirect(array('receive'));
		}


		// public function actionSin()
		// {
		// 	$model = new Midstore;
		// 	 if(isset($_GET['Midstore'])){
		// 		$model->attributes=$_GET['Midstore'];
		// 		//var_dump($_GET['Expenses']); die;
		// 		$date1=$_GET['Midstore']['date1'];
		// 		$date2=$_GET['Midstore']['date2']; 
		//   $entry_sql="select sum(ins) as ins, sum(outs) as outs, created_at, id, current_quantity, item_id from buys where substr(created_at,1,10) between '".$date1."' and '".$date2."'  group by item_id";

		//  $report = Yii::app()->db->createCommand($entry_sql)->queryAll(); 
			
		// 	$this->render('sin',array('report'=>$report,'model'=>$model));
		// }else{
		// 	$this->render('sin',array('model'=>$model));
		// }
		// }


}
