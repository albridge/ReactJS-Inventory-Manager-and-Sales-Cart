<?php
date_default_timezone_set('Africa/Lagos');
//require __DIR__ . '/../vendor/mike42/escpos/autoload.php';
require_once Yii::app()->basePath . '/config/global.php' ;

require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;


//Yii::setPathOfAlias('ext.yiiext', dirname(__FILE__).'/../extensions/shoppingCart');
class InventoryController extends Controller
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
		// return array(
		// 	array('allow',  // allow all users to perform 'index' and 'view' actions
		// 		'actions'=>array('index','view','topdf','display','nosale','ears','grace','Fp'),
		// 		'users'=>array('*'),
		// 	),
		// 	array('allow', // allow authenticated user to perform 'create' and 'update' actions
		// 		'actions'=>array('update','getorder','getorder2','getorder3','clearcart','dele','CheckOut','checkout2','checkout3','tracksale','getnew','getnew2','updateinv','vchange',
		// 			'donewcust',
		// 			'getname','newtotal','showname','recent','suspend','suspended','tocart','changepass','password','viewsales',
		// 			'topdfmonth','topdfweek','printa','printa2','printa3','backup','pickcat','printall',
		// 			'add_discount','david2','viewcustomer','getname2','custdeal','viewinvoice',
		// 			'dobalance','reorder','stocklist','bin'),
		// 		'users'=>array('@'),				
		// 	),
		// 	array('allow', // allow authenticated user to perform 'create' and 'update' actions
		// 		'actions'=>array('create','update','getorder','getorder2','getorder3','clearcart','dele','CheckOut','checkout2','checkout3','tracksale','reports','reportsweekly',
		// 			'reportsmonthly','reportsyearly','newsupply','getnew','getnew2','updateinv','admin','donewcust','getname','newtotal',
		// 			'showname','recent','suspend','suspended','tocart','pickcat','dobarcode','disk'),
		// 		'users'=>array('@'),
		// 		'expression'=>'isset($user->role) && ($user->role==="admin" || $user->role==="store")'
		// 	),
		// 	array('allow', // allow authenticated user to perform 'create' and 'update' actions
		// 		'actions'=>array('update','getorder','getorder2','getorder3','clearcart','dele','CheckOut','checkout2','checkout3','tracksale','getnew','updateinv','sale','sale2','donewcust',
		// 			'getname','newtotal','getnew2','showname','recent','suspend','suspended','tocart','pickcat'),
		// 		'users'=>array('@'),
		// 		'expression'=>'isset($user->role) && ($user->role==="admin" || $user->role==="sales")'
		// 	),
		// 	array('allow', // allow admin user to perform 'admin' and 'delete' actions
		// 		'actions'=>array('delete','toreturns','doreturns','display','resetu','doreturns2'),
		// 		'users'=>array('admin'),
		// 	),
		// 	array('deny',  // deny all users
		// 		'users'=>array('*'),
		// 	),
		// );

		return array(
		// array('allow',
		// 	'actions'=>array('admin'),
		// 	'roles'=>array('staff', 'devel'),
		// ),
		array('allow',
			'actions'=>array('reports','admin','create','all_issued','do_cancel',
				'reportsmonthly','reportsyearly','debtors_list','debt_details',
				'reportsweekly','printa3_all','newsupply'),
			'roles'=>array('admin','store_admin','store'),
		),
			array('allow',
			'actions'=>array('reports',
				'reportsmonthly','reportsyearly','debtors_list','debt_details',
				'reportsweekly'),
			'roles'=>array('accounts'),
		),
		array('allow',
			'actions'=>array('update','getorder','getorder2','getorder3','clearcart','dele',
				'CheckOut','checkout2','checkout3','tracksale','getnew','getnew2','updateinv',
				'vchange','donewcust','getname','newtotal','showname','recent','suspend',
				'suspended','tocart','changepass','password','viewsales','topdfmonth','topdfweek',
				'printa','printa2','printa3','backup','pickcat','printall','add_discount','david2',
				'viewcustomer','getname2','custdeal','viewinvoice','disk','issue','get_issue_item',
				'dobalance','reorder','stocklist','bin','view','sale','reports','get_outstanding',
				'Show_issued_items','is_issue','clear_issue','send_issue','see_issues','do_receive',
				'to_issues','see_days','allcart','toreturns','see_days_details','doreturns2',
				'getorder_rest','clearcart_rest','getorder3_rest','checkout_rest','forclose','getorder3_rest2',
				'doreturns2_one','toreturns2','toreturnsgo','dtype','stocklist2','analysis'),
			'users'=>array('@'),
		),
			array('allow',  // deny all users
				'actions'=>array('ears'),
			'users'=>array('?'),
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


	public function actionToreturns()
	{
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));


		$model=new Sales();
			$model->unsetAttributes();
			if(isset($_GET['Sales']))
				{	
					// $tracksql="select *from sales where transaction_id='".$tid."'";
		 			 //$track=Yii::app()->db->createCommand($tracksql)->queryAll();
					$model->attributes=$_GET['Sales'];
					//echo $model->transaction_id; die;
					$tid=$model->transaction_id;
					$track=Sales::model()->findAll('transaction_id=:j',array(':j'=>$tid));
				
			$this->render('toreturns',array(
				'model'=>$model,
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				'track'=>$track,
				'tid'=>$tid,
				),false,true);
		}else{
		$this->render('toreturns',array(
			'model'=>$model,
			));
	}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		die('not allowed. All items are created in Store not sales point');
		/*die('not allowed');
		if(Yii::app()->user->shop_id!=1)
		{
			die('You are not allowed to do this');
		} */
		$model=new Inventory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			$model->staff=Yii::app()->user->id;
			$model->shop_id=Yii::app()->user->shop_id;
			$model->created_at=date("Y-m-d H:i:s");

			$check=Inventory::model()->find('name=:j and shop_id=:r',array(':j'=>$model->name,':r'=>Yii::app()->user->shop_id));
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
		die('not allowed. All items are updated at store');

		/*
		if(Yii::app()->user->shop_id!=1)
		{
			die('You are not allowed to do this!');
		}
		*/
		$model=$this->loadModel($id);
		$ch=$model->photo;
		$quantity=$model->quantity;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			$model->updated_at=date("Y-m-d H:i:s");
			$model->name=ucwords($model->name);
			$model->quantity=$quantity;


			$model->photo=$ch;
			$uploadedFile=CUploadedFile::getInstance($model,'photo')->name; //die;
			
			if(!empty($uploadedFile)){
				$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$model->photo=$uploadedFile;
			$fileName=$model->photo;
			//var_dump($uploadedFile); die;
			  $uploadedFile->saveAs(Yii::app()->basePath.'/../assets/products/'.$fileName);  // image will uplode to rootDirectory/banner/
			}

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Inventory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}



	public function actionSale()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		$conf=Config::model()->find('id=:l',array(':l'=>1));

		 if($conf->shop==2){ $this->redirect(array('sale2')); }

		$this->layout='column1';
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
		$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;

		
		//$tdsale=Sales::model()->find('staff=:j',[':j'=>Yii::app()->user->id]);
		//SUBSTR(created_at,1,10)='".$dyear."'
		$today=date("Y-m-d");
		 $tdsaleq="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' ";
		 $tdsale = Yii::app()->db->createCommand($tdsaleq)->queryScalar();

		//  $returnsql="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' and saletype=2";
		// $returns = Yii::app()->db->createCommand($returnsql)->queryScalar();


		 $criteria=new CDbCriteria();
		 $criteria->condition='staff=:t';
		 $criteria->params=array(':t'=>Yii::app()->user->id);
		 $criteria->group='transaction_id desc';
		 $criteria->limit='5';
		 $lastsales=Sales::model()->findAll($criteria);

		// $sell='sell';
		 
		 $tdsales=$tdsale; //-$returns;
		

		$model=new Sales();
		$model2=new Customers();
		$this->render('sell',array(
			'model'=>$model,
			'model2'=>$model2,
			'tax'=>$tax,
			'discount'=>$discount,
			'tdsale'=>$tdsales,
			'lastsales'=>$lastsales,
			
		));
	}

/*
	public function actionVchange()
	{
		
		$title=$_POST['title'];
		//echo $title; die();
		

if(!empty($title)){
$criteria = new CDbCriteria();
$criteria->condition = 'name LIKE :title'; // step 1
$criteria->params = array(':title' => '%'.$title.'%'); // step 2
$result = Inventory::model()->findAll($criteria);

		//$title=$_POST['title'];
foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:blue; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:90%; margin:auto;" onclick="placeit('<?php echo $res->barcode; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
	<?php
}
}		
	}
*/




		public function actionSale2()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		$this->layout='column1';
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
		$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
		//$tdsale=Sales::model()->find('staff=:j',[':j'=>Yii::app()->user->id]);
		//SUBSTR(created_at,1,10)='".$dyear."'
		$today=date("Y-m-d");
		 $tdsaleq="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' ";
		 $tdsale = Yii::app()->db->createCommand($tdsaleq)->queryScalar();

		 // $returnsql="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' and saletype=2";
		// $returns = Yii::app()->db->createCommand($returnsql)->queryScalar();

		 $criteria1=new CDbCriteria();
		// $criteria1->limit='35';
		 $criteria1->order='name asc';
		 $stock=Inventory::model()->findAll($criteria1);


		 $criteria=new CDbCriteria();
		 $criteria->condition='staff=:t';
		 $criteria->params=array(':t'=>Yii::app()->user->id);
		 $criteria->group='transaction_id desc';
		 $criteria->limit='5';
		 $lastsales=Sales::model()->findAll($criteria);
		 
		$tdsales=$tdsale;

		

		$model=new Sales();
		$model2=new Customers();

		$this->render('sell2',array(
			'model'=>$model,
			'model2'=>$model2,
			
			'tax'=>$tax,
			'discount'=>$discount,
			'tdsale'=>$tdsales,
			'lastsales'=>$lastsales,
			'stock'=>$stock,
			
		));
	}


	public function actionRecent($id)
	{
		
		/*
		 $criteria=new CDbCriteria();
		 $criteria->condition='staff=:t';
		 $criteria->params=array(':t'=>Yii::app()->user->id);
		 $criteria->group='transaction_id desc';
		 $criteria->limit='5';
		 $lastsales=Sales::model()->findAll($criteria);
		 */

		 $tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		$details=Salesx::model()->findAll('transaction_id=:k and shop_id=:g',array(':k'=>$id,':g'=>Yii::app()->user->shop_id));
		$this->render('recent',array(
			'details'=>$details,
			'tax'=>$tax,
			'discount'=>$discount,
			'conf'=>$conf,
			'tid'=>$id,
			));
	}

	public function actionForclose()
	{
		
		/*
		 $criteria=new CDbCriteria();
		 $criteria->condition='staff=:t';
		 $criteria->params=array(':t'=>Yii::app()->user->id);
		 $criteria->group='transaction_id desc';
		 $criteria->limit='5';
		 $lastsales=Sales::model()->findAll($criteria);
		 */


		// if(Yii::app()->user->role!='admin'){ die('You are not allowed to do this'); }

		 $id=$_POST['id'];
		

		 $tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		$details=Salesx::model()->findAll('transaction_id=:k and shop_id=:g',array(':k'=>$id,':g'=>Yii::app()->user->shop_id));
		$this->render('recent',array(
			'details'=>$details,
			'tax'=>$tax,
			'discount'=>$discount,
			'conf'=>$conf,
			'tid'=>$id,
			));
	}

	public function actionVchange()
	{
		
		$title=$_POST['title'];
		//echo $title; die();
		
/*
	$Criteria->Condition('name LIKE :value OR description LIKE :value');
	//$Criteria->addCondition('user = :user1 OR user = :user2');

	$Criteria->params = array(
    ':value' => '%'.$title.'%',
    //':user1' => $user1,
    //':user2' => $user2,
);
*/
if(!empty($title)){
$criteria = new CDbCriteria();
$criteria->condition = 'name LIKE :title and shop_id=:p'; // step 1
$criteria->params = array(':title' => '%'.$title.'%',':p'=>Yii::app()->user->shop_id); // step 2
$criteria->limit = '3';
$result = Inventory::model()->findAll($criteria);

		//$title=$_POST['title'];
/*

foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:blue; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:90%; margin:auto;" onclick="say('<?php echo $res->barcode; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
	<?php
}


*/
foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:90%; margin:auto;" onclick="findbar2('<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
	<?php
}
}		
	}


	public function actionPickcat()
	{
		$cat=$_POST['cat'];

		$criteria = new CDbCriteria();
		$criteria->condition = 'category = :title'; // step 1
		$criteria->params = array(':title' => $cat); // step 2
		$criteria->order='name asc';

		$getcat=Inventory::model()->findAll($criteria);

		foreach($getcat as $get)
		{
			{ ?>
	<span class="btn btn-primary" style="display:inline-block; margin-top:5px;" onclick="findbar2('<?php echo $get->name; ?>');"><?php echo $get->name; ?></span>
	<?php
}
		}

	}



public function actionViewsales()
{
	$model=new Sales();

	if(isset($_GET['Inventory']))
				{			
			
			$dyear=$_GET['Inventory']['created_at'];

			
			
			$criteria = new CDbCriteria();
       $criteria->condition = 'SUBSTR(created_at,1,10) = :id';
      // $criteria->order = 'id DESC';
      // $criteria->where='saletype=1'; 
       $criteria->params = array (':id'=>$dyear);
       
        $item_count = Sales::model()->count($criteria);
                
        $pages = new CPagination($item_count);
        $pages->setPageSize(Yii::app()->params['listPerPage']);
        $pages->applyLimit($criteria);  // the trick is here!        
  

        $sall="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."' and staff='".Yii::app()->user->id."'";
		 $all = Yii::app()->db->createCommand($sall)->queryScalar();

		 

		 $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."'  and staff='".Yii::app()->user->id."'";
		 $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();

		//  $rsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."' and saletype=2 and staff='".Yii::app()->user->id."'";
		// $returns = Yii::app()->db->createCommand($rsql)->queryScalar();


		 $listsq="select *from sales where SUBSTR(created_at,1,10)='".$dyear."' and staff='".Yii::app()->user->id."'";
		 $list = Yii::app()->db->createCommand($listsq)->queryAll();

		
		 $netsale=$sales_t-$returns;
		
		}
		// e
	$this->render('viewsales',array(
		'model'=>$model,
		'all'=>$all,
		'returns'=>$returns,
		'netsale'=>$netsale,
		'list'=>$list,
		'dyear'=>$dyear,
		));
}



	public function actionGetname()
	{
		
		$name=$_POST['name'];
		//echo $title; die();
		
/*
	$Criteria->Condition('name LIKE :value OR description LIKE :value');
	//$Criteria->addCondition('user = :user1 OR user = :user2');

	$Criteria->params = array(
    ':value' => '%'.$title.'%',
    //':user1' => $user1,
    //':user2' => $user2,
);
*/
if(!empty($name)){
$criteria = new CDbCriteria();
$criteria->condition = 'cname LIKE :title and shop_id=:g'; // step 1
$criteria->limit = '5';
$criteria->params = array(':title' => '%'.$name.'%',':g'=>Yii::app()->user->shop_id); // step 2
$result = Customers::model()->findAll($criteria);

		//$title=$_POST['title'];
/*

foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:blue; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:90%; margin:auto;" onclick="say('<?php echo $res->barcode; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
	<?php
}


*/
foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer;" onclick="getname('<?php echo $res->id; ?>','<?php echo ucwords($res->cname); ?>')"><?php echo $res->cname; ?></span>
	<?php
}
}		
	}







	function actionDonewcust()
	{
		$customer=new Customers();

		$customer->cname=$_POST['dname'];
		$customer->cemail=$_POST['demail'];
		$customer->caddress=$_POST['daddress'];
		$customer->cphone1=$_POST['dphone1'];
		$customer->cphone2=$_POST['dphone2'];
		$customer->shop_id=Yii::app()->user->shop_id;


		/*
		$customer->cname=$_POST['dname'];
		$customer->cemail=$_POST['demail'];
		$customer->caddress=$_POST['daddress'];
		$customer->cphone1=$_POST['dphone1'];
		$customer->cphone2=$_POST['dphone2'];
		*/

		$customer->save();



	}



	public function actionGetorder()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		//$this->renderPartial('ocalc',array(
			//'dataProvider'=>$dataProvider,
		//));


			

		$bad=$_POST['barcode'];
		
	$response=Inventory::model()->find('barcode=:bcode',array(':bcode'=>$bad));


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
					$this->redirect(array('allcart'));
		
		}




		public function actionGetorder2()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		//$this->renderPartial('ocalc',array(
			//'dataProvider'=>$dataProvider,
		//));


			

		$bad=$_POST['barcode'];
		
	$response=Inventory::model()->find('name=:bcode',array(':bcode'=>$bad));

		//$check=Yii::app()->shoppingCart->itemAt((int)$response->id);
	$check=Yii::app()->shoppingCart->itemAt($response->id);  //echo $check->quantity;
	//if(($response->quantity>0) || ($check->quantity>$response->quantity))
		//if(($response->quantity>0) && ($response->quantity>=$check->quantity))
	
	$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
	$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
// start here
	$positions = Yii::app()->shoppingCart->getPositions();
	$itq=0;

	foreach($positions as $pos)
	{
		if($pos->name==$check->name)
		{
			$itq=$pos->getQuantity();
		}
	}
	
//{
		if($itq<$response->quantity)
		{
		Yii::app()->shoppingCart->put($response); //1 item with id=1, quantity=1.
	}else{
		?>
<script type="text/javascript">
alert('<?php echo ucfirst($response->name); ?> is out of stock!');
</script>

		<?php
	}
		$this->redirect(array('allcart'));
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
	
		$this->redirect(array('allcart'));
		
		}

	public function actionGetorder3_rest()
	{			

		$qtyf=$_POST['quantity'];
		$idf=$_POST['id'];
		if($qtyf<1){ $qtyf=0; } // please
		
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

		$newquant=$qtyf;
		$data1=array('total'=>number_format(Yii::app()->shoppingCart->getCost(),2),'newquant'=>$newquant);
		//$data1=array('total'=>number_format($newquant*$check->price,2),'newquant'=>$newquant,'tot'=>number_format(Yii::app()->shoppingCart->getCost(),2));
		$data=json_encode($data1);
		echo $data;
		
		
		}



		public function actionGetorder3_rest2()
	{			

		$qtyf=$_POST['quantity'];
		$idf=$_POST['id'];
		if($qtyf<1){ $qtyf=0; } // please
		
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

		$newquant=$qtyf;
		//$data1=array('total'=>number_format(Yii::app()->shoppingCart->getCost(),2),'newquant'=>$newquant);
		$data1=array('total'=>number_format($newquant*$check->price,2),'newquant'=>$newquant,'tot'=>number_format(Yii::app()->shoppingCart->getCost(),2));
		$data=json_encode($data1);
		echo $data;
		
		
		}


	public function actionGetorder_rest()
	{
	//	$dataProvider=new CActiveDataProvider('Inventory');
		//$this->renderPartial('ocalc',array(
			//'dataProvider'=>$dataProvider,
		//));


			

		$bad=$_POST['barcode'];
		
	//$response=Inventory::model()->find('barcode=:bcode',array(':bcode'=>$bad));
	$response=Inventory::model()->find('id=:bcode',array(':bcode'=>$bad));

$out=0;
		//$check=Yii::app()->shoppingCart->itemAt((int)$response->id);

	$check=Yii::app()->shoppingCart->itemAt($response->id);  //echo $check->quantity;
	//if(($response->quantity>0) || ($check->quantity>$response->quantity))
		//if(($response->quantity>0) && ($response->quantity>=$check->quantity))
	$positions = Yii::app()->shoppingCart->getPositions();
	$itq=0;

	foreach($positions as $pos)
	{
		if($pos->id==$bad)
		{
			$itq=$pos->getQuantity();
		}
	}
	
	
//{
		
		if($response->quantity>$itq)
		{
		Yii::app()->shoppingCart->put($response); //1 item with id=1, quantity=1.
		$newquant=$itq+1;
					}else{
						$out=1;
		
						
					}
					// $this->redirect(array('allcart'));
		
		$data1=array('total'=>number_format(Yii::app()->shoppingCart->getCost(),2),'newquant'=>$newquant,'out'=>$out);
		$data=json_encode($data1);
		echo $data;
		
		}


		public function actionadd_discount()
		{
			$disc=$_POST['discount'];
			$idf=$_POST['id'];
			$quan=$_POST['quantity'];

			$check=Yii::app()->shoppingCart->itemAt($idf); 
			// $check->disco=$disc;
			$check->disco=$disc;			
			Yii::app()->shoppingCart->update($check,$quan); //1 item with id=1, quantity=2.

			// $response=Inventory::model()->find('name=:bcode',array(':bcode'=>$bad));
			// $check=Yii::app()->shoppingCart->itemAt((int)$response->id);
			// $check=Yii::app()->shoppingCart->itemAt($response->id); 
			$this->redirect(array('allcart'));
		}





		public function actionClearcart()
		{
			Yii::app()->shoppingCart->clear();
			$this->redirect(array('allcart'));

		}

		public function actionClearcart_rest()
		{
			Yii::app()->shoppingCart->clear();
			$this->redirect(array('front/index'));

		}


		public function actionDele()
		{
			$id=$_POST['barcode'];
			Yii::app()->shoppingCart->remove($id);
			//var_dump($id); die();
			
			

			$this->redirect(array('allcart'));

		}


/*
		public function actioncheckout()
		{
			//if(isset($_POST['sales']))
			//{
			$tax=Config::model()->find('id=:l',[':l'=>1])->tax;

			$stype=$_POST['ttype'];
			$ptype=$_POST['payt'];
			$custid=$_POST['name'];
			$transaction_id=time().rand(1,9);

		//	$receipt='';
		//	$myFile = Yii::app()->basePath . '/views/checkouts/testFile.txt';	

			$handle = printer_open('mark');
			printer_start_doc($handle, "Receipt");
			printer_start_page($handle);	
			printer_set_option($handle, PRINTER_MODE, "RAW");

					
					$head="SALES RECEIPT".PHP_EOL;	
					printer_write($handle, $head);
					
					$tran="Transaction ID\t".$transaction_id.PHP_EOL;	
					printer_write($handle, $tran);

					$line='------------------'.PHP_EOL;
					printer_write($handle, $line);

					$head2="Item Name\t\t Qty".PHP_EOL;
					printer_write($handle, $head2);

					printer_write($handle, $line);
							
						

				$positions = Yii::app()->shoppingCart->getPositions();
				
				foreach($positions as $position)
				{
					$plustax=(($position->price*$tax)/100);
					$date=time();
					$sale= new Sales();
					$sale->item_name=$position->name;
					$sale->item_id=$position->getid();
					$sale->transaction_id=$transaction_id;
					$sale->qty=$position->getQuantity();
					$sale->unit_price=($position->price+$plustax);
					$sale->total=Yii::app()->shoppingCart->getCost();
					$sale->staff=Yii::app()->user->id;
					$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->created_at=date("Y-m-d H:i:s");
				//	$sale->updated_at=date("Y-m-d H:i:s");
					$s1=$sale->save();

					$inv=Inventory::model()->find('id=:k',array(':k'=>$position->id));
					$newquantity=$inv->quantity-$position->getQuantity();
					$inv->quantity=$newquantity;
					$inv->updated_at=date("Y-m-d H:i:s");
					$s2=$inv->save();
					

					$res=$position->name."\t".$position->getQuantity().PHP_EOL;	
					printer_write($handle, $res);				
					
				}				

					$rec1="Total items\t".Yii::app()->shoppingCart->getCount().PHP_EOL;
					printer_write($handle, $rec1);

					$rec2="Total\t".number_format(Yii::app()->shoppingCart->getCost(),2).PHP_EOL;	
					printer_write($handle, $rec2);

					printer_end_page($handle);
					printer_end_doc($handle);
					printer_close($handle);	
					

			if($s1 && $s2){ echo "<span style='font-size:20px; font-weight:bold; color:red;'>Transaction Successfully Completed</span>"; }
			else{ echo "Transaction failed"; }
			//}
		}


*/

		public function actionprinta()
		
		{
			//$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			//$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;
			
			//$conf=Config::model()->find('id=:l',array(':l'=>1))

			$conf=Config::model()->find('id=:l',array(':l'=>1));
			$shop=Shops::model()->findByPk(Yii::app()->user->shop_id);;

		
			$criteria1=new CDbCriteria(); 
$criteria1->order='id desc';
$criteria1->condition='staff=:k';
$criteria1->params=array(':k'=>Yii::app()->user->id);
$lid2 = Salesx::model()->find($criteria1);

$transid=$lid2->transaction_id;
$time=$lid2->created_at;


$criteria=new CDbCriteria(); 
//$criteria->order='id desc';
	//$criteria->condition='transaction_id=:p';
	//$criteria->params=array(':p'=>$transid);

$criteria->condition='created_at=:p';
$criteria->params=array(':p'=>$time);
//$criteria->group='item_id';
$criteria->group='category';

//$dprinter=Printers::model()->findByPk($printer->printer)->printer_name;
$positions = Salesx::model()->findAll($criteria);
//$transid=$lid2->transaction_id;

try {
    // Enter the share name for your USB printer here
   // $connector = "mark";
   // $connector = new WindowsPrintConnector("taire");
	$connector = new WindowsPrintConnector("smb://mike:12345@system1/austine");
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);

    $printer->setJustification(1);
    //$image="trinity.jpg";
   // $printer -> text($conf->company_name."\n");
    //$img = EscposImage::load(Yii::app()->baseUrl . "/assets/logo/trinity.jpg");
    // $img = EscposImage::load("trinity.jpg");
    $img = EscposImage::load(dirname(FILE) . "/assets/logo/trinity.jpg", false);

	
	$printer->bitImage($img);
	//$printer -> text("\n");	

    $printer -> setTextSize(2, 2);
    $printer -> setEmphasis(true);

    //$printer -> text($shop->name."\n");
    $printer -> text("\n");
    $printer -> setEmphasis(false);
    $printer -> setTextSize(1, 1);
    $printer -> text(ucwords($shop->address)."\n");
    // $printer -> text($shop->phone."\n");
    $printer -> text(date("d-M-Y H:i:s",Strtotime($positions[0]->created_at))."\n");
    $printer -> setTextSize(2, 2);
    $printer -> text("Served by: ".ucwords(User::model()->find('id=:u',array(':u'=>Yii::app()->user->id))->username)."\n");
    $printer -> setTextSize(1, 1);
    $printer -> text("Customer: ".Customers::model()->find('id=:u',array(':u'=>$details[0]->customer_id))->cname."\n");
    $printer -> setTextSize(2, 1);
	$printer -> text("Table No: ".$positions[0]->table_number."\n\n");
	$printer -> setTextSize(1, 1);
    





    if($positions[0]->closed==1){
					
					 $printer -> text("RECEIPT ID: ".$transid."\n\n");
					}else{	
					 $printer -> setTextSize(2, 2);					
						$printer -> text("Order NO: ".$transid."\n\n");
						 $printer -> setTextSize(1, 1);
					}


    $content='';
    $total=0;

    if($positions[0]->closed==1){
    foreach($positions as $position){
					$res=ucwords($position->item_name)."\n";	
					//printer_write($handle, $res,12,12);	
					$content.=$res;
					
					$res1=" @ ".$position->unit_price." X ".$position->qty." = ".number_format($position->unit_price*$position->qty,2)."\n";	
					//printer_write($handle, $res1);
					$content.=$res1;
					$x+=$position->qty;
					$total+=$position->unit_price." X ".$position->qty;
				}
				$printer -> text($content."\n");
				}else{
					
					   // foreach($positions as $position){
					    	$cat=Salesx::model()->findAll('created_at=:g',array(':g'=>$time));
					    	foreach($cat as $ca){
				
					
					$res1=ucwords($ca->item_name)." X ".$ca->qty."\n";	
					//printer_write($handle, $res1);
					$content.=$res1;
					$x+=$ca->qty;
					$total+=$ca->unit_price." X ".$ca->qty;
				}
						
				//}

				}	
 $printer -> setTextSize(2, 1);
	$printer -> text($content."\n");
	 $printer -> setTextSize(1, 1);
if($positions[0]->closed==1){
	$printer -> text("Total Items: ".$x."\n");
    $printer -> text("Total: ".number_format($position->total,2)."\n");
    $printer -> text("Amount Tendered: ".number_format($position->tendered,2)."\n");
    $printer -> setTextSize(2, 2);
    $printer -> text("Balance: ".number_format($position->balance,2)."\n");
    $printer -> setTextSize(1, 1);
    $printer -> text("Vat: 5%\n");
    $printer -> text("Mode of Payment: ".ucwords($positions[0]->payment_type)."\n");
}
        $printer -> text("\n\n\n");	


   // $printer -> text($shop->phone."\n");
   // $printer -> cut(CUT_PARTIAL,10);
    $printer->cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

		}
		
		
		
		
		public function actionprinta2()
		
		{
			//$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			//$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;
			
			//$conf=Config::model()->find('id=:l',array(':l'=>1));

			$conf=Config::model()->find('id=:l',array(':l'=>1));
			$shop=Shops::model()->findByPk(Yii::app()->user->shop_id);

		
			
$transid=$date1 = Yii::app()->request->getPost('barcode');


$criteria=new CDbCriteria(); 
//$criteria->order='id desc';
$criteria->condition='transaction_id=:p';
$criteria->params=array(':p'=>$transid);


$positions = Salesx::model()->findAll($criteria);
//$transid=$lid2->transaction_id;

try {
    // Enter the share name for your USB printer here
   // $connector = "mark";
    $connector = new WindowsPrintConnector("taire");
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);

    $printer->setJustification(1);
    //$image="trinity.jpg";
   // $printer -> text($conf->company_name."\n");
    //$img = EscposImage::load(Yii::app()->baseUrl . "/assets/logo/trinity.jpg");
    // $img = EscposImage::load("trinity.jpg");
    $img = EscposImage::load(dirname(FILE) . "/assets/logo/trinity.jpg", false);

	
	$printer->bitImage($img);
	//$printer -> text("\n");	

    
    $printer -> setEmphasis(true);

    //$printer -> text($shop->name."\n");
    $printer -> text("\n");
    $printer -> setEmphasis(false);
    $printer -> setTextSize(1, 1);
    $printer -> text(ucwords($shop->address)."\n");
    //$printer -> text($shop->phone."\n");
    $printer -> text(date("d-M-Y H:i:s",Strtotime($positions[0]->created_at))."\n");
    $printer -> setEmphasis(true);
  $printer -> setTextSize(2, 2);
    $printer -> text("Served by: ".ucwords(User::model()->find('id=:u',array(':u'=>Yii::app()->user->id))->username)."\n");
    $printer -> setTextSize(1, 1);
    $printer -> setEmphasis(false);
    $printer -> text("Customer: ".Customers::model()->find('id=:u',array(':u'=>$details[0]->customer_id))->cname."\n");
    $printer -> text("SALES RECEIPT\n");
    $printer -> text("RECEIPT ID: ".$transid."\n");	
    $printer -> setTextSize(2, 1);
	$printer -> text("Table No: ".$positions[0]->table_number."\n\n");
	$printer -> setTextSize(1, 1);	

    $content='';
    $total=0;
    foreach($positions as $position){
					$res=strtoupper($position->item_name)."\n";	
					//printer_write($handle, $res,12,12);
					$total+=$position->unit_price*$position->qty;
					$content.=$res;
					
					$res1=" @ ".$position->unit_price." X ".$position->qty." = ".number_format($position->unit_price*$position->qty,2)."\n\n";	
					//printer_write($handle, $res1);
					$content.=$res1;
					$x+=$position->qty;
					//$total+=$position->unit_price." X ".$position->qty;
					$position->print=1;
					$position->save();
				}	

	$printer -> text($content."\n");

	$printer -> text("Total Items: ".$x."\n");
    $printer -> text("Total: ".number_format($total,2)."\n");
    $printer -> text("Amount Tendered: ".number_format($position->tendered,2)."\n");
    $printer -> setEmphasis(true);
    $printer -> setTextSize(2, 2);
    $printer -> text("Balance: ".number_format($position->sale_balance,2)."\n");
    $printer -> setTextSize(1, 1);
    $printer -> setEmphasis(false);
    $printer -> text("Vat: 5%\n");
    $printer -> text("Mode of Payment: ".ucwords($positions[0]->payment_type)."\n");
        $printer -> text("\n\n\n");	


   // $printer -> text($shop->phone."\n");
   // $printer -> cut(CUT_PARTIAL,10);
    $printer->cut();
    
    /* Close printer */
    $printer -> close();

    


} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

		}
		
		
		
		
		public function actionprinta3()
		
		{
			//$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			//$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;
			
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		
			
$dyear = Yii::app()->request->getPost('barcode');



 $listsq="select *from sales where SUBSTR(created_at,1,10)='".$dyear."' and staff='".Yii::app()->user->id."'";
		 $list = Yii::app()->db->createCommand($listsq)->queryAll();
		 
		  $sall="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."' and staff='".Yii::app()->user->id."'";
		 $all = Yii::app()->db->createCommand($sall)->queryScalar();

$salep=user::model()->find('id=:u',array(':u'=>Yii::app()->user->id))->username;


					$space="".PHP_EOL;	
					//printer_write($handle, $space);
					//printer_write($handle, $space);

					$line="------------------------------------------------\n";
			
					$content='';
					$head1=$conf->company_name."\n";	
					$content.=$head1;
					//printer_write($handle, $head1);					
					$head2=$conf->address."\n\n";	
					//printer_write($handle, $head2);	
					$content.=$head2;
					$head3="SALES REPORT FOR ".date("d-M-Y g:i:s a",Strtotime($dyear))."\n\n";
					$content.=$head3;
					
					$head4="Report for: ".ucwords($salep)."\n\n";
					$content.=$head4;
					
					$content.=$line;
					
					foreach($list as $li){ 

					$content.=$li['item_name']."\n"; 
				$content.="@ ".number_format($li['unit_price'],2)." x ".$li['qty']."=".(number_format($li['qty']*$li['unit_price'],2))."\n\n";

    
					}
					
					$content.="Total Sales ".number_format($all,2)."\n"; 


				
					
						
						
			
			
			
			$handle = printer_open("mark");
			//$font=printer_create_font("Verdana",72,48,500,false,false,false,0);
			//printer_select_font($handle,$font);
			
			printer_start_doc($handle, "Receipt");	
			
			printer_start_page($handle);
			
			printer_set_option($handle, PRINTER_MODE, "RAW");	
			//printer_set_option($handle, PRINTER_COPIES,2);
			
			printer_write($handle,$content);
					
					printer_end_page($handle);
					printer_end_doc($handle);
					printer_close($handle);						
						
		}

		public function actionprinta3_all()
		
		{
			//$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			//$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;
			
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		
			
$dyear = Yii::app()->request->getPost('barcode');



 $listsq="select *from sales where SUBSTR(created_at,1,10)='".$dyear."'";
		 $list = Yii::app()->db->createCommand($listsq)->queryAll();
		 
		  $sall="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,10)='".$dyear."'";
		 $all = Yii::app()->db->createCommand($sall)->queryScalar();

$salep="Total Sales";


					$space="".PHP_EOL;	
					//printer_write($handle, $space);
					//printer_write($handle, $space);

					$line="------------------------------------------------\n";
			
					$content='';
					$head1=$conf->company_name."\n";	
					$content.=$head1;
					//printer_write($handle, $head1);					
					$head2=$conf->address."\n\n";	
					//printer_write($handle, $head2);	
					$content.=$head2;
					$head3="SALES REPORT FOR ".date("d-M-Y g:i:s a",Strtotime($dyear))."\n\n";
					$content.=$head3;
					
					$head4="Report for: ".ucwords($salep)."\n\n";
					$content.=$head4;
					
					$content.=$line;
					
					foreach($list as $li){ 

					$content.=$li['item_name']."\n"; 
				$content.="@ ".number_format($li['unit_price'],2)." x ".$li['qty']."=".(number_format($li['qty']*$li['unit_price'],2))."\n\n";

    
					}
					
					$content.="Total Sales ".number_format($all,2)."\n"; 


				
					
						
						
			
			
			
			$handle = printer_open("mark");
			//$font=printer_create_font("Verdana",72,48,500,false,false,false,0);
			//printer_select_font($handle,$font);
			
			printer_start_doc($handle, "Receipt");	
			
			printer_start_page($handle);
			
			printer_set_option($handle, PRINTER_MODE, "RAW");	
			//printer_set_option($handle, PRINTER_COPIES,2);
			
			printer_write($handle,$content);
					
					printer_end_page($handle);
					printer_end_doc($handle);
					printer_close($handle);						
						
		}




		
		
		
		
		public function actioncheckout()
		{
			// place database lock here to avoid two sales points selling remaining one item at the
			// same time. remove lock at tend of transaction to allow others make sale

			


			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;

			//$stype=$_POST['ttype'];
			$ptype=$_POST['payt'];
			$custid=$_POST['name'];
		// 	if(strval($custid) != strval(intval($custid)))
			if(strval($custid) == 100066858850)
			{
?>
<script type="text/javascript">
alert('Enter a valid customer name'); 
</script>
<?php
				echo "enter a valid customer name"; die;
			}

			$change=$_POST['change'];
			$tendered=$_POST['tendered'];

			$transaction_id=time().rand(1,9);

			$dtender=$_POST['dtender'];
			$dtender1=explode('.', $dtender);
			$dtender=str_replace(array(',','.',' '), '', $dtender1[0]);



			$totalwd=Yii::app()->shoppingCart->getCost()-((Yii::app()->shoppingCart->getCost()*$disc)/100);
			$totaltax=($totalwd*$tax)/100;
			$total=$totalwd+$totaltax;		



				$positions = Yii::app()->shoppingCart->getPositions();

					 $totdisco=0;
				// $tot_total=0;

			

				foreach($positions as $position)
				{
					$total-=$position->disco*($position->getQuantity());
					$totdisco+=($position->disco*$position->getQuantity());
					// Yii::app()->shoppingCart->getCost()
				}
				
				foreach($positions as $position)
				{
					if($disc>0){
					$minusdisc=$position->price-(($position->price*$disc)/100);
				}else{
					$minusdisc=$position->price;
				}
				}
				if(empty($position->supplier))
				{
					$position->supplier=0;
				}


					$transaction = Yii::app()->db->beginTransaction();
				try{
					$plustax=(($minusdisc*$tax)/100);
					$date=time();
					$sale= new Salesx();
					$sale->item_name=$position->name;
					$sale->item_id=$position->getid();
					$sale->transaction_id=$transaction_id;
					$sale->qty=$position->getQuantity();
					$sale->unit_price=($minusdisc+$plustax)-$position->disco;
					$sale->total=$total;
					$sale->staff=Yii::app()->user->id;
					//$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->discount=$disc+$position->disco;
					$sale->tax=$tax;
					$sale->balance=($change+$totdisco);
					$sale->tendered=$tendered;
					$sale->supplier=$position->supplier;
					$sale->supply_price=$position->supply_price;
					$sale->item_discount=$position->single_item_discount;
					$sale->shop_id=Yii::app()->user->shop_id;
					$sale->amount_paid=$dtender;
					$sale->sale_balance=$total-$dtender-$disco-$disc;
				//	$sale->updated_at=date("Y-m-d H:i:s");
					$sale->created_at=date("Y-m-d H:i:s");
					//$s1=$sale->save();

					// here we check the inventory stock just before closing sale to make sure we
					// still have enough stock to meet the order by looping through the cart items 
					// and checking them against inventory quantity.
					// if another sales point has sold stock that was hitherto available in inventory
					// by clikcing the submit button first our check will identify that stock can no
					// longer meet the order and cease to complete to sale but rather redirect the
					// cashier to the sales page with quantity errors showned in red.
					$inv=Inventory::model()->find('id=:k',array(':k'=>$position->id));
					if($inv->quantity>=$position->getQuantity()){
					$newquantity=$inv->quantity-$position->getQuantity();
					}else{
throw new Exception( 'not enough in stock' );
						?>
<script type="text/javascript">
alert('One or more of the items on your cart is out of stock!');
</script>

						<?php
						die;

					}

					// above here we close the check for the sufficient stock and go on to make the 
					// sale once our test is passed for each item in the shopping cart


					// check if sale has failed and output errors otherwise sale sale
					
					if(!$sale->save()){ throw new Exception( 'could not save sale' );
					 var_dump($sale->getErrors());  die; 
					}


					$transaction->commit();


					} catch (Exception $e) {
					    $transaction->rollBack();
					    // other actions to perform on fail (redirect, alert, etc.)
					    die('transaction failed');
					} 		

				
		
					Yii::app()->shoppingCart->clear();
					echo "Finished";

		}



		// close sale for good

		public function actioncheckout_do()
		{
			// place database lock here to avoid two sales points selling remaining one item at the
			// same time. remove lock at tend of transaction to allow others make sale

			


			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;

			//$stype=$_POST['ttype'];
			$ptype=$_POST['payt'];
			$custid=$_POST['name'];
		// 	if(strval($custid) != strval(intval($custid)))
			if(strval($custid) == 100066858850)
			{
?>
<script type="text/javascript">
alert('Enter a valid customer name'); 
</script>
<?php
				echo "enter a valid customer name"; die;
			}

			$change=$_POST['change'];
			$tendered=$_POST['tendered'];

			$transaction_id=time().rand(1,9);

			$dtender=$_POST['dtender'];
			$dtender1=explode('.', $dtender);
			$dtender=str_replace(array(',','.',' '), '', $dtender1[0]);

// if we impliment wholesale
			// if($sale_type==1)
			// {

			$totalwd=Yii::app()->shoppingCart->getCost()-((Yii::app()->shoppingCart->getCost()*$disc)/100);
			$totaltax=($totalwd*$tax)/100;
			$total=$totalwd+$totaltax;		



				$positions = Yii::app()->shoppingCart->getPositions();

					 $totdisco=0;
				// $tot_total=0;

				foreach($positions as $position)
				{
					$total-=$position->disco*($position->getQuantity());
					$totdisco+=($position->disco*$position->getQuantity());
					// Yii::app()->shoppingCart->getCost()
				}
				
				foreach($positions as $position)
				{
					if($disc>0){
					$minusdisc=$position->price-(($position->price*$disc)/100);
				}else{
					$minusdisc=$position->price;
				}
				if(empty($position->supplier))
				{
					$position->supplier=0;
				}
					$plustax=(($minusdisc*$tax)/100);
					$date=time();
					$sale= new Salesx();
					$sale->item_name=$position->name;
					$sale->item_id=$position->getid();
					$sale->transaction_id=$transaction_id;
					$sale->qty=$position->getQuantity();
					$sale->unit_price=($minusdisc+$plustax)-$position->disco;
					$sale->total=$total;
					$sale->staff=Yii::app()->user->id;
					//$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->discount=$disc+$position->disco;
					$sale->tax=$tax;
					$sale->balance=($change+$totdisco);
					$sale->tendered=$tendered;
					$sale->supplier=$position->supplier;
					$sale->supply_price=$position->supply_price;
					$sale->item_discount=$position->single_item_discount;
					$sale->shop_id=Yii::app()->user->shop_id;
					$sale->amount_paid=$dtender;
					$sale->sale_balance=$total-$dtender-$disco-$disc;
				//	$sale->updated_at=date("Y-m-d H:i:s");
					$sale->created_at=date("Y-m-d H:i:s");
					//$s1=$sale->save();

					// here we check the inventory stock just before closing sale to make sure we
					// still have enough stock to meet the order by looping through the cart items 
					// and checking them against inventory quantity.
					// if another sales point has sold stock that was hitherto available in inventory
					// by clikcing the submit button first our check will identify that stock can no
					// longer meet the order and cease to complete to sale but rather redirect the
					// cashier to the sales page with quantity errors showned in red.
					$inv=Inventory::model()->find('id=:k',array(':k'=>$position->id));
					if($inv->quantity>=$position->getQuantity()){
					$newquantity=$inv->quantity-$position->getQuantity();
					}else{

						?>
<script type="text/javascript">
alert('One or more of the items on your cart is out of stock!');
</script>

						<?php
						die;

					}

					// above here we close the check for the sufficient stock and go on to make the 
					// sale once our test is passed for each item in the shopping cart


					// check if sale has failed and output errors otherwise sale sale
					Yii::app()->db->createCommand("LOCK TABLES sales WRITE")->execute();
					if(!$sale->save()){ var_dump($sale->getErrors());  die; }
					Yii::app()->db->createCommand("UNLOCK TABLES")->execute();

					// same to
					$drop=new Drops();
					$drop->barcode=$position->barcode;
					$drop->quantity=$position->getQuantity();;
					$drop->product_name=$position->name;
					$drop->staff=Yii::app()->user->id;
					$drop->shop_id=Yii::app()->user->shop_id;
					$drop->received=0;
					$drop->item_id=$position->id;
					$drop->issued=$position->getQuantity();
					$drop->save();


					
					$inv->quantity=$newquantity;
					$inv->updated_at=date("Y-m-d H:i:s");
					$s2=$inv->save();
				
				}

			
				
					Yii::app()->shoppingCart->clear();
					echo "Finished";

		}





		public function actioncheckout_rest()
		{
			// place database lock here to avoid two sales points selling remaining one item at the
			// same time. remove lock at tend of transaction to allow others make sale

			$fin=1;
		if(empty(Yii::app()->user->id))
		{
			$this->redirect(array('site/login'));
		}

			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$dops=array();
			$kit=0;
			$apay=0;

			//$stype=$_POST['ttype'];
			$ptype='cash';
			//$custid=$_POST['name'];
			

			//$ptype=$_POST['ptype']; 
		// 	if(strval($custid) != strval(intval($custid)))
			if(strval($table) == 100066858850)
			{
?>
<script type="text/javascript">
alert('Enter a valid customer name'); 
</script>
<?php
				echo "enter a valid customer name";
				$fin=2;
				 die;
			}

			$table=$_POST['table'];

			$change=0;
			$tendered=Yii::app()->shoppingCart->getCost();

			$transaction_id=time().rand(1,9);

			$dtender=Yii::app()->shoppingCart->getCost();

		
			// $dtender1=explode('.', $dtender);
			// $dtender=str_replace([',','.',' '], '', $dtender1[0]);

// if we impliment wholesale
			// if($sale_type==1)
			// {
			$pat=array();
			$start=0;
			$w=0;
			$ten=0;

			$yams=Salesx::model()->findAll('transaction_id=:h',array(':h'=>Yii::app()->session['tid']));
			foreach($yams as $ya)
			{
				$pat[$w]+=$ya->transaction_id;
				$w++;
			}

			$pin=array_unique($pat);

			foreach($pin as $p)
			{
				$corn=Salesx::model()->find('transaction_id=:h',array(':h'=>$p));
				$start+=$corn->sale_balance;
				$ten+=$corn->tendered;
			}

			$totalwd=Yii::app()->shoppingCart->getCost()-((Yii::app()->shoppingCart->getCost()*$disc)/100);
			$totaltax=($totalwd*$tax)/100;
			$total=$totalwd+$totaltax;		


			$create=date("Y-m-d H:i:s");
				$positions = Yii::app()->shoppingCart->getPositions();

					 $totdisco=0;
				// $tot_total=0;

				foreach($positions as $position)
				{
					$total-=$position->disco*($position->getQuantity());
					$totdisco+=($position->disco*$position->getQuantity());
					// Yii::app()->shoppingCart->getCost()
				}


				$linked=Salesx::model()->findAll('transaction_id=:h',array(':h'=>Yii::app()->session['tid']));
				$ltotal=$linked[0]->total;
				$keep=$linked[0]->total;

			// if(isset(Yii::app()->session['tid']))
			// {
			// 	$linked=Salesx::model()->findAll('transaction_id=:h',array(':h'=>Yii::app()->session['tid']));
			// 	$ltotal=$linked[0]->total;
			// 	//echo $ltotal; var_dump($linked); die;
			
			// 		$tot=$ltotal+$total;

			// 		foreach($linked as $link){
			// 		$keep=$link['total']+=$tot;
			// 		//$link['tendered']=$tot;
			// 		//$link['amount_paid']=$tot;
			// 		if(!$link->save())
			// 		{
			// 			var_dump($link->getErrors()); die;
			// 		}
			// 		}
				
				
			// }
				
				foreach($positions as $position)
				{
					if($disc>0){
					$minusdisc=$position->price-(($position->price*$disc)/100);
				}else{
					$minusdisc=$position->price;
				}
				if(empty($position->supplier))
				{
					$position->supplier=0;
				}
					$plustax=(($minusdisc*$tax)/100);
					$date=time();
					$sale= new Salesx();
					$sale->item_name=$position->name;
					$sale->item_id=$position->getid();
					if(isset(Yii::app()->session['tid']))
					{
						$sale->transaction_id=Yii::app()->session['tid'];
					}else{
					$sale->transaction_id=$transaction_id;
				}
					$sale->qty=$position->getQuantity();
					$sale->unit_price=($minusdisc+$plustax)-$position->disco;


					$sale->total=$total+$ltotal;
					$sale->staff=Yii::app()->user->id;
					//$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->discount=$disc+$position->disco;
					$sale->tax=$tax;
					$sale->balance=0;
					$sale->tendered=0;
					$sale->supplier=$position->supplier;
					$sale->supply_price=$position->supply_price;
					$sale->item_discount=$position->single_item_discount;
					$sale->shop_id=Yii::app()->user->shop_id;
					$sale->amount_paid=0;
					//$sale->sale_balance=$dtender-$disco-$disc;
					$sale->sale_balance=$total+$ltotal;
					$sale->closed=0;
					$sale->category=$position->category;
					if(isset(Yii::app()->session['table']))
					{
						$sale->table_number=Yii::app()->session['table'];
					}else{
					$sale->table_number=$table;
					}
				//	$sale->updated_at=date("Y-m-d H:i:s");
					$sale->created_at=$create;
					//$s1=$sale->save();

					// here we check the inventory stock just before closing sale to make sure we
					// still have enough stock to meet the order by looping through the cart items 
					// and checking them against inventory quantity.
					// if another sales point has sold stock that was hitherto available in inventory
					// by clikcing the submit button first our check will identify that stock can no
					// longer meet the order and cease to complete to sale but rather redirect the
					// cashier to the sales page with quantity errors showned in red.
					$inv=Inventory::model()->find('id=:k',array(':k'=>$position->id));
					if($inv->quantity>=$position->getQuantity()){

						if($inv->quantity<20 && $inv->is_countable==0){ $inv->quantity+=50; }
					$newquantity=$inv->quantity-$position->getQuantity();
					}else{

						?>
<script type="text/javascript">
alert('One or more of the items on your cart is out of stock!');
</script>

						<?php
						$fin=2;
						die;

					}

					// above here we close the check for the sufficient stock and go on to make the 
					// sale once our test is passed for each item in the shopping cart


					// check if sale has failed and output errors otherwise sale sale
					// Yii::app()->db->createCommand("LOCK TABLES sales WRITE")->execute();
					if(!$sale->save()){ var_dump($sale->getErrors());
					$fin=2;
					  die; }
					// Yii::app()->db->createCommand("UNLOCK TABLES")->execute();


			if(isset(Yii::app()->session['tid']))
			{				
					
					$come=Salesx::model()->findAll('transaction_id=:h',array(':h'=>Yii::app()->session['tid']));
			
					$michael=0;
					$b=0;
					foreach($come as $co)
					{
						$michael+=($co->qty*$co->unit_price);
						$dops[$b]+=$co->transaction_id;
						$b++;
					}



					foreach($come as $bell){
					$bell->total=$michael;
					$bell->sale_balance=$start+$total;
					$bell->amount_paid=$ten;
					$bell->tendered=$ten;
					
					if(!$bell->save())
					{
						$fin=2;
						var_dump($link->getErrors()); die;
					}
					}		
				
			}					

				
				}




								// sop

								$code=array_unique($dops);
								foreach($code as $id)
								{
									$tab=Salesx::model()->findAll('transaction_id=:k',array(':k'=>$id));
									
									$kit+=$tab[0]->sale_balance;
									$apay+=$tab[0]->amount_paid;
									
								}



								// $come=Salesx::model()->findAll('transaction_id=:h',array(':h'=>Yii::app()->session['tid']));
								// foreach($come as $cap)
								// {
								// 	$cap->amount_paid=$apay;
								// 	$cap->tendered=$apay;
								// 	//$cap->sale_balance=$kit;
								// 	$cap->save();
								// }
								// fat
			
				
					

					if($fin==1){
					echo "Finished";

					for($b=0; $b<2; $b++){
						$this->actionPrinta();
					}
			
					Yii::app()->shoppingCart->clear();
					unset(Yii::app()->session['table']);
					unset(Yii::app()->session['tid']);


				}
				

		}



		public function actionSuspend()
		{
			//if(isset($_POST['sales']))
			//{
			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$disc=Config::model()->find('id=:l',array(':l'=>1))->discount;

		//	$stype=$_POST['ttype'];
			$ptype='Suspend';
			$custid=$_POST['name'];
			$cid=time().rand(1,9);


			$totalwd=Yii::app()->shoppingCart->getCost()-((Yii::app()->shoppingCart->getCost()*$disc)/100);
			$totaltax=($totalwd*$tax)/100;
			$total=$totalwd+$totaltax;
		
						

				$positions = Yii::app()->shoppingCart->getPositions();
				//var_dump($positions); die;
				
				
				foreach($positions as $position)
				{
					/*
					if($disc>0){
					$minusdisc=$position->price-(($position->price*$disc)/100);
				}else{
					$minusdisc=$position->price;
				}
				*/
					
					$plustax=(($minusdisc*$tax)/100);
					$date=time();
					$sale= new Suspended();
					$sale->name=$position->name;
					$sale->id=$position->getid();
					$sale->cart_id=$cid;
					$sale->quantity=$position->getQuantity();
					//$sale->unit_price=($minusdisc+$plustax);
					$sale->price=$position->price;
					//$sale->total=$total;
					$sale->total=Yii::app()->shoppingCart->getCost();
					$sale->staff=Yii::app()->user->id;
					//$sale->saletype=$stype;
					$sale->payment_type=$ptype;
					$sale->customer_id=$custid;
					$sale->discount=$disc;
					$sale->tax=$tax;
					$sale->supplier=$position->supplier;
					$sale->photo=$position->photo;
					$sale->supply_price=$position->supply_price;
					$sale->item_discount=$position->single_item_discount;
					$sale->shop_id=Yii::app()->user->shop_id;
					$sale->amount_paid=$dtender;
					$sale->sale_balance=Yii::app()->shoppingCart->getCost()-$dtotal;
				//	$sale->updated_at=date("Y-m-d H:i:s");
					if(!$sale->save())
					{
						 print_r($sale->getErrors());
					}

					
					/*

					$plustax=(($minusdisc*$tax)/100);
					$date=time();
					$sale= new Suspended();
					$sale->item_name='rice';
					$sale->item_id=5;
					$sale->transaction_id=$transaction_id;
					$sale->qty=4;
					$sale->unit_price=($minusdisc+$plustax);
					$sale->total=5677;
					$sale->staff=Yii::app()->user->id;
					$sale->saletype=3;
					$sale->payment_type='none';
					$sale->customer_id=8;
					$sale->discount=$disc;
					$sale->tax=$tax;
				//	$sale->updated_at=date("Y-m-d H:i:s");
					if(!$sale->save())
					{
						 print_r($sale->getErrors());
					}


					*/

					
				}				
					
					
				Yii::app()->shoppingCart->clear();
		

					//}
		}





		public function actionSuspended()
		{
			$this->layout='column1';

			$criteria=new CDbCriteria();
			$criteria->condition='staff=:u';
			$criteria->params=array(':u'=>Yii::app()->user->id);
			$criteria->order='id desc';
			$criteria->group='cart_id';
			//$criteria-
			$lists=Suspended::model()->findAll($criteria);
			$this->render('suspended',array(
				'lists'=>$lists
				));
		}


		public function actionChangepass()
		{
			$model=new User();
			$this->render('changepass',array(
				'model'=>$model,
				));
		}


		public function actionPassword()
	{
		if(isset($_POST['User'])){
			//echo "facts ".var_dump($_POST['User']); die;
			//$mod=user::model()->find('id='.$_POST['User']['id']); //var_dump($mod); die;
			$mod=User::model()->find('id=:k',array(':k'=>Yii::app()->user->id));
			 if(SHA1($_POST['User']['old_pass'])!=$mod->password){ 
			 Yii::app()->user->setFlash('failed', '<strong>Error!</strong> Current password is incorrect!');
			 $this->redirect(array('password'));
			  }
			  
			 if($_POST['User']['new_pass']!=$_POST['User']['re_new_pass']) {
			 Yii::app()->user->setFlash('failed', '<strong>Error!</strong> Your new passwords do not match!');
			  $this->redirect(array('password'));
			  }
			 
			 $mod->password=SHA1($_POST['User']['new_pass']);
			 if($mod->save()) {
			 Yii::app()->user->setFlash('success', '<strong>Sucess</strong> Your Password has been successfully Changed!');
			//  $this->refresh();
			 $this->redirect(array('password')); 
			 }
			// var_dump($mod->getErrors());
			 
			
		}
		$model=new User();
		$this->render('changepass',array('model'=>$model));
		
	}




		public function actionTocart($id)
		{
			Yii::app()->shoppingCart->clear();

			$criteria= new CDbCriteria();
			$criteria->condition='cart_id=:y';
			$criteria->params=array(':y'=>$id);
			$suspended=Suspended::model()->findAll($criteria);
			foreach($suspended as $suspend){
			Yii::app()->shoppingCart->put($suspend);
			Yii::app()->shoppingCart->update($suspend,$suspend->quantity);


		}

		//foreach($suspended as $sus)
		//{
			
		//}


/*

			//	$dataProvider=new CActiveDataProvider('Inventory');
		$tax=Config::model()->find('id=:l',[':l'=>1])->tax;
		$discount=Config::model()->find('id=:l',[':l'=>1])->discount;
		//$tdsale=Sales::model()->find('staff=:j',[':j'=>Yii::app()->user->id]);
		//SUBSTR(created_at,1,10)='".$dyear."'
		$today=date("Y-m-d");
		 $tdsaleq="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' ";
		 $tdsale = Yii::app()->db->createCommand($tdsaleq)->queryScalar();

		  $returnsql="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' and saletype=2";
		 $returns = Yii::app()->db->createCommand($returnsql)->queryScalar();


		 $criteria=new CDbCriteria();
		 $criteria->condition='staff=:t';
		 $criteria->params=array(':t'=>Yii::app()->user->id);
		 $criteria->group='transaction_id desc';
		 $criteria->limit='5';
		 $lastsales=Sales::model()->findAll($criteria);
		 
		 $tdsales=$tdsale-$returns;

			$this->render('sell',array(
			'model'=>$model,
			'model2'=>$model2,
			'tax'=>$tax,
			'discount'=>$discount,
			'tdsale'=>$tdsales,
			'lastsales'=>$lastsales,
			
		));
		*/


 		$sql1="delete from suspended where cart_id='".$id."'";
		$deleted=Yii::app()->db->createCommand($sql1)->query();

		// $conf=Config::model()->find('id=:l',array(':l'=>1));
		 //if($conf->shop==2){ $this->redirect(array('sale2')); }

		$this->redirect(array('sale'));

		}




		public function actioncheckout2()
		{
			//if(isset($_POST['sales']))
			//{			

			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		
			//$this->renderPartial('myview', array(),false, true);
			$this->render('invoice',array(
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				
				),false,true);

			
			//}
		}

		public function actioncheckout3()
		{
			//if(isset($_POST['sales']))
			//{			

			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));

		
			//$this->renderPartial('myview', array(),false, true);
			$this->render('invoice',array(
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				
				),false,true);

			
			//}
		}


		public function actionTracksale()
		{
			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));


			$model=new Sales();
			$model->unsetAttributes();
			if(isset($_GET['Sales']))
				{	
					// $tracksql="select *from sales where transaction_id='".$tid."'";
		 			 //$track=Yii::app()->db->createCommand($tracksql)->queryAll();
					$model->attributes=$_GET['Sales'];
					//echo $model->transaction_id; die;
					$tid=$model->transaction_id;
					$track=Sales::model()->findAll('transaction_id=:j',array(':j'=>$tid));
				}
			$this->render('tracksale',array(
				'model'=>$model,
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				'track'=>$track,
				),false,true);
		}





		public function actionNewtotal()
		{
			$today=date("Y-m-d");
		 $tdsaleq="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' ";
		 $tdsale = Yii::app()->db->createCommand($tdsaleq)->queryScalar();


		 // $returnsql="select sum(unit_price*qty) from sales where staff='".Yii::app()->user->id."' and SUBSTR(created_at,1,10)='".$today."' and saletype=2";
		// $returns = Yii::app()->db->createCommand($returnsql)->queryScalar();
		 ?>
		 Todays Sales: <del>N</del><?php echo number_format(($tdsale),2); ?>
		 <?php
		}


		public function actionReports()
		{
			$this->layout='column1';
			$model= new Sales();
			$model->unsetAttributes();
			

			if(isset($_GET['Inventory']))
				{	
			//	$model->attributes=$_GET['Inventory'];
			
			$dyear=$_GET['Inventory']['date1'];
			$date2=$_GET['Inventory']['date2'];
			$shop=$_GET['Inventory']['staff'];
			$ptype=$_GET['Inventory']['ptype'];
			// echo $dyear; echo " and ".$date2." and ".$shop; die;


			//$sup=$model->item_name;
			$sup=$_GET['Inventory']['item_name'];
		

			
			//$sql="select *from Sales where SUBSTR(created_at,1,10)='".$dyear."'";
			
			$criteria = new CDbCriteria();
			if(!empty($sup)){
    // something here o as in put your code here
		 
   }else{
   	if($shop=='5000')
   	{
// the code for all location goes here
   		$sales_sql="select transaction_id, tendered, amount_paid, table_number, item_id, item_name, unit_price, supply_price, qty, total, customer_id, staff, payment_type, tax, discount, id, balance, shop_id from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and closed=1 group by transaction_id order by id desc";
   		$sql1="select item_name, sum(qty) as nu, discount from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and closed=1 group by item_id order by nu desc limit 10";
   		$cust_sql="select * from sales where  SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and closed=1 group by transaction_id";
   	}elseif(!empty($ptype)){
   	  
   // code for specific shop location goes here
   		$sales_sql="select transaction_id, tendered, amount_paid, item_id, item_name, unit_price, supply_price, qty, total, customer_id, staff, payment_type, table_number, tax, discount, id, balance, shop_id from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and payment_type='".$ptype."' and closed=1 group by transaction_id order by id desc";
   		$sql1="select item_name, sum(qty) as nu, discount from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and payment_type='".$ptype."' and closed=1 group by item_id order by nu desc limit 10";
   		$cust_sql="select * from sales where  SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and payment_type='".$ptype."' and closed=1 group by transaction_id";
 
}elseif(empty($ptype)){
   // code for specific shop location goes here
   		$sales_sql="select transaction_id, tendered, amount_paid, item_id, item_name, unit_price, supply_price, qty, total, customer_id, staff, payment_type, table_number, tax, discount, id, balance, shop_id from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by transaction_id order by id desc";
   		$sql1="select item_name, sum(qty) as nu, discount from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by item_id order by nu desc limit 10";
   		$cust_sql="select * from sales where  SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by transaction_id";
 
	}else{
		$sales_sql="select transaction_id, tendered, amount_paid, item_id, item_name, unit_price, supply_price, qty, total, customer_id, staff, payment_type, table_number, tax, discount, id, balance, shop_id from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by transaction_id order by id desc";
   		$sql1="select item_name, sum(qty) as nu, discount from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by item_id order by nu desc limit 10";
   		$cust_sql="select * from sales where  SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$shop."' and closed=1 group by transaction_id";

	}	
   }


   // $command=Yii::app()->db->createCommand();
			// $command=$command->select("sum(amount_due) as due, sum(amount_paid) as pay, student_id, description, transaction_type,term,year,transaction_date, classs, status");
			// $command=$command->from('Fees');	
			// $command=$command->where('student_id!=:j',array(':j'=>0));
			

			// if(!empty($owe->classs)){	
			// $command=$command->andWhere('classs=:p',array(':p'=>$owe->classs));
			// }

   // 	$command=$command->group('student_id');	
			// // Yii::log($command->getPdoStatement()->queryString); 
			
			// $command=$command->queryAll();
       
      

		
		$sales = Yii::app()->db->createCommand($sales_sql)->queryAll();

		
		$fastmoving=Yii::app()->db->createCommand($sql1)->queryAll();

		
		$cust = Yii::app()->db->createCommand($cust_sql)->queryAll();
		$dshop=Shops::model()->findByPk($shop)->name;


		 $this->render('reports',array(
				'model'=> $model,
				'sales'=>$sales, // must be the same as $item_count
				'period'=>$dyear,
				'period2'=>$date2,
				'fastmoving'=>$fastmoving,
				'cust'=>$cust,
				'company'=>$dshop,
				'shop'=>$shop
			
				));
				}else{

			$this->render('reports',array(
				'model'=> $model,
				'sales'=>'', // must be the same as $item_count
				
				
				));
		}
		}




		public function actionReportsweekly()
		{
			$this->layout='column1';
			$model= new Sales();
			$model->unsetAttributes();
			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;

			if(isset($_GET['Sales']))
				{			
		

				//	$criteria = new CDbCriteria();
					// $criteria->select = 'sum(qty) as qty, item_name, unit_price';
					// $criteria->group = 'item_name,unit_price';
					//
			
		
			
			$date1=$_GET['Sales']['date1'];
			$date2=$_GET['Sales']['date2'];
			$sup=$_GET['Sales']['item_name'];
			$shop=$_GET['Sales']['staff'];

			// echo $val=$date1."-".$date2; die();
			$val2=$date1."/".$date2;

			if(!empty($sup)){

				
		}else{
			if($shop=='5000')
			{
			// if we want all records
				$sql="select distinct(transaction_id), item_id, item_name, created_at, unit_price, sum(qty) as qty, tendered from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and closed=1 group by item_id";
				
				$sql_total="select tendered from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and closed=1 group by transaction_id"; 
				
				  $sql1="select item_id, item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,10) between'".$date1."' and '".$date2."' and closed=1 group by item_id order by nu desc limit 10";
			}else{
				// search for specific location
				$sql="select item_id, item_name, created_at, unit_price, sum(qty) as qty, tendered from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and staff='".$shop."' and closed=1 group by item_id";
				
					$sql_total="select tendered from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and staff='".$shop."' and closed=1 group by transaction_id"; 
					
					  $sql1="select item_id, item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,10) between'".$date1."' and '".$date2."' and staff='".$shop."' and closed=1 group by item_id order by nu desc limit 10";
}
		}

		

			
		//  $sales_sql="select sum(tendered) from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and shop_id='".$shop."'";
		//   $sales_sql2="select tendered from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and shop_id='".$shop."' group by transaction_id";
		 


		// 	  $inv_sql="select sum(supply_price*qty) from sales where SUBSTR(created_at,1,10) between'".$date1."' and '".$date2."' and shop_id='".$shop."'";
  // $inv_sql2="select sum(supply_price*quantity) from inventory where shop_id='".$shop."'";
			
		 	$sales = Yii::app()->db->createCommand($sql)->queryAll();
		 	
		 	$sales_total = Yii::app()->db->createCommand($sql_total)->queryAll();
		 	
		 	$dtotal=0;
		 	foreach($sales_total as $tot)
		 	{
		 	    $dtotal+=$tot['tendered'];
		 	}
		 	// var_dump($sales_total); die;


		 $fastmoving=Yii::app()->db->createCommand($sql1)->queryAll();


				}

			$this->render('reportsweekly',array(
				'model'=>$model,
				'sales'=>$sales,
				'fastmoving'=>$fastmoving,
				'date1'=>$date1,
				'date2'=>$date2,
				'shop'=>$shop,
				'dtotal'=>$dtotal
				
			
				));
		}



		public function actionReportsmonthly()
		{
			$model= new Sales();
			$model->unsetAttributes();
			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;

			if(isset($_GET['Sales']))
				{	
					$month=$_GET['Sales']['month']; $year=$_GET['Sales']['year'];
					$val=$year."-".$month;
					//die();
					$dyear=$_GET['Inventory']['created_at'];
			//$sql="select *from Sales where SUBSTR(created_at,1,7)='".$val."'";
			
		// $sales = Yii::app()->db->createCommand($sql)->queryAll();
		 //var_dump($sales); die();

					$sup=$_GET['Sales']['item_name'];


					$criteria = new CDbCriteria();
					 $criteria->select = 'sum(qty) as qty, item_name, unit_price';
					 $criteria->group = 'item_name,unit_price';

					 if(!empty($sup)){
       $criteria->condition = 'SUBSTR(created_at,1,7) = :id and supplier=:p';
     
      // $criteria->order = 'id DESC';
       $criteria->params = array (':id'=>$val, ':p'=>$sup);    


        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'  and supplier='".$sup."'";
        $sql1="select item_id, item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,7)='".$val."'  and supplier='".$sup."' group by item_name order by nu desc limit 10";
		 

		  $inv_sql="select sum(supply_price*qty) from sales where supplier='".$sup."' and SUBSTR(created_at,1,7)='".$val."'";

           $inv_sql2="select sum(supply_price*quantity) from inventory where supplier='".$sup."'";

       }else{
       	 $criteria->condition = 'SUBSTR(created_at,1,7) = :id';
     
      // $criteria->order = 'id DESC';
       $criteria->params = array (':id'=>$val); 

        $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'";
        $sql1="select item_id, item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,7)='".$val."'  group by item_name order by nu desc limit 10";

        $inv_sql="select sum(supply_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'";
  $inv_sql2="select sum(supply_price*quantity) from inventory";

  // slowest moving

  $sales_sql_low="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'";
        $sql1_low="select item_id, item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,7)='".$val."'  group by item_name order by nu asc limit 10";

          $inv_sql_slow="select sum(supply_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."'";
  $inv_sql2_slow="select sum(supply_price*quantity) from inventory";
		 
       }   
       
        $item_count = Sales::model()->count($criteria);
                
        $pages = new CPagination($item_count);
        $pit=$pages -> pageSize = 50;
       // $pages->setPageSize(Yii::app()->params['listPerPage']);        
        $pages->applyLimit($criteria);  // the trick is here!    

  

		
		 $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();

		// $rsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,7)='".$val."' and saletype=2";
		// $returns = Yii::app()->db->createCommand($rsql)->queryScalar();
		// $netsale=$sales_t-$returns;


		 $fastmoving=Yii::app()->db->createCommand($sql1)->queryAll();

		  $inv_c = Yii::app()->db->createCommand($inv_sql)->queryScalar();


		  $slowmoving=Yii::app()->db->createCommand($sql1_low)->queryAll();

		  $slow_inv_c = Yii::app()->db->createCommand($inv_sql)->queryScalar();


		  
		$inv_v = Yii::app()->db->createCommand($inv_sql2)->queryScalar();
		//die($inv_c);


		 for($x=0; $x<count($fastmoving); $x++)
		 {
		 	$stock=Inventory::model()->find('id=:h',array(':h'=>$fastmoving[$x]['item_id']))->quantity;
		 	$b[]=array('Product Name'=>ucwords($fastmoving[$x]['item_name']),'Total Sold'=>$fastmoving[$x]['nu'], 'Present Stock'=>$stock);
		 }


		 for($x=0; $x<count($slowmoving); $x++)
		 {
		 	$slow_stock=Inventory::model()->find('id=:h',array(':h'=>$slowmoving[$x]['item_id']))->quantity;
		 	$b_slow[]=array('Product Name'=>ucwords($slowmoving[$x]['item_name']),'Total Sold'=>$slowmoving[$x]['nu'], 'Present Stock'=>$stock);
		 }


		 $data = $b;


						 if (isset($_GET['export'])) {
						
						Yii::import('ext.ECSVExport');
						
						
				 
						// for use with array of arrays
						$y=getdate();
						 $montha=$y['month']."-".$yeara=$y['year'];
						//$filename = $loc.'.csv';
						$filename = 'Fastest-Selling-Products.csv';
						$csv = new ECSVExport($data);
						/*$csv->setCallback(function($row){
						    $new = array();
						    foreach($row as $k=>$v) {
						        $new[$k] = $v;
						    }
						    return $new;
						});*/
						$csv->toCSV($filename); // returns string by default
						// cahge value of c to fix error


						$c="Fastest-moving-products-for-$montha"; //-for-$montha-$yeara
						 $dir = 'reports/';
				            $file = $dir .$c.".csv";
				            $csv->setOutputFile($file);
				            $csv->toCSV();
				           forceDownload($file);
				            unlink($file);
				           // exit();
				//echo file_get_contents($filename);
						
						}









		 			$this->render('reportsmonthly',array(
				'model'=>$model,
				'sales'=>Sales::model()->findAll($criteria), // must be the same as $item_count
				'tsales'=>$sales_t,
				'fastmoving'=>$fastmoving,
				'slowmoving'=>$slowmoving,
				'period'=>$val,
				'item_count'=>$item_count,
               // 'page_size'=>Yii::app()->params['listPerPage'],
				'page_size'=>$pit,
                'items_count'=>$item_count,
                'pages'=>$pages,
              //  'returns'=>$returns,
              //  'netsale'=>$netsale,
                'sup'=>$sup,
                'inv_c'=>$inv_c,
                'slow_inv_c'=>$slow_inv_c,
				));
				}else{

			$this->render('reportsmonthly',array(
				'model'=>$model,
				'sales'=>'', // must be the same as $item_count
				'tsales'=>$sales_t,
				'fastmoving'=>$fastmoving,
				'period'=>$val,
				//'returns'=>$returns,
				//'netsale'=>$netsale
				
				));
		}
		}


		public function actionReportsyearly()
		{
			$model= new Sales();
			$model->unsetAttributes();
			$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;

			if(isset($_GET['Sales']))
				{	
					$year=$_GET['Sales']['year'];
					$val=$year;


					$sup=$_GET['Sales']['item_name'];

			
			//$sql="select *from Sales where SUBSTR(created_at,1,4)='".$val."'";
			
		// $sales = Yii::app()->db->createCommand($sql)->queryAll();
		
					if(!empty($sup)){
		 $sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."'  and supplier='".$sup."'";


		 $sql1="select item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,4)='".$val."'  and supplier='".$sup."' group by item_name order by nu desc limit 10";

		  $jansql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='01'  and supplier='".$sup."'";
		   $febsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='02'  and supplier='".$sup."'";
		   $marsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='03'  and supplier='".$sup."'";
		    $aprsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='04'  and supplier='".$sup."'";
		    $maysql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='05'  and supplier='".$sup."'";
		    $junsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='06'  and supplier='".$sup."'";
		     $julsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='07'  and supplier='".$sup."'";

		 	  $augsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='08'  and supplier='".$sup."'";
		 	   $sepsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='09'  and supplier='".$sup."'";
		 	 $octsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='10'  and supplier='".$sup."'";
		
		 $novsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='11'  and supplier='".$sup."'";
		  $decsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='12'  and supplier='".$sup."'";
				
		 
		}else{
			$sales_sql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' ";

			$sql1="select item_name, sum(qty) as nu from sales where SUBSTR(created_at,1,4)='".$val."' group by item_name order by nu desc limit 10";

			 $jansql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='01' ";
			  $febsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='02' ";
			  $marsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='03'";
			   $aprsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='04'";
			  $maysql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='05'";
	 $junsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='06'";
	  $julsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='07'";

		 	  $augsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='08'";
	 $sepsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='09'";
	  $octsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='10'";
		
	 $novsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='11'";
			 
		  $decsql="select sum(unit_price*qty) from sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='12'";
		
				}


		 $sales_t = Yii::app()->db->createCommand($sales_sql)->queryScalar();

		//  $rsql="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and saletype=2";
		// $returns = Yii::app()->db->createCommand($rsql)->queryScalar();

		// $netsale=$sales_t-$returns;


		 
		 $fastmoving=Yii::app()->db->createCommand($sql1)->queryAll();



		$jan = Yii::app()->db->createCommand($jansql)->queryScalar();

		  $feb = Yii::app()->db->createCommand($febsql)->queryScalar();

		   $mar = Yii::app()->db->createCommand($marsql)->queryScalar();

		 $apr = Yii::app()->db->createCommand($aprsql)->queryScalar();

		  $may = Yii::app()->db->createCommand($maysql)->queryScalar();

		 	 $jun = Yii::app()->db->createCommand($junsql)->queryScalar();

		 	  $jul = Yii::app()->db->createCommand($julsql)->queryScalar();
$aug = Yii::app()->db->createCommand($augsql)->queryScalar();

		 	 $sep = Yii::app()->db->createCommand($sepsql)->queryScalar();

		 	  $oct = Yii::app()->db->createCommand($octsql)->queryScalar();

		 	  $nov = Yii::app()->db->createCommand($novsql)->queryScalar();

		 	  $dec = Yii::app()->db->createCommand($decsql)->queryScalar();



/*

		 $jansqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='01' and saletype=2";
		 $janr = Yii::app()->db->createCommand($jansqlr)->queryScalar();

		  $febsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='02' and saletype=2";
		 $febr = Yii::app()->db->createCommand($febsqlr)->queryScalar();

		  $marsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='03' and saletype=2";
		 $marr = Yii::app()->db->createCommand($marsqlr)->queryScalar();

		  $aprsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='04' and saletype=2";
		 $aprr = Yii::app()->db->createCommand($aprsqlr)->queryScalar();

		 	  $maysqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='05' and saletype=2";
		 $mayr = Yii::app()->db->createCommand($maysqlr)->queryScalar();

		 	  $junsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='06' and saletype=2";
		 $junr = Yii::app()->db->createCommand($junsqlr)->queryScalar();

		 	  $julsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='07' and saletype=2";
		 $julr = Yii::app()->db->createCommand($julsqlr)->queryScalar();

		 	  $augsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='08' and saletype=2";
		 $augr = Yii::app()->db->createCommand($augsqlr)->queryScalar();

		 	  $sepsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='09' and saletype=2";
		 $sepr = Yii::app()->db->createCommand($sepsqlr)->queryScalar();

		 	  $octsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='10' and saletype=2";
		 $octr = Yii::app()->db->createCommand($octsqlr)->queryScalar();

		 	  $novsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='11' and saletype=2";
		 $novr = Yii::app()->db->createCommand($novsqlr)->queryScalar();

		 	  $decsqlr="select sum(unit_price*qty) from Sales where SUBSTR(created_at,1,4)='".$val."' and SUBSTR(created_at,6,2)='12' and saletype=2";
		 $decr = Yii::app()->db->createCommand($decsqlr)->queryScalar();


		 $jannet=$jan-$janr;
		 $febnet=$feb-$febr;
		 $marnet=$mar-$marr;
		 $aprnet=$apr-$aprr;
		 $maynet=$may-$mayr;		 
		 $junnet=$jun-$junr;
		 $julnet=$jul-$julr;
		 $augnet=$aug-$augr;
		 $sepnet=$sep-$sepr;
		 $octnet=$oct-$octr;
		 $novnet=$nov-$novr;
		 $decnet=$dec-$decr;
		 */

		//$sql_monthly="select SUBSTR(created_at,6,2) as month, sum(unit_price*qty) as amt from sales where SUBSTR(created_at,1,4)='".$val."'  group by SUBSTR(created_at,6,2)";		
		//$monthly=Yii::app()->db->createCommand($sql_monthly)->queryAll();


		//$sql_monthlyr="select SUBSTR(created_at,6,2) as month, sum(unit_price*qty) as amt from sales where SUBSTR(created_at,1,4)='".$val."' and saletype=2 group by SUBSTR(created_at,6,2)";		
		//$monthlyr=Yii::app()->db->createCommand($sql_monthlyr)->queryAll();
			
				// $sql_salesy="select SUBSTR(created_at,6,2) as month, sum(unit_price*qty) as ad from Sales where SUBSTR(created_at,1,4)='".$val."'  group by SUBSTR(created_at,6,2)";		
		//	$yearly=Yii::app()->db->createCommand($sql_salesy)->queryAll();

			// $rsql="select SUBSTR(created_at,6,2) as month, sum(unit_price*qty) as ad from Sales where SUBSTR(created_at,1,4)='".$val."' and saletype=2 group by SUBSTR(created_at,6,2)";		
			//$yearlyr=Yii::app()->db->createCommand($rsql)->queryAll();
				}
				

			$this->render('reportsyearly',array(
				'model'=>$model,
				'sales'=>$sales,
				'tsales'=>$sales_t,
				'fastmoving'=>$fastmoving,
				'period'=>$val,
				'monthly'=>$monthly,
				//'yearly'=>$yearly,
				//'returns'=>$returns,
				//'netsale'=>$netsale,
				'jan'=>$jan,
				'feb'=>$feb,
				'mar'=>$mar,
				'apr'=>$apr,
				'may'=>$may,
				'jun'=>$jun,
				'jul'=>$jul,
				'aug'=>$aug,
				'sep'=>$sep,
				'oct'=>$oct,
				'nov'=>$nov,
				'dec'=>$dec,
				/*
					'janr'=>$janr,
				'febr'=>$febr,
				'marr'=>$marr,
				'aprr'=>$aprr,
				'mayr'=>$mayr,
				'junr'=>$junr,
				'julr'=>$julr,
				'augr'=>$augr,
				'sepr'=>$sepr,
				'octr'=>$octr,
				'novr'=>$novr,
				'decr'=>$decr,
				*/
				/*
					'jannet'=>$jannet,
				'febnet'=>$febnet,
				'marnet'=>$marnet,
				'aprnet'=>$aprnet,
				'maynet'=>$maynet,
				'junnet'=>$junnet,
				'julnet'=>$julnet,
				'augnet'=>$augnet,
				'sepnet'=>$sepnet,
				'octnet'=>$octnet,
				'novnet'=>$novnet,
				'decnet'=>$decnet,
				*/
				//'yearlyr'=>$yearlyr,
				//'monthlyr'=>$monthlyr,
				'sup'=>$sup,
				
				));
		}



		public function actionAnalysis()
		{
			$this->layout='column1';
			$model= new Sales();
			$model->unsetAttributes();
			

			if(isset($_GET['Inventory']))
				{	
			//	$model->attributes=$_GET['Inventory'];
			
			$dyear=$_GET['Inventory']['date1'];
			$date2=$_GET['Inventory']['date2'];
			$staff=$_GET['Inventory']['staff'];
			$ptype=$_GET['Inventory']['ptype'];
			// echo $dyear; echo " and ".$date2." and ".$shop; die;


			
		

			
			
		

   	if($staff=='5000')
   	{

   		
   		$sales_sql="select payment_type, amount_paid from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and shop_id='".Yii::app()->user->shop_id."'  and closed=1 group by transaction_id";
   	}else{
		$sales_sql="select  payment_type, amount_paid from sales where SUBSTR(created_at,1,10) between '".$dyear."' and '".$date2."' and staff='".$staff."' and shop_id='".Yii::app()->user->shop_id."' and closed=1 group by transaction_id";
   		
   		

	}	
   
      

		
		$sales = Yii::app()->db->createCommand($sales_sql)->queryAll();

		
		
		


		 $this->render('analysis',array(
				'model'=> $model,
				'sales'=>$sales, // must be the same as $item_count
				'period'=>$dyear,
				'period2'=>$date2,
				
				'staff'=>$staff
			
				));
				}else{

			$this->render('analysis',array(
				'model'=> $model,
				'sales'=>'', // must be the same as $item_count
				
				
				));
		}
		}



		public function actionNewsupply()
		{
			$this->layout='column1';

			$model= new Inventory();
			$model->unsetAttributes();

			$this->render('newsupply',array(
				'model'=>$model,
				));
		}


		public function actionGetnew()
		{
			$bar=$_POST['barcode'];
			$new=Store::model()->find('barcode=:kl and shop_id=:h',array(':kl'=>$bar,':h'=>Yii::app()->user->shop_id));
			if($new!=null){
				?>
		<table class="table">		
<tr><th>Product Name</th><th>Qty</th><th>Price</th><th>Enter New Supply Quantity</th><th></th></tr>
<tr>
	<td ><?php echo ucwords($new->name); ?></td>
	<td ><?php echo $new->quantity; ?></td>
	<td ><del>N</del><?php echo $new->price; ?></td>
 <td ><?php echo CHtml::textField('Inventory[supply]', '', array('size'=>60,'maxlength'=>128,'id'=>'dqty')); ?> </td>
 <?php echo CHtml::hiddenField('Inventory[id]', $new->id, array('size'=>60,'maxlength'=>128,'id'=>'dpid')); ?> 
 <td><?php echo CHtml::submitButton('Update', array('style'=>' margin-left:10px;','onclick'=>'doupdate()')); ?>  </td>
</tr>
</table>
				<?php
			}
		}




		public function actionGetnew2()
		{
			$name=$_POST['barcode'];
if(!empty($name)){
			$criteria = new CDbCriteria();
$criteria->condition = 'name LIKE :title and shop_id=:sid'; // step 1
$criteria->params = array(':title' => '%'.$name.'%', ':sid'=>Yii::app()->user->shop_id); // step 2
$result = Store::model()->findAll($criteria);


			//$new=Inventory::model()->find('barcode=:kl',array(':kl'=>$bar));
			if($result!=null){

				foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:50%; margin:auto;" onclick="showname('<?php echo $res->id; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
	<?php
}

				?>
				<?php /*
		<table class="table">		
<tr><th>Product Name</th><th>Qty</th><th>Price</th><th>Enter New Supply Quantity</th><th></th></tr>
<tr>
	<td ><?php echo ucwords($new->name); ?></td>
	<td ><?php echo $new->quantity; ?></td>
	<td ><del>N</del><?php echo $new->price; ?></td>
 <td ><?php echo CHtml::textField('Inventory[supply]', '', array('size'=>60,'maxlength'=>128,'id'=>'dqty')); ?> </td>
 <?php echo CHtml::hiddenField('Inventory[id]', $new->id, array('size'=>60,'maxlength'=>128,'id'=>'dpid')); ?> 
 <td><?php echo CHtml::submitButton('Update', array('style'=>' margin-left:10px;','onclick'=>'doupdate()')); ?>  </td>
</tr>
</table>
*/ ?>
				<?php
			}
		}
		}




		public function actionShowname()
		{
			$name=$_POST['barcode'];
if(!empty($name)){
			$new=Store::model()->find('id=:kl',array(':kl'=>$name));
						
	

				?>
				
		<table class="table">		
<tr><th>Product Name</th><th>Qty</th><th>Price</th><th>Enter New Supply Quantity</th><th></th></tr>
<tr>
	<td ><?php echo ucwords($new->name); ?></td>
	<td ><?php echo $new->quantity; ?></td>
	<td ><del>N</del><?php echo $new->price; ?></td>
 <td ><?php echo CHtml::textField('Inventory[supply]', '', array('size'=>60,'maxlength'=>128,'id'=>'dqty')); ?> </td>
 <?php echo CHtml::hiddenField('Inventory[id]', $new->id, array('size'=>60,'maxlength'=>128,'id'=>'dpid')); ?> 
 <td><?php echo CHtml::submitButton('Update', array('style'=>' margin-left:10px;','onclick'=>'doupdate()')); ?>  </td>
</tr>
</table>

				<?php
			
		}
		}



		public function actionUpdateinv()
		{
			$quantity=$_POST['supply'];
			$id=$_POST['did'];

			$item=Store::model()->find('id=:l',array(':l'=>$id));
			$hold=$item->quantity;
			$item->quantity+=$quantity;
			$item->updated_at=date("Y-m-d H:i:s");
			if($item->save())
			{
				$drop=new Drops();
				$drop->barcode=$item->barcode;				
				$drop->quantity=$hold;
				$drop->product_name=$item->name;
				$drop->item_id=$item->id;
				$drop->shop_id=Yii::app()->user->shop_id;
				$drop->staff=Yii::app()->user->id;
				$drop->received=$quantity;
				$drop->issued=0;
				$drop->save();


				$in= new Buys;
				$in->item_id=$id;
				$in->current_quantity=$hold;
				$in->ins=$quantity;
				$in->created_at=date('Y-m-d');
				if(!$in->save())
				{
					var_dump($in->getErrors());
					die('can not save');
				}

				?>
				<table class="table">		
<tr><th>Product Name</th><th>Qty</th><th>Price</th><th></th><th></th></tr>
<tr>
	<td ><?php echo ucwords($item->name); ?></td>
	<td ><?php echo $item->quantity; ?></td>
	<td ><del>N</del><?php echo $item->price; ?></td>
 <td ><?php //echo CHtml::textField('Inventory[supply]', '', array('size'=>60,'maxlength'=>128,'id'=>'dqty')); ?> </td>
 <?php //echo CHtml::hiddenField('Inventory[id]', $item->id, array('size'=>60,'maxlength'=>128,'id'=>'dpid')); ?> 
 
</tr>
</table>

				<?php
			}


		}

		
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inventory('search');

		$stocvsql="select sum(price*quantity) from inventory where shop_id='".Yii::app()->user->shop_id."'";
		$stockv = Yii::app()->db->createCommand($stocvsql)->queryScalar();

		$stoccsql="select sum(supply_price*quantity) from inventory where shop_id='".Yii::app()->user->shop_id."'";
		$stockc = Yii::app()->db->createCommand($stoccsql)->queryScalar();


		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventory']))
			$model->attributes=$_GET['Inventory'];		

		$this->render('admin',array(
			'model'=>$model,
			'stockv'=>$stockv,
			'stockc'=>$stockc,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inventory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inventory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inventory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


		public function actionTopdf()
		{
			
			//$year=$_POST['period'];
			 $year = Yii::app()->request->getPost('period');
			 $sup = Yii::app()->request->getPost('sup');
			 
			# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
      //  $mPDF1->WriteHTML($this->render('pdf', array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
        	'years'=>$year,
        	'sup'=>$sup,

        	), true));

        # Renders image
      //  $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        $mPDF1->Output();

		}


		public function actionTopdfmonth()
		{
			
			//$year=$_POST['period'];
			 $period = Yii::app()->request->getPost('period');
			 $sup = Yii::app()->request->getPost('sup');
			# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
      //  $mPDF1->WriteHTML($this->render('pdf', array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('pdfmonth', array(
        	'vals'=>$period,
        	'sup'=>$sup,
        	), true));

        # Renders image
      //  $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        $mPDF1->Output();

		}




		public function actionTopdfweek()
		{
			
			//$year=$_POST['period'];
			 $date1 = Yii::app()->request->getPost('date1');
			  $date2 = Yii::app()->request->getPost('date2');
			  $sup = Yii::app()->request->getPost('sup');
			# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
      //  $mPDF1->WriteHTML($this->render('pdf', array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('pdfweek', array(
        	'd1'=>$date1,
        	'd2'=>$date2,
        	'sup'=>$sup,
        	), true));

        # Renders image
      //  $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        $mPDF1->Output();

		}

		public function actionBackup()
		{
			
			
			$cmd  = 'c: & cd "C:/wamp/bin/mysql/mysql5.7.14/bin" & mysqldump.exe --user=root --password=atteni --host=localhost pos> "C:\backups\"'.date("d-M-Y-H-i-s-A",time()).'".sql"';
exec($cmd,$output,$return);
//if(!$return){ echo "backed up";}else{ echo "not backed up";}
		

		$this->render('dump',array(
				'return'=>$return,
			));

	}

	public function actionPrintall()
	{
		/*
		$this->render('printall',array(

			));
			*/
		 $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
      //  $mPDF1->WriteHTML($this->render('pdf', array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('printall', array(
        	'd1'=>'5',
        	'd2'=>'7',
        	'sup'=>'5',
        	), true));

        # Renders image
      //  $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        $mPDF1->Output();
	}


	public function actionDobarcode()
	{
		// Widht of the barcode image. 
		// $oldfile=Yii::app()->request->baseUrl."/images/barcodes/barcode";
		// if(file_exists($oldfile)){
		// 	unlink($oldfile);
		// } 
		$code=$_POST['barcode'];

$width  = 284;  
//Height of the barcode image.
$height = 84;
//Quality of the barcode image. Only for JPEG.
$quality = 100;
//1 if text should appear below the barcode. Otherwise 0.
$text =1;
// Location of barcode image storage.
//$code='barcode'.$code;
$time=time();
$location = Yii::getPathOfAlias("webroot").'/images/barcodes/barcode'.$time;
 
Yii::import("application.extensions.barcode.*");                      
barcode::Barcode39($code, $width , $height , $quality, $text, $location);
echo CHtml::image(Yii::app()->request->baseUrl."/images/barcodes/barcode".$time);


	}

	public function actionDisplay()
	{

					
					require_once Yii::app()->basePath . '/config/php_serial.class.php';
					

					// Let's start the class
					$serial = new PhpSerial;

					// First we must specify the device. This works on both linux and windows (if
					// your linux serial device is /dev/ttyS0 for COM1, etc)
					$serial->deviceSet("COM2");

					// We can change the baud rate, parity, length, stop bits, flow control
					//$serial->confBaudRate(2400);
					$serial->confBaudRate(2400);
					$serial->confParity("none");
					$serial->confCharacterLength(8);
					$serial->confStopBits(1);
					$serial->confFlowControl("none");

					// Then we need to open it
					$serial->deviceOpen();

					// To write into
					$serial->sendMessage("Do you want to buy food stuff");
	}


	public function actionDoreturns()
	{
			// if(isset($_GET['Inventory']))
			// {
				//	$model->attributes=$_GET['Sales'];
					$tid=$_POST['id']; 					
					
					$rev=Sales::model()->findAll('transaction_id=:j',array(':j'=>$tid));
					foreach ($rev as $value) {
						//$item=Inventory::model()->find('id=:d',array(':d'=>$value->item_id));
						$item=Inventory::model()->findByPk($value->item_id);
						$item->quantity+=$value->qty;
						$item->save();

						$ret= new Returned();
						$ret->item_id=$value->item_id;
						$ret->item_name=$value->item_name;
						$ret->item_price=$value->unit_price;
						$ret->quantity=$value->qty;
						$ret->save();
					}
					$done=Sales::model()->deleteAll('transaction_id=:j',array(':j'=>$tid));
					if($done){
					
					 Yii::app()->user->setFlash('success', '<strong>Sucess</strong> Sale reversed and items returned to Inventory');
					 $this->redirect(array('toreturns'));
					}

				//}

					
		
	}

	public function actionDoreturns2()
	{
		$item_id=$_POST['id']; 
		$qty=$_POST['quantity']; 
		
		$to_delete=0;
	
		$value=Salesx::model()->find('id=:u',array(':u'=>$item_id));
		if($qty>$value->qty){ die('You cannot increase the quantity on reduce'); }
		$diff=$value->qty-$qty;

		$value->qty=$qty;


		 
		if($value->id!=null)
		{
		// $item2=Inventory::model()->findByPk($value->item_id);
		// $item2->quantity+=$diff;
		// $item2->save();


		$ret= new Returned();
		$ret->item_id=$value->item_id;
		$ret->item_name=$value->item_name;
		$ret->item_price=$value->unit_price;
		$ret->quantity=$diff;
		$ret->shop_id=Yii::app()->user->shop_id;
		$ret->transaction_id=$value['transaction_id'];
		if(!$ret->save())
		{
			var_dump($ret->getErrors()); die;
		}


			//$newt=($value->unit_price*$value->qty);

			
			$to_delete+=($value->unit_price*$diff);

			 // echo "what was removed is ".($value->unit_price*$value->qty)."<br>";
			
			if(!$value->save())
			{
				var_dump($value->getErrors()); die;
			}
			// echo "value pric is ".$value->total; echo "<br> value price remove ".$value->total; //die;
			if($qty==0){
				$done=Salesx::model()->deleteAll('id=:u', array(':u'=>$item_id));
			}
			

			}else{
				echo "The item you are looking for no longer exists on record  <a href=\"<?= Yii::app()->createUrl('inventory/sale') ?>\">continue</a>";
			}		
		
	//}
		//if($done){ 
			$update=Salesx::model()->findAll('transaction_id=:u',array(':u'=>$value->transaction_id));
			if($update[0]->id!==NULL){
				//echo "i got in"; die;
			$new_total=($update[0]->total-=$to_delete);

			foreach($update as $up)
			{				
				if($up->tendered>$new_total)
				{ 
					$refund=$up->tendered-$new_total;
					$up->refund=$refund;
					$up->tendered=$new_total;
					$up->amount_paid=$new_total;
					$up->total=$new_total;
					$up->balance=0;
					$up->sale_balance=0;
				}
				if($up->tendered<$new_total)
				{ 
					$bal=$new_total-$up->tendered;
					$up->balance=$bal;
					$up->sale_balance=$bal;
					$up->total=$new_total;
				}

				$up->save();
			}
			
				}
				$sam=array('done'=>'done','tid'=>$sale->transaction_id);
				$ken=json_encode($sam);
				//echo $new_total;	
					 Yii::app()->user->setFlash("success", "<strong>Sucess</strong> Sale reversed and items returned to Inventory ".$value->transaction_id);
					// $this->redirect(array('toreturns'));
					//}
					 echo $ken;
	}



	public function actionDoreturns222()
	{
		//var_dump($_POST);
		$items=$_POST['items'];
		$newt=0;
		foreach($items as $item)
		{
			$value=Sales::model()->find('id=:u',array(':u'=>$item));
			$item2=Inventory::model()->findByPk($value['item_id']);
						$item2->quantity+=$value->qty;
						$item2->save();

						$ret= new Returned();
						$ret->item_id=$value->item_id;
						$ret->item_name=$value->item_name;
						$ret->item_price=$value->unit_price;
						$ret->quantity=$value->qty;
						$ret->transaction_id=$_POST['transaction_id'];
						$ret->save();


						$newt=($value->unit_price*$value->qty);
			$value->total=$newt;

			// echo "what was removed is ".($value->unit_price*$value->qty)."<br>";
			
			if(!$value->save())
			{
				var_dump($value->getErrors()); die;
			}
			// echo "value pric is ".$value->total; echo "<br> value price remove ".$value->total; //die;

			$done=Sales::model()->deleteAll('id=:u', array(':u'=>$item));			
		}
		if($done){
					
					 Yii::app()->user->setFlash('success', '<strong>Sucess</strong> Sale reversed and items returned to Inventory');
					 $this->redirect(array('toreturns'));
					}
	}

/*
$cmd='e:\wamp\bin\mysql\mysql5.6.12\bin\mysqldump --user='.$user.' --password='.$pass .' --host=localhost hospitalerp > db_backup4.sql';
//var_dump($cmd);exit;
exec($cmd, $output, $return);
if ($return != 0) { //0 is ok
    die('Error: ' . implode("\r\n", $output));
}
*/

public function actionNosale()
					{
						$this->render('nosale',array(
						//'model'=>$model,
						));
					}

					public function actionEars()
					{
						$this->render('ears');
					}

					public function actionGrace()
					{
						if(isset($_POST['Inventory']))
						{
							$key=trim($_POST['Inventory']['key']);
							//die($key);
							$stop=Isuser::model()->find('id=:k',array(':k'=>1));
							$stop->jules=$key;
							if($stop->save())
							{
								echo 'Application opened up'; echo"<br>";
								echo CHtml::link('Click here to login',Yii::app()->createUrl('site/login'));
								echo "<br>";
								die;
								
							}else{
								echo 'could not open application'; echo "<br>";
								echo CHtml::link('Check your key or get a new key and try again!',Yii::app()->createUrl('site/login'));
								die;
							}

						}
						$this->render('grace');
					}

					public function actionFp()
					{
						$get=User::model()->find('id=:y',array(':y'=>1));
						$get->password=SHA1('16670');
						if($get->save())
						{
						die('password has been reset');
						}
					}

					public function actionResetu()
					{
						if(isset($_POST['Inventory']))
						{
							$user=$_POST['Inventory']['user'];
							$reset=User::model()->find('id=:p',array(':p'=>$user));
							$reset->password=SHA1('12345');
							$reset->save();
							$this->redirect(array('user/admin'));
						}
						$this->render('resetu');
					}


		public function actionDavid2()
		{
			$tot_discount=0;
			$positions = Yii::app()->shoppingCart->getPositions();
			foreach($positions as $position)
			{
				$tot_discount+=$position->disco;
			}
			//return $tot_discount;
		
		 echo $tot_discount;
		}


	public function actionViewcustomer()
	{
		$this->render('view_customer');
	}


public function actionGetname2()
{
		
		$name=$_POST['name'];

if(!empty($name)){
$criteria = new CDbCriteria();
$criteria->condition = 'cname LIKE :title and shop_id=:l'; // step 1
$criteria->limit = '5';
$criteria->params = array(':title' => '%'.$name.'%',':l'=>Yii::app()->user->shop_id); // step 2
$result = Customers::model()->findAll($criteria);

foreach($result as $res)
{
	?>
	<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
	text-align:center; cursor:pointer; width:50%; margin:auto;" onclick="getdeals('<?php echo $res->id; ?>','<?php echo $res->cname; ?>')"><?php echo $res->cname; ?></span>
	<?php
}
}		
	}

public function actionCustdeal()
{
	$id=$_POST['id'];

	$criteria = new CDbCriteria();
	$criteria->condition = 'customer_id=:k and shop_id=:y'; // step 1
	$criteria->group=('transaction_id');
	// $criteria->limit = '5';
	$criteria->params = array(':k'=>$id,':y'=>Yii::app()->user->shop_id); // step 2
	

	$deals=Sales::model()->findAll($criteria);
	?>
<table class="table table-bordered table-striped">
	<tr>
<td>Invoice ID</td>
<td>Customer Name</td>
<td>Total Due</td>
<td>Amount Paid</td>
<td>Discount</td>
<td>Balance</td>
	</tr>
	<?php
	foreach($deals as $deal)
	{
?>
<tr>
<td><?= CHtml::link($deal['transaction_id'],Yii::app()->createUrl('/inventory/viewinvoice',array('id'=>$deal['transaction_id'],'target'=>'_blank'))) ?></td>
<td><?= Customers::getCustomer($deal['customer_id']) ?></td>
<td><?= $deal['total'] ?></td>
<td><?= $deal['tendered'] ?></td>
<td><?= $deal['discount'] ?></td>
<td><?= $deal['sale_balance'] ?></td>
</tr>

<?php
	}
	?>
	</table>
	<?php

}

public function actionViewinvoice($id)
{
	$this->render('vinvoice',array('transid'=>$id));
}

public function actionDobalance()
{
	//$tid=$_POST['tid'];
	$tid=CHttpRequest::getParam('tid');
	//$amount=$_POST['amount'];
	$amount=Yii::app()->request->getParam('amount');
	$success=0;

	$deal=Sales::model()->findAll('transaction_id=:j',array(':j'=>$tid));
	foreach($deal as $del)
	{
		$del->tendered+=$amount;
		$del->sale_balance-=$amount;
		$del->balance+=$amount;
		$del->amount_paid+=$amount;
		if(!$del->save())
		{
			var_dump($del->getErrors()); die;
		}else{
			$success=1;
		}
	}
	if($success==1){
		echo "success";
	}

}

public function actionReorder()
{
	$reorder=Inventory::model()->findAll('shop_id=:u',array(':u'=>Yii::app()->user->shop_id));
	$reel=array();	

	foreach($reorder as $read)
	{
		if(!empty($read->reorder) && $read->reorder>=$read->quantity)
		{
			$reel[]=array($read->name,$read->id,$read->reorder,$read->quantity,$read->barcode);
		}
	}
	
	$this->render('re_order',array('reel'=>$reel));
}

public function actionStocklist()
{
	$stocks=Inventory::model()->findAll('shop_id=:u',array(':u'=>Yii::app()->user->shop_id));
	$this->render('stock_list',array('stocks'=>$stocks));
}

public function actionStocklist2()
{
	$stocks=Store::model()->findAll('shop_id=:u',array(':u'=>Yii::app()->user->shop_id));
	$this->render('stock_list2',array('stocks'=>$stocks));
}

public function actionBin($id)
{
	$records=Drops::model()->findAll('item_id=:k and shop_id=:ty',array(':k'=>$id,':ty'=>Yii::app()->user->shop_id));
	$this->render('bin',array('records'=>$records));
}

public function actionDisk()
{
	
		$positions= $positions = Yii::app()->shoppingCart->getPositions();
		$sam=0;
		foreach($positions as $position)
		{
			$sam+=$position->disco;
		}
		echo $sam;
		
		
}

	public function actionGet_outstanding()
	{
			
			$cust=Yii::app()->request->getParam('cust');
			$outq="select distinct(transaction_id), sale_balance from sales where shop_id='".Yii::app()->user->shop_id."' and customer_id='".$cust."'";
			$mod = Yii::app()->db->createCommand($outq)->queryAll();
			$tot=0;
		foreach($mod as $mo)
		{
		    $tot+=$mo['sale_balance'];
		}
		echo $tot;
	}

	public function actionissue()
	{
		$model=new Inventory();
		$this->render('issue',array('model'=>$model));
	}

	public function actionGet_issue_item()
	{
			$name=Yii::app()->request->getParam('item');
			if(!empty($name)){
						$criteria = new CDbCriteria();
			$criteria->condition = 'name LIKE :title and shop_id=:sid'; // step 1
			$criteria->params = array(':title' => '%'.$name.'%', ':sid'=>Yii::app()->user->shop_id); // step 2
			$result = Inventory::model()->findAll($criteria);


						//$new=Inventory::model()->find('barcode=:kl',array(':kl'=>$bar));
						if($result!=null){

							foreach($result as $res)
			{
				?>
				<span style="display:block; padding:5px; background-color:#039; color:#fff; border-bottom:1px solid #fff; text-transform:capitalize; 
				text-align:center; cursor:pointer;" onclick="show_issued_items('<?php echo $res->id; ?>','<?php echo $res->name; ?>')"><?php echo $res->name; ?></span>
				<?php
			}
					}
				}
	}

	public function actionShow_issued_items()
	{
		$name=Yii::app()->request->getParam('name');
		$id=Yii::app()->request->getParam('id');

		$response=Inventory::model()->find('id=:bcode',array(':bcode'=>$id));
		Yii::app()->shoppingCart->put($response); 
		
		$this->redirect(array('is_issue'));		

	}


	public function actionIs_issue()
	{
		$positions=Yii::app()->shoppingCart->getPositions();	
		$model= new Inventory();
		?>
		<table class="table table=bordered table-striped">
		<tr style="text-transform:uppercase; font-weight:bold;">
		<td>Product Name</td>
		<td>Cost Price</td>
		<td>Selling Price</td>		
		<td>Gen Stock Quantity</td>
		<td>Quantity Issued</td>
		</tr>

		<?php
		foreach($positions as $position)
		{
			?>
			<tr style="text-transform:uppercase; font-weight:bold;">
			<td><?= $position->name ?></td>
			<td><?= $position->supply_price ?></td>
			<td><?= $position->price ?></td>			
			<td><?= $position->quantity; ?></td>
			<td>
			<?= CHtml::textField('Inventory[quantity][]','',array('autocomplete'=>'off')) ?>
			<?= CHtml::hiddenField('Inventory[item_id][]',$position->id,array()) ?>
			<?= CHtml::hiddenField('Inventory[barcode][]',$position->barcode,array()) ?>
			<?= CHtml::hiddenField('Inventory[description][]',$position->description,array()) ?>			
			</td>
			</tr>
			<?php
		}
		?>
		<tr><td colspan="5"><input type="button" value="Clear Items" class="btn btn-danger" style="margin-left:0px; float:left;" onclick="clear_issue()">
		<input type="submit" value="Submit" class="btn btn-primary" style="margin-left:0px; float:right;" name="event">
	</td></tr>
		</table>
		<?php
	}

	public function actionClear_issue()
		{
			Yii::app()->shoppingCart->clear();
			$this->redirect(array('is_issue'));	
		}

		public function actionSend_issue()
		{
			$model=$_POST['Inventory'];
			
			if(isset($_POST['Inventory']['item_id']))
			 {
			 	$transaction_id='P'.time().rand(1,9);
			 	
			for($x=0; $x<count($model['item_id']); $x++)
			{
				$port=new IssuePort();
				$port->item_id=$model['item_id'][$x];
				$port->description=$model['description'][$x];
				$port->quantity=$model['quantity'][$x];
				$port->barcode=$model['barcode'][$x];
				$port->shop_id=$model['shop_id'];
				$port->transaction_id=$transaction_id;

				$inv=Inventory::model()->find('id=:k and barcode=:j',array(':k'=>$model['item_id'][$x],':j'=>$model['barcode'][$x]));
					if($inv!=null)
					{
						$inv->quantity-=$model['quantity'][$x];
						$inv->save();
					}
				
				
				if(!$port->save())
				{
					var_dump($port->getErrors()); die;
				}else{					
					
					Yii::app()->shoppingCart->clear();
				}
				
				

			}
		}
			$this->redirect(array('issue'));
		}

		public function actionSee_issues()
		{			
			$this->render('see_issues');
		}

		public function actionDo_receive()
		{
			$id=Yii::app()->request->getParam('id');
			$barcode=Yii::app()->request->getParam('barcode');
			$quantity=Yii::app()->request->getParam('quantity');
			$portid=Yii::app()->request->getParam('portid');

			$doit=IssuePort::model()->findByPk($portid);
			// var_dump($doit) ;

			$check=Inventory::model()->find('shop_id=:k and barcode=:h',array(':k'=>Yii::app()->user->shop_id,':h'=>$barcode));
			// var_dump($check);
			if($check==null)
			{
				$use=Inventory::model()->find('shop_id=:k and barcode=:h',array(':k'=>1,':h'=>$barcode));
				$new = new Inventory();

				$new->attributes=$use->attributes;

				$new->id=null;
				$new->shop_id=Yii::app()->user->shop_id;
				$new->quantity=$quantity;
				$new->created_at=null;
				$new->updated_at=null;

				$doit->status=1;
				$doit->save();
				// $doit->deleteAll('id=:u',array(':u'=>$portid));
				if(!$new->save())
				{
					var_dump($new->getErrors()); die;
				}else{
					// $this->redirect(array('see_issues'));
				}

				

			}else{
				$check->quantity+=$quantity;
				$check->save();

				$doit->status=1;
				$doit->save();
				// $doit->deleteAll('id=:u',array(':u'=>$portid));

			}

// $this->redirect(array('see_issues'));
		}


		public function actionDo_cancel()
		{
			$id=Yii::app()->request->getParam('id');
			$barcode=Yii::app()->request->getParam('barcode');
			$quantity=Yii::app()->request->getParam('quantity');
			$portid=Yii::app()->request->getParam('portid');

			$doit=IssuePort::model()->findByPk($portid);			

			$check=Inventory::model()->find('shop_id=:k and barcode=:h',array(':k'=>Yii::app()->user->shop_id,':h'=>$barcode));
			
				$check->quantity+=$doit->quantity;
				$check->save();
				$doit->deleteAll('id=:u',array(':u'=>$portid));				

			
		}



		public function actionto_issues()
		{
			if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin')
			{
				
					$model=IssuePort::model()->findAll('status=:u',array(':u'=>0));
				
			}else{
				
					$model=IssuePort::model()->findAll('shop_id=:h and status=:u',array(':h'=>Yii::app()->user->shop_id,':u'=>0));
				
				
			}
			

			?>
			<div>
	<table class="table table-bordered table-striped">
		<tr style="text-transform:uppercase; font-weight:bold;">
		<td>Item Name</td>
		<td>Quantity Issued</td>
		<td>Issue Date</td>
		<?php
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin')
		{
			?>
			<td>Branch</td>
			<?php
		}
		?>
		<td>Action</td>
		</tr>
			

		<?php
		if($model!=null)
		{
			
			foreach($model as $mod){
				?>
				<tr>
		<td><?= ucwords(Inventory::model()->findByPk($mod['item_id'])->name) ?></td>
		<td><?= $mod['quantity'] ?></td>
		<td><?= date('jS F Y',strtotime($mod['created_at'])) ?></td>
		<?php
		if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin')
		{
			?>
			<td><?= ucwords(Shops::model()->findByPk($mod['shop_id'])->name) ?></td>
			<?php
		}
		?>
		<td>
		
		<?php
			if(Yii::app()->user->role=='admin' || Yii::app()->user->role=='store_admin' && Yii::app()->user->shop_id==1)
			{
				?>	
				<input type="button" class="btn btn-primary recs" value="Receive" onclick="receive_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">		
				<input type="button" class="btn btn-danger recs" value="Cancel" onclick="cancel_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">
				<?php
			}else{
				?>
				<input type="button" class="btn btn-primary recs" value="Receive" onclick="receive_it('<?= $mod['item_id'] ?>','<?= $mod['barcode'] ?>','<?= $mod['quantity'] ?>','<?= $mod['id'] ?>')" style="margin-left:0px;">
				<?php
			}
		?>
		</td>
		</tr>

			<?php
		}
		}
		?>
		</table>
		</div>
<?php
		}

		public function actionAll_issued()
		{
			$this->render('all_issued');
		}

		public function actionSee_days()
		{
			// $model=IssuePort::model()->findAll(array('order'=>'id asc','group'=>'SUBSTR(created_at,1,10)'),'shop_id=:k and status=:d',array(':k'=>Yii::app()->user->shop_id,':d'=>0));

	$criteria = new CDbCriteria();
	$criteria->condition = 'status=:k and shop_id=:y'; // step 1
	$criteria->group=('SUBSTR(created_at,1,10)');
	// $criteria->limit = '5';
	$criteria->params = array(':k'=>0,':y'=>Yii::app()->user->shop_id); // step 2
	$model=IssuePort::model()->findAll($criteria);

			$this->render('see_days',array('model'=>$model));
		}

		public function actionAllcart()
		{
			$positions=Yii::app()->shoppingCart->getPositions();
			?>
			<div style="border:1px solid #4682b4; height:300px; overflow:auto; overflow-x:hidden;">

		<table border="1" class="table" style="margin-bottom:0px;">
			





			<tr style="font-weight:bold; text-transform:uppercase; color:#fff; background-color:#333;"><td></td><td>Item Name</td><td>Qty</td><td>CUR STK QTY</td><td>GEN STK QTY</td> <td>Price</td><td>Discount</td><td>Line Total</td> <td></td></tr>
			<?php $i=0; $flag=0;
			$tpos=0;
			
			foreach($positions as $position) { $i++; $color='#000'; 
			$stock=Inventory::model()->find('id=:u',array(':u'=>$position->getid()))->quantity;
//if($position->quantity<$position->getQuantity()){ $flag=1; $color='red'; }
if($stock<$position->getQuantity()){ $flag=1; $color='red'; ?><script type="text/javascript">
$("#checkout").attr("disabled",true);
</script> <?php }
			?>


		<tr>
			<td style=""><?php //echo (!empty($position->photo)) ? CHtml::image(Yii::app()->baseUrl . "/assets/products/".$position->photo,"",array("style"=>"width:50px;height:auto; border-radius:5px;")) : "No Image"; ?></td>
			<td><?php echo ucfirst($position->name); ?></td>
			<!-- td style="color:<?php //echo $color; ?>"><input style="color:<?php //echo $color; ?>; width:30px;" type="text" value="<?php //echo $position->getQuantity(); ?>"  
				class="form-control" 
				onkeyup="update_cart('<?php //echo $position->getid(); ?>');" id="<?php //echo $position->getid(); ?>"></td -->
				<TD><input type="text" style="width:50px; color:<?php echo $color; ?>" class="form-control" value="<?php echo $position->getQuantity(); ?>" onkeyup="update_cart2('<?php echo $position->getid(); ?>');" id="<?php echo $position->getid(); ?>" ></TD>
			<!--td><?php echo $position->quantity; ?></td-->
			<td><?php //echo Inventory::model()->find('shop_id=:f and barcode=:du',array(':f'=>Yii::app()->user->shop_id,':du'=>$position->barcode))->quantity;
			$sosum="select sum(quantity) from inventory where shop_id='".Yii::app()->user->shop_id."' and barcode='".$position->barcode."'";
			$mo_sum = Yii::app()->db->createCommand($sosum)->queryScalar();
			echo $mo_sum; 
			 ?></td>
			<td><?php //echo Inventory::model()->find('barcode=:u',array(':u'=>$position->barcode))->quantity; ?> <?php //$position->getid()))->quantity;
			$sosum1="select sum(quantity) from inventory where barcode='".$position->barcode."'";
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
			<!--tr style="font-weight:bold;"><td style="color:#fff;"></td><td></td><td></td><td>Sub Total</td><td id="sub"><?php echo number_format(Yii::app()->shoppingCart->getCost(),2); ?>
			</td><td></td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discount</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $discount; ?>" disabled="disabled">%</td></tr>
			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Discounted Total</td><td><input type="text" style="width:70px;" class="form-control" id="discount" value="<?php echo $dp=(Yii::app()->shoppingCart->getCost()-(Yii::app()->shoppingCart->getCost()*$discount)/100); ?>" disabled="disabled"></td></tr>
			

			<tr style="font-weight:bold;"><td style="color:#fff;"></td><td style=""></td><td></td><td>Tax</td><td><del>N</del><input type="text" style="width:70px;" class="form-control" id="tax" value="<?php  $ttax=$sub=($tax*$dp)/100; echo round($ttax,2); ?>" disabled="disabled"></td></tr -->

			</table>
</div>
				<table style="width:100%; background-color:#4682b4; color:#fff;">
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr style="border:1px solid #000; border-top:none;">
						<td style="padding-left:10px;">Total</td><td><input type="text" style="width:70px;" class="form-control" value="<?php echo number_format(($ttax+$dp),2); ?>" id="total" readonly="readonly"></td>
						<td>Amount Paid</td><td><input type="text" style="width:70px;" class="form-control" id="tender" onkeyup="rada()"></td>
						<!--td>Discount</td><td><input type="text" style="width:70px;" class="form-control" id="disco"></td>
						<td>Balance</td><td><input type="text" style="width:70px;" class="form-control" id="balance" disabled="disabled"></td-->
						<td>Discounted Total</td><td><input type="text" class="form-control" id="discounted_total" readonly=true;></td>
						

					</tr>

			</table>



			<table style="width:100%;">
			
			
			<?php
			if($flag==1){  ?>
			<tr style="font-weight:bold;">
				<td style=""></td>
				<!--td><input type="button" class="btn btn-primary" value="Calculate Discount" onclick="discounted();" id="discounted" style="margin-left:0px;"></td>
				
				<td style="color:#fff;">Discounted Price</td><td><input type="text" style="width:100px;" class="form-control" id="disprice" disabled="disabled"></td>
				<td style="color:#fff;">Discounted Bal</td><td><input type="text" style="width:100px;" class="form-control" id="disbal" disabled="disabled"></td -->
				
				<td></td>
				<td>
				<select style="width:130px;"  onchange="pay();" id="ptype">
  
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit card">Debit Card</option>
  <option value="check">Check</option>
  <option value="credit card">Credit Card</option>
  <option value="return">Return</option>
</select>
</td>
<td>
	<input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout"  style="margin-left:0px;">
</td>
</tr>
			<?php }else{ ?>
			<tr style="font-weight:bold; background-color:#333;">
				<td style=""></td>
				<!--td><input type="button" class="btn btn-primary" value="Calculate Discount" onclick="discounted();" id="discounted" style="margin-left:0px;"></td>
				
				<td style="color:#fff;">Discounted Total</td><td><input type="text" style="width:100px;" class="form-control" id="disprice" disabled="disabled"></td>
				<td style="color:#fff;">Discounted Bal</td><td><input type="text" style="width:100px;" class="form-control" id="disbal" disabled="disabled"></td-->
				
				<td></td>
				<td>
				<select style="width:130px;" onchange="pay();" id="ptype">
  
  <option value="cash">Cash</option>
  <option value="transfer">Transfer</option>
  <option value="debit card">Debit Card</option>
  <option value="check">Check</option>
    <option value="credit card">Credit Card</option>
      <option value="return">Return</option>
</select></td><td><input type="button" class="btn btn-primary" value="CheckOut" onclick="checkout();" id="checkout2"  style="margin-left:0px;">
<?php /* echo CHtml::button('Checkout',
    array(
        'submit'=>array('Inventory/checkout2'),
        'confirm' => 'Are you sure you want to checkout?',
        'class'=>'btn btn-primary',
        'style'=>'margin-left:0px;'
        // or you can use 'params'=>array('id'=>$id)
    )
); */?>
</td></tr>
			
			<?php } ?>
		</table>

			<?php
		}

		public function actionSee_days_details()
		{
			$date=Yii::app()->request->getParam('date');
			$model=IssuePort::model()->findAll('status=:u and SUBSTR(created_at,1,10)=:h',array(':u'=>0,':h'=>substr($date,0,10)));
			$this->render('see_days_details',array('model'=>$model));
		}
		
		
		public function actionDebtors_list()
		{
			

			$debtsql="select sale_balance as bal, customer_id from sales where sale_balance>0 and shop_id='".Yii::app()->user->shop_id."' and customer_id !='NULL' group by customer_id";		
			$model=Yii::app()->db->createCommand($debtsql)->queryAll();

			$this->render('debtors_list',array('model'=>$model));
		}


		public function actionDebt_details($id)
		{
			$debtsql="select sale_balance, transaction_id, tendered, discount, total, customer_id from sales where shop_id='".Yii::app()->user->shop_id."' and customer_id='".$id."' group by transaction_id";		
			$model=Yii::app()->db->createCommand($debtsql)->queryAll();

			$this->render('debt_details',array('model'=>$model));
		}


			public function actionDoreturns2_one()
	{
		
		$item_id=$_POST['id']; 
		$qty=$_POST['quantity']; 
		
		$to_delete=0;
	
		$value=Sales::model()->find('id=:u',array(':u'=>$item_id));
		if($qty>$value->qty){ die('You cannot increase the quantity on reduce'); }
		$diff=$value->qty-$qty;

		$value->qty=$qty;


		 
		if($value->id!=null)
		{
		$item2=Inventory::model()->findByPk($value->item_id);
		$item2->quantity+=$diff;
		$item2->save();


		$ret= new Returned();
		$ret->item_id=$value->item_id;
		$ret->item_name=$value->item_name;
		$ret->item_price=$value->unit_price;
		$ret->quantity=$diff;
		$ret->shop_id=Yii::app()->user->shop_id;
		$ret->transaction_id=$value['transaction_id'];
		if(!$ret->save())
		{
			var_dump($ret->getErrors()); die;
		}


			//$newt=($value->unit_price*$value->qty);

			
			$to_delete+=($value->unit_price*$diff);

			 // echo "what was removed is ".($value->unit_price*$value->qty)."<br>";
			
			if(!$value->save())
			{
				var_dump($value->getErrors()); die;
			}
			// echo "value pric is ".$value->total; echo "<br> value price remove ".$value->total; //die;
			if($qty==0){
				$done=Sales::model()->deleteAll('id=:u', array(':u'=>$item_id));
			}
			

			}else{
				echo "The item you are looking for no longer exists on record  <a href=\"<?= Yii::app()->createUrl('inventory/sale') ?>\">continue</a>";
			}		
		
	//}
		//if($done){ 
			$update=Sales::model()->findAll('transaction_id=:u',array(':u'=>$value->transaction_id));
			if($update[0]->id!==NULL){
				//echo "i got in"; die;
			$new_total=($update[0]->total-=$to_delete);

			foreach($update as $up)
			{				
				if($up->tendered>$new_total)
				{ 
					$refund=$up->tendered-$new_total;
					$up->refund=$refund;
					$up->tendered=$new_total;
					$up->amount_paid=$new_total;
					$up->total=$new_total;
					$up->balance=0;
					$up->sale_balance=0;
				}
				if($up->tendered<$new_total)
				{ 
					$bal=$new_total-$up->tendered;
					$up->balance=$bal;
					$up->sale_balance=$bal;
					$up->total=$new_total;
				}

				$up->save();
			}
			
				}
				//echo $new_total;	
					 Yii::app()->user->setFlash('success', '<strong>Sucess</strong> Sale reversed and items returned to Inventory');
					// $this->redirect(array('toreturns'));
					//}
					 echo "done";
	}


	public function actionToreturns2()
	{
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));


		$model=new Sales();
			$model->unsetAttributes();
			if(isset($_GET['Sales']))
				{	
					// $tracksql="select *from sales where transaction_id='".$tid."'";
		 			 //$track=Yii::app()->db->createCommand($tracksql)->queryAll();
					$model->attributes=$_GET['Sales'];
					//echo $model->transaction_id; die;
					$tid=$model->transaction_id;
					$track=Sales::model()->findAll('transaction_id=:j',array(':j'=>$tid));
				
			$this->render('toreturns',array(
				'model'=>$model,
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				'track'=>$track,
				'tid'=>$tid,
				),false,true);
		}else{
		$this->render('toreturns',array(
			'model'=>$model,
			));
	}
	}

	
	public function actionToreturnsgo()
	{
		$tax=Config::model()->find('id=:l',array(':l'=>1))->tax;
			$discount=Config::model()->find('id=:l',array(':l'=>1))->discount;
			$conf=Config::model()->find('id=:l',array(':l'=>1));

			


		$model=new Sales();
			//$model->unsetAttributes();
				
					// $tracksql="select *from sales where transaction_id='".$tid."'";
		 			 //$track=Yii::app()->db->createCommand($tracksql)->queryAll();
					
					//echo $model->transaction_id; die;
					$tid=$_POST['tid'];
					if(empty($tid)){
						$tid=$_GET['tid'];
					}
					$track=Salesx::model()->findAll('transaction_id=:j',array(':j'=>$tid));
				
			$this->render('toreturns',array(
				'model'=>$model,
				'tax'=>$tax,
				'discount'=>$discount,
				'conf'=>$conf,
				'track'=>$track,
				'tid'=>$tid,
				),false,true);
	
	}

	public function actionDtype()
	{
		$tid=$_POST['tid'];
		$ptype=$_POST['dpt'];
		$get=Sales::model()->findAll('transaction_id=:k',array(':k'=>$tid));
		foreach($get as $g)
		{
			$g->payment_type=$ptype;
			$g->save();
		}
	}


}

// select  DISTINCT(transaction_id), sale_balance, customer_id from sales where customer_id=1 and sale_balance>0